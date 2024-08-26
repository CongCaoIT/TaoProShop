<?php

namespace App\Repositories;

use App\Models\Router;
use App\Repositories\Interfaces\RouterRepositoryInterface;
use App\Repositories\BaseRepository;

class RouterRepository extends BaseRepository
{
    protected $model;

    public function __construct(Router $model)
    {
        $this->model = $model;
    }
}
