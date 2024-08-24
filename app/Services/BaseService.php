<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Repositories\RouterRepository;
use App\Services\Interfaces\BaseServiceInterface;
use Illuminate\Support\Str;

class BaseService implements BaseServiceInterface
{
    protected $routerRepository;

    public function __construct(RouterRepository $routerRepository)
    {
        $this->routerRepository = $routerRepository;
    }
    public function currentLanguage()
    {
        return 1;
    }

    public function nestedset($nestedset)
    {
        // tính giá trị left, right bằng Nestedsetbie (có sẵn)
        $nestedset->Get('level ASC, order ASC');
        $nestedset->Recursive(0, $nestedset->Set());
        $nestedset->Action();
    }

    public function formatAlbum($payload)
    {
        if (isset($payload['album'])) {
            $payload['album'] = json_encode($payload['album']);
        }
        return $payload;
    }

    public function createRouter($model, $request, $controllerName, $languageId)
    {
        $payload = $this->formatRouterPayload($model, $request, $controllerName, $languageId);
        return $this->routerRepository->create($payload);
    }

    public function formatRouterPayload($model, $request, $controllerName, $languageId)
    {
        return [
            'canonical' => Str::slug($request->input('canonical')), //chuyển đổi một chuỗi văn bản thành dạng mà có thể sử dụng được trong URL
            'module_id' => $model->id,
            'controllers' => 'App\Http\Controllers\Frontend\\' . $controllerName . '',
            'language_id' => $languageId,
        ];
    }
}
