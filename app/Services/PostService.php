<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Repositories\PostRepository;
use App\Services\Interfaces\PostServiceInterface;
use Exception;
use Flasher\Laravel\Http\Request;
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
                ['tb2.language_id', '=', $this->language]
            ];
        $perpage = $request->input('perpage') != null ? $request->input('perpage') : 20;


        $posts = $this->postRepository->pagination(
            $this->select(),
            $condition,
            $perpage,
            ['posts.id', 'DESC'],
            ['path' => 'post/catalogue'],
            [['post_language as tb2', 'tb2.post_id', '=', 'posts.id']],
        );
        return $posts;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only($this->payload());
            $payload['user_id'] = Auth::id();
            if (isset($payload['album'])) {
                $payload['album'] = json_encode($payload['album']);
            }
            $post = $this->postRepository->create($payload);
            if ($post->id > 0) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_id'] = $post->id;
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $this->postRepository->createPivot($post, $payloadLanguage, 'languages');
                $catalogue = $this->catalogue($request);
                $post->post_catalogues()->sync($catalogue);
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
            $payload = $request->only($this->payload());
            if (isset($payload['album'])) {
                $payload['album'] = json_encode($payload['album']);
            }
            $flag = $this->postRepository->update($id, $payload);

            if ($flag == TRUE) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_catalogue_id'] = $id;
                $post->languages()->detach([$payloadLanguage['language_id'], $payloadLanguage['post_catalogue_id']]);
                $response = $this->postRepository->createPivot($post, $payloadLanguage);
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

    private function catalogue($request)
    {
        return array_unique(array_merge($request->input('catalogue'), [$request->post_catalogue_id]));
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

    private function select()
    {
        return [
            'posts.id',
            'posts.publish',
            'posts.image',
            'posts.level',
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
