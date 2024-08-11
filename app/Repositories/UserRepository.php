<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function pagination(
        $column = ['*'],
        $condition = [],
        $join = [],
        $perpage = 1,
        $extend = [],
        $relation = [],
        $orderBy = [],
        $rawQuery = []
    ) {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('email', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('address', 'LIKE', '%' . $condition['keyword'] . '%')
                    ->orWhere('phone', 'LIKE', '%' . $condition['keyword'] . '%');
            }
        })->with('user_catalogues');

        if (isset($condition['publish']) && $condition['publish'] != -1) {
            $query->where('publish', $condition['publish']);
        }

        if (isset($condition['user_catalogue_id']) && $condition['user_catalogue_id'] != 0) {
            $query->where('user_catalogue_id', $condition['user_catalogue_id']);
        }
        if (!empty($join)) {
            $query->join(...$join);
        }

        return $query->paginate($perpage)->withQueryString()->withPath(env('APP_URL') . $extend['path']);
    }
}
