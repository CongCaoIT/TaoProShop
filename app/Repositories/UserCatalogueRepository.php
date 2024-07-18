<?php

namespace App\Repositories;

use App\Models\UserCatalogue;
use App\Repositories\Interfaces\UserCatalogueRepositoryInterface;

class UserCatalogueRepository extends BaseRepository implements UserCatalogueRepositoryInterface
{
    protected $model;

    public function __construct(UserCatalogue $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model::all();
    }

    public function pagination($column = ['*'], $condition = [], $join = [], $perpage = 1, $extend = [], $relation = [])
    {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $condition['keyword'] . '%');
            }
            if (isset($condition['publish']) && $condition['publish'] != -1) {
                $query->orwhere('publish', $condition['publish']);
            }
        });

        if (isset($relation) && !empty($relation)) {
            foreach ($relation as $item) {
                $query->withCount($item);
            }
        }

        if (!empty($join)) {
            $query->join(...$join);
        }

        return $query->paginate($perpage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }
}
