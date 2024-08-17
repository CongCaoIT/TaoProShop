<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Repositories\PostCatalogueRepository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\PostCatalogueServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostCatalogueService extends BaseService implements PostCatalogueServiceInterface
{
    protected $postCatalogueRepository;
    protected $routerRepository;
    protected $nestedsetbie;
    protected $language;

    public function __construct(PostCatalogueRepository $postCatalogueRepository, RouterRepository $routerRepository)
    {
        $this->language = $this->currentLanguage();
        $this->postCatalogueRepository = $postCatalogueRepository;
        $this->routerRepository = $routerRepository;
        $this->nestedsetbie = new Nestedsetbie([
            'table' => 'post_catalogues',
            'foreignkey' => 'post_catalogue_id',
            'language_id' => $this->language
        ]);
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


        $postCatalogues = $this->postCatalogueRepository->pagination(
            $this->select(),
            $condition,
            $perpage,
            ['post_catalogues.lft', 'ASC'],
            ['path' => 'post/catalogue'],
            [['post_catalogue_language as tb2', 'tb2.post_catalogue_id', '=', 'post_catalogues.id']],
        );
        return $postCatalogues;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $postCatalogue = $this->createPostCatalogue($request);
            if ($postCatalogue->id > 0) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_catalogue_id'] = $postCatalogue->id;
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

                $this->postCatalogueRepository->createPivot($postCatalogue, $payloadLanguage, 'languages');
                $router = $this->payloadRouter($payloadLanguage, $postCatalogue);

                $this->routerRepository->create($router);
            }

            $this->nestedsetCustom();
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
            $postCatalogue = $this->postCatalogueRepository->findByID($id);
            $payload = $request->only($this->payload());
            $this->formatAlbum($payload);
            $flag = $this->postCatalogueRepository->update($id, $payload);

            if ($flag == TRUE) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $this->currentLanguage();
                $payloadLanguage['post_catalogue_id'] = $postCatalogue->id;
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $postCatalogue->languages()->detach([$payloadLanguage['language_id'], $payloadLanguage['post_catalogue_id']]);
                $response = $this->postCatalogueRepository->createPivot($postCatalogue, $payloadLanguage, 'languages');

                $condition = [
                    ['module_id', '=', $id],
                    ['controllers', '=', 'App\Http\Controllers\Frontend\PostCatalogueController']
                ];

                $router = $this->routerRepository->findByCondition($condition);
                $payloadRouter = $this->payloadRouter($payloadLanguage, $postCatalogue);

                $this->routerRepository->update($router->id, $payloadRouter);
            }

            $this->nestedsetCustom();
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
            $this->postCatalogueRepository->delete($id);
            $this->nestedsetCustom();
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function updateStatus($post = [])
    {
        DB::beginTransaction();
        try {
            $payload[$post['field']] = (($post['value'] == 1) ? 0 : 1);

            $this->postCatalogueRepository->update($post['modelId'], $payload);
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

            $this->postCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    private function createPostCatalogue($request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::id();
        $this->formatAlbum($payload);
        return $this->postCatalogueRepository->create($payload);
    }

    private function payloadRouter($payloadLanguage, $postCatalogue)
    {
        $router = [
            'canonical' => $payloadLanguage['canonical'],
            'module_id' => $postCatalogue->id,
            'controllers' => 'App\Http\Controllers\Frontend\PostCatalogueController'
        ];

        return $router;
    }

    private function select()
    {
        return [
            'post_catalogues.id',
            'post_catalogues.publish',
            'post_catalogues.image',
            'post_catalogues.level',
            'post_catalogues.order',
            'tb2.name',
            'tb2.canonical',
        ];
    }

    private function payload()
    {
        return [
            'parentid',
            'publish',
            'follow',
            'image',
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

    private function nestedsetCustom()
    {
        $this->nestedsetbie->Get('level ASC, order ASC');
        $this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
        $this->nestedsetbie->Action();
    }
}
