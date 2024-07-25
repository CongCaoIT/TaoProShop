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
