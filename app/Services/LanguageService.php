<?php

namespace App\Services;

use App\Repositories\LanguageRepository;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\LanguageServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Class UserService
 * @package App\Services
 */
class LanguageService implements LanguageServiceInterface
{
    protected $languageRepository;
    protected $routerRepository;

    public function __construct(LanguageRepository $languageRepository, RouterRepository $routerRepository)
    {
        $this->languageRepository = $languageRepository;
        $this->routerRepository = $routerRepository;
    }

    public function paginate($request)
    {
        $condition['keyword'] = addslashes($request->input('keyword'));
        $condition['publish'] = $request->input('publish');
        $perpage = $request->input('perpage') != null ? $request->input('perpage') : 20;

        //Xử lý logic
        $languages = $this->languageRepository->pagination(
            [
                'id',
                'name',
                'canonical',
                'publish',
                'description',
                'image' //Select
            ],
            $condition, //Keyword
            [], //Join table
            $perpage, //Page
            ['path' => 'language'], //Path URL
        );

        return $languages;
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->except(['_token', 'send']);
            $payload['user_id'] = Auth::id();
            $this->languageRepository->create($payload);
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
            $payload = $request->except(['_token', 'send']);

            $this->languageRepository->update($id, $payload);
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
            $this->languageRepository->delete($id);
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

            $this->languageRepository->update($post['modelId'], $payload);
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

            $this->languageRepository->updateByWhereIn('id', $post['id'], $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function switch($id)
    {
        DB::beginTransaction();
        try {
            $language = $this->languageRepository->update($id, ['current' => 1]);
            $payload = ['current' => 0];
            $where = [['id', '!=', $id],];
            $this->languageRepository->updateByWhere($where, $payload);
            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }

    public function saveTranslate($translateRequest)
    {
        DB::beginTransaction();
        try {
            $option = $translateRequest->input('option');
            $payload = [
                'name' => $translateRequest->input('translate_name'),
                'description' => $translateRequest->input('translate_description'),
                'content' => $translateRequest->input('translate_content'),
                'meta_title' => $translateRequest->input('translate_meta_title'),
                'meta_keyword' => $translateRequest->input('translate_meta_keyword'),
                'meta_description' => $translateRequest->input('translate_meta_description'),
                'canonical' => $translateRequest->input('translate_canonical'),
                $this->convertModelToField($option['model']) => $option['id'],
                'language_id' => $option['languageId']
            ];
            $controllerName = $option['model'] . 'Controller';
            $repositoryNamespace = '\App\Repositories\\' . ucfirst($option['model']) . 'Repository';
            if (class_exists($repositoryNamespace)) {
                $repositoryInstance = app($repositoryNamespace);
            }
            $model = $repositoryInstance->findByID($option['id']);
            $model->languages()->detach($option['languageId'], $model->id);
            $repositoryInstance->createPivot($model, $payload, 'languages');

            $this->routerRepository->forceDeleteByCondition([
                ['module_id', '=', $option['id']],
                ['controllers', '=', 'App\Http\Controllers\Frontend\\' . $controllerName . ''],
                ['language_id', '=', $option['languageId']]
            ]);

            $router = [
                'canonical' => Str::slug($translateRequest->input('translate_canonical')),
                'module_id' => $model->id,
                'controllers' => 'App\Http\Controllers\Frontend\\' . $controllerName . '',
                'language_id' => $option['languageId'],
            ];
            $this->routerRepository->create($router);

            DB::commit();
            return true;
        } catch (Exception $ex) {
            DB::rollBack();
            echo $ex->getMessage();
            die();
        }
    }
    private function convertModelToField($model)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $model)) . '_id';
    }
}
