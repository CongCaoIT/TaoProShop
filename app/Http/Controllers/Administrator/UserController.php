<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->paginate(); //Gọi func ở tầng Service, nơi xử lý logic

        $config = $this->config();

        $template = 'Administrator.user.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config',
            'users'
        ));
    }

    private function config()
    {
        return [
            'js' => [
                'Administrator/js/plugins/switchery/switchery.js'
            ],
            'css' => [
                'Administrator/css/plugins/switchery/switchery.css'
            ]
        ];
    }
}
