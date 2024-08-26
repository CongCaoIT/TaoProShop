<?php

namespace App\Services;

use App\Repositories\AttributeRepository;

use App\Repositories\RouterRepository;
use App\Services\Interfaces\AttributeServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AttributeService extends BaseService implements AttributeServiceInterface
{
    protected $attributeRepository;
    protected $routerRepository;
    protected $language;
    protected $controllerName = 'AttributeController';

    public function __construct(AttributeRepository $attributeRepository, RouterRepository $routerRepository)
    {
        $this->language = $this->currentLanguage();
        $this->attributeRepository = $attributeRepository;
        $this->routerRepository = $routerRepository;
    }

    public function paginate($request, $languageId)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->input('publish');
        $condition['where'] =
            [
                ['tb2.language_id', '=', $languageId],
            ];
        $perpage = $request->input('perpage') != null ? $request->input('perpage') : 20;

        $attributes = $this->attributeRepository->pagination(
            $this->select(),
            $condition,
            $perpage,
            ['attributes.id', 'DESC'],
            ['path' => 'attribute'],
            [
                ['attribute_language as tb2', 'tb2.attribute_id', '=', 'attributes.id'],
                ['attribute_catalogue_attribute', 'attributes.id', '=', 'attribute_catalogue_attribute.attribute_id'],
            ],
            ['attribute_catalogues'],
            $this->whereRaw($request)
        );
        return $attributes;
    }

    public function create($request, $languageId)
    {
        DB::beginTransaction();
        try {
            $attribute = $this->createAttribute($request);
            if ($attribute->id > 0) {
                $this->updateLanguageForAttribute($attribute, $request);
                $this->updateCatalogueForAttribute($attribute, $request);
                $this->createRouter($attribute, $request, $this->controllerName, $languageId);
            }

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
            $attribute = $this->attributeRepository->findByID($id);
            if ($this->uploadAttribute($attribute->id, $request)) {
                $this->updateLanguageForAttribute($attribute, $request);
                $this->updateCatalogueForAttribute($attribute, $request);
                $this->updateRouter($attribute, $request, $this->controllerName, $languageId);
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
            $this->attributeRepository->delete($id);
            $this->routerRepository->forceDeleteByCondition([
                ['module_id', '=', $id],
                ['controllers', '=', 'App\Http\Controllers\Frontend\\' . $this->controllerName . '']
            ]);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    private function createAttribute($request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::id();
        $payload = $this->formatAlbum($payload);
        $attribute = $this->attributeRepository->create($payload);

        return $attribute;
    }

    private function uploadAttribute($id, $request)
    {
        $payload = $request->only($this->payload());
        $payload['user_id'] = Auth::id();
        $payload = $this->formatAlbum($payload);

        return $this->attributeRepository->update($id, $payload);
    }

    private function updateLanguageForAttribute($attribute, $request)
    {
        $payload = $request->only($this->payloadLanguage());
        $payload = $this->formatLanguagePayload($payload, $attribute->id);
        $attribute->languages()->detach([$this->language, $attribute->id]);

        return $this->attributeRepository->createPivot($attribute, $payload, 'languages');
    }

    private function formatLanguagePayload($payload, $attributeId)
    {
        $payload['language_id'] = $this->language;
        $payload['attribute_id'] = $attributeId;
        $payload['canonical'] = Str::slug($payload['canonical']);

        return $payload;
    }

    private function updateCatalogueForAttribute($attribute, $request)
    {
        $attribute->attribute_catalogues()->sync($this->catalogue($request));
    }

    private function catalogue($request)
    {
        $catalogue = $request->input('catalogue');

        if (!is_array($catalogue)) {
            $catalogue = [];
        }

        return array_unique(array_merge($catalogue, [$request->attribute_catalogue_id]));
    }

    public function updateStatus($attribute = [])
    {
        DB::beginTransaction();
        try {
            $payload[$attribute['field']] = (($attribute['value'] == 1) ? 0 : 1);

            $this->attributeRepository->update($attribute['modelId'], $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function updateStatusAll($attribute = [])
    {
        DB::beginTransaction();
        try {
            $payload[$attribute['field']] = $attribute['value'];

            $this->attributeRepository->updateByWhereIn('id', $attribute['id'], $payload);
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
        $attributeCatalogueId = $request->input('attribute_catalogue_id') != null ? $request->integer('attribute_catalogue_id') : 0;
        if ($attributeCatalogueId > 0) {
            $rawCondition['whereRaw'] = [
                [
                    'attribute_catalogue_attribute.attribute_catalogue_id IN (
                        SELECT id
                        FROM attribute_catalogues
                        JOIN attribute_catalogue_language ON attribute_catalogues.id = attribute_catalogue_language.attribute_catalogue_id
                        WHERE lft >= (SELECT lft FROM attribute_catalogues WHERE attribute_catalogues.id = ?)
                        AND rgt <= (SELECT rgt FROM attribute_catalogues WHERE attribute_catalogues.id = ?)
                    )',
                    [$attributeCatalogueId, $attributeCatalogueId]
                ]
            ];
        }
        return $rawCondition;
    }

    private function select()
    {
        return [
            'attributes.id',
            'attributes.publish',
            'attributes.image',
            'attributes.order',
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
            'attribute_catalogue_id',
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
