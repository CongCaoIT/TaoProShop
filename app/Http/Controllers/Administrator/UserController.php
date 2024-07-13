<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Services\ProvinceService;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;
    protected $provinceService;

    public function __construct(UserService $userService, ProvinceService $provinceService)
    {
        $this->userService = $userService;
        $this->provinceService = $provinceService;
    }

    public function index()
    {
        $users = $this->userService->paginate(); //Gọi func ở tầng Service, nơi xử lý logic

        $config = [
            'js' => [
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'Administrator/css/plugins/switchery/switchery.css'
            ]
        ];

        $config['seo'] = config('apps.user');

        $template = 'Administrator.user.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'users'
        ));
    }

    public function create()
    {
        $provinces = $this->provinceService->getProvince();

        $template = 'Administrator.user.create';

        $config = [
            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'Administrator/library/location.js'
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet'
            ]
        ];

        $config['seo'] = config('apps.user');

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'provinces'
        ));
    }
}
