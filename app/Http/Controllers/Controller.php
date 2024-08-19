<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected $language;

    public function __construct()
    {
        $this->language = session('app_locale');
    }

    public function currentLanguage()
    {
        return 1;
    }
}
