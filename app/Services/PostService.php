<?php

namespace App\Services;

use App\Repositories\PostRepository;
use App\Services\Interfaces\PostServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostService extends BaseService implements PostServiceInterface
{
    protected $postRepository;
    protected $language;

    public function __construct(PostRepository $postRepository)
    {
        $this->language = $this->currentLanguage();
        $this->postRepository = $postRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->input('publish');
        $condition['where'] =
            [
                ['tb2.language_id', '=', $this->language],
            ];
        $perpage = $request->input('perpage') != null ? $request->input('perpage') : 20;

        $posts = $this->postRepository->pagination(
            $this->select(),
            $condition,
            $perpage,
            ['posts.id', 'DESC'],
            ['path' => 'post'],
            [
                ['post_language as tb2', 'tb2.post_id', '=', 'posts.id'],
                ['post_catalogue_post', 'posts.id', '=', 'post_catalogue_post.post_id'],
            ],
            ['post_catalogues'],
            $this->whereRaw($request)
        );
        return $posts;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $post = $this->createPost($request);
            if ($post->id > 0) {
                $this->updateLanguageForPost($post, $request);
                $this->updateCatalogueForPost($post, $request);
            }

            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $post = $this->postRepository->findByID($id);
            if ($this->uploadPost($post->id, $request)) {
                $this->updateLanguageForPost($post, $request);
                $this->updateCatalogueForPost($post, $request);
            }

            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $this->postRepository->delete($id);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    private function createPost($request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::id();
        $payload = $this->formatAlbum($payload);
        $post = $this->postRepository->create($payload);

        return $post;
    }

    private function uploadPost($id, $request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::id();
        $payload = $this->formatAlbum($payload);

        return $this->postRepository->update($id, $payload);
    }

    private function updateLanguageForPost($post, $request)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload = $this->formatLanguagePayload($payload, $post->id);
        $post->languages()->detach([$this->language, $post->id]);

        return $this->postRepository->createPivot($post, $payload, 'languages');
    }

    private function formatLanguagePayload($payload, $postId)
    {
        $payload['language_id'] = $this->language;
        $payload['post_id'] = $postId;
        $payload['canonical'] = Str::slug($payload['canonical']);

        return $payload;
    }

    private function updateCatalogueForPost($post, $request)
    {
        $post->post_catalogues()->sync($this->catalogue($request));
    }

    private function formatAlbum($payload)
    {
        if (isset($payload['album'])) {
            $payload['album'] = json_encode($payload['album']);
        }
        return $payload;
    }

    private function catalogue($request)
    {
        $catalogue = $request->input('catalogue');

        if (!is_array($catalogue)) {
            $catalogue = [];
        }

        return array_unique(array_merge($catalogue, [$request->post_catalogue_id]));
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1) ? 0 : 1);

            $this->postRepository->update($post['modelId'], $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function updateStatusAll($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = $post['value'];

            $this->postRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    private function whereRaw($request)
    {
        $rawCondition = [];
        $postCatalogueId = $request->input('post_catalogue_id') != null ? $request->integer('post_catalogue_id') : 0;
        if ($postCatalogueId > 0) {
            $rawCondition['whereRaw'] = [
                [
                    'post_catalogue_post.post_catalogue_id IN (
                        SELECT id
                        FROM post_catalogues
                        JOIN post_catalogue_language ON post_catalogues.id = post_catalogue_language.post_catalogue_id
                        WHERE lft >= (SELECT lft FROM post_catalogues WHERE post_catalogues.id = ?)
                        AND rgt <= (SELECT rgt FROM post_catalogues WHERE post_catalogues.id = ?)
                    )',
                    [$postCatalogueId, $postCatalogueId]
                ]
            ];
        }
        return $rawCondition;
    }

    private function select()
    {
        return [
            'posts.id',
            'posts.publish',
            'posts.image',
            'posts.order',
            'tb2.name',
            'tb2.canonical',
        ];
    }

    private function payload()
    {
        return [
            'publish',
            'follow',
            'image',
            'post_catalogue_id',
            'album'
        ];
    }

    private function payloadLanguage()
    {
        return [
            'name',
            'description',
            'content',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'canonical'
        ];
    }
}
