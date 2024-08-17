<?php

namespace App\Services;

use App\Classes\Nestedsetbie;
use App\Services\Interfaces\BaseServiceInterface;

/**
 * Class UserService
 * @package App\Services
 */
class BaseService implements BaseServiceInterface
{
    public function __construct() {}

    public function currentLanguage()
    {
        return 1;
    }

    public function formatAlbum($payload)
    {
        if (isset($payload['album'])) {
            $payload['album'] = json_encode($payload['album']);
        }
        return $payload;
    }
}
