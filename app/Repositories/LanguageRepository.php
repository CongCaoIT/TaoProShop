<?php

namespace App\Repositories;

use App\Models\Language;
use App\Repositories\Interfaces\LanguageRepositoryInterface;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    protected $model;

    public function __construct(Language $model)
    {
        $this->model = $model;
    }

    public function pagination(
        $column = ['*'],
        $condition = [],
        $perpage = 1,
        $orderBy = ['id', 'DESC'],
        $extend = [],
        $join = [],
        $relation = [],
        $rawQuery = []
    ) {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $condition['keyword'] . '%');
            }
        });

        if (isset($condition['publish']) && $condition['publish'] != -1) {
            $query->where('publish', $condition['publish']);
        }

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
