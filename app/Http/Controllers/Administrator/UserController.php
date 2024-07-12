<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $config = $this->config();

        $template = 'Administrator.user.index';

        return view('Administrator.dashboard.layout', compact(
            'template',
            'config'
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
