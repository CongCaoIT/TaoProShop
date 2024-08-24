<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Repositories\AttributeCatalogueRepository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\AttributeCatalogueServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeCatalogueService extends BaseService implements AttributeCatalogueServiceInterface
{
    protected $attributeCatalogueRepository;
    protected $routerRepository;
    protected $nestedset;
    protected $language;
    protected $controllerName = 'AttributeCatalogueController';

    public function __construct(AttributeCatalogueRepository $attributeCatalogueRepository, RouterRepository $routerRepository)
    {
        $this->attributeCatalogueRepository = $attributeCatalogueRepository;
        $this->routerRepository = $routerRepository;
    }

    public function paginate($request, $languageId)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->input('publish');
        $condition['where'] =
            [
                ['tb2.language_id', '=', $languageId]
            ];
        $perpage = $request->input('perpage') != null ? $request->input('perpage') : 20;

        $attributeCatalogues = $this->attributeCatalogueRepository->pagination(
            $this->select(),
            $condition,
            $perpage,
            ['attribute_catalogues.lft', 'ASC'],
            ['path' => 'post/catalogue'],
            [['attribute_catalogue_language as tb2', 'tb2.attribute_catalogue_id', '=', 'attribute_catalogues.id']],
        );
        return $attributeCatalogues;
    }

    public function create($request, $languageId)
    {
        DB::beginTransaction();
        try {
            $attributeCatalogue = $this->createAttributeCatalogue($request);
            if ($attributeCatalogue->id > 0) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $languageId;
                $payloadLanguage['attribute_catalogue_id'] = $attributeCatalogue->id;
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);

                $this->attributeCatalogueRepository->createPivot($attributeCatalogue, $payloadLanguage, 'languages');
                $this->createRouter($attributeCatalogue, $request, $this->controllerName, $languageId);
            }

            $this->nestedset = new Nestedsetbie([
                'table' => 'attribute_catalogues',
                'foreignkey' => 'attribute_catalogue_id',
                'language_id' =>  $languageId,
            ]);
            $this->nestedset($this->nestedset);

            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function update($id, $request, $languageId)
    {
        DB::beginTransaction();
        try {
            $attributeCatalogue = $this->attributeCatalogueRepository->findByID($id);
            $payload = $request->only($this->payload());
            $this->formatAlbum($payload);
            $flag = $this->attributeCatalogueRepository->update($id, $payload);

            if ($flag == TRUE) {
                $payloadLanguage = $request->only($this->payloadLanguage());
                $payloadLanguage['language_id'] = $languageId;
                $payloadLanguage['attribute_catalogue_id'] = $attributeCatalogue->id;
                $payloadLanguage['canonical'] = Str::slug($payloadLanguage['canonical']);
                $attributeCatalogue->languages()->detach([$payloadLanguage['language_id'], $payloadLanguage['attribute_catalogue_id']]);
                $response = $this->attributeCatalogueRepository->createPivot($attributeCatalogue, $payloadLanguage, 'languages');

                $condition = [
                    ['module_id', '=', $id],
                    ['controllers', '=', 'App\Http\Controllers\Frontend\attributeCatalogueController']
                ];

                $router = $this->routerRepository->findByCondition($condition);
                $payloadRouter = $this->payloadRouter($payloadLanguage, $attributeCatalogue);

                $this->routerRepository->update($router->id, $payloadRouter);
            }

            $this->nestedset = new Nestedsetbie([
                'table' => 'attribute_catalogues',
                'foreignkey' => 'attribute_catalogue_id',
                'language_id' =>  $languageId,
            ]);
            $this->nestedset($this->nestedset);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function destroy($id, $languageId)
    {
        DB::beginTransaction();
        try {
            $this->attributeCatalogueRepository->delete($id);
            $this->nestedset = new Nestedsetbie([
                'table' => 'attribute_catalogues',
                'foreignkey' => 'attribute_catalogue_id',
                'language_id' =>  $languageId,
            ]);
            $this->nestedset($this->nestedset);
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

            $this->attributeCatalogueRepository->update($post['modelId'], $payload);
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

            $this->attributeCatalogueRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    private function createAttributeCatalogue($request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::id();
        $this->formatAlbum($payload);
        return $this->attributeCatalogueRepository->create($payload);
    }

    private function payloadRouter($payloadLanguage, $attributeCatalogue)
    {
        $router = [
            'canonical' => $payloadLanguage['canonical'],
            'module_id' => $attributeCatalogue->id,
            'controllers' => 'App\Http\Controllers\Frontend\attributeCatalogueController'
        ];

        return $router;
    }

    private function select()
    {
        return [
            'attribute_catalogues.id',
            'attribute_catalogues.publish',
            'attribute_catalogues.image',
            'attribute_catalogues.level',
            'attribute_catalogues.order',
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
}
