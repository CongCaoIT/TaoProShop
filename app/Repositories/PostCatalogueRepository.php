<?php

namespace App\Repositories;

use App\Models\PostCatalogue;
use App\Repositories\Interfaces\PostCatalogueRepositoryInterface;

class PostCatalogueRepository extends BaseRepository implements PostCatalogueRepositoryInterface
{
    protected $model;

    public function __construct(PostCatalogue $model)
    {
        $this->model = $model;
    }

    public function pagination($column = ['*'], $condition = [], $join = [], $perpage = 1, $extend = [], $relation = [], $orderBy = [])
    {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%');
            }
            if (isset($condition['publish']) && $condition['publish'] != -1) {
                $query->where('publish', $condition['publish']);
            }
        });

        if (isset($relation) && !empty($relation)) {
            foreach ($relation as $item) {
                $query->withCount($item);
            }
        }

        if (isset($join) && is_array($join) && count($join)) {
            foreach ($join as $key => $value) {
                $query->join($value[0], $value[1], $value[2], $value[3]);
            }
        }

        if (isset($orderBy) && !empty($orderBy)) {
            $query->orderBy($orderBy[0], $orderBy[1]);
        }

        return $query->paginate($perpage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }
}
