<?php

namespace App\Services;

use App\Repositories\LanguageRepository;
use App\Services\Interfaces\BaseServiceInterface;
use App\Services\Interfaces\LanguageServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    public function __construct()
    {
    }

    public function currentLanguage()
    {
        return 1;
    }
}
