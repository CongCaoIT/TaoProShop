<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function all()
    {
        return $this->model::all();
    }

    public function findByID($modelID, $column = ['*'], $relation = [])
    {
        return $this->model->select($column)->with($relation)->findOrFail($modelID);
    }

    public function create($payload = [])
    {
        $model = $this->model->create($payload);
        return $model->refresh();
    }

    public function update($id, $payload = [])
    {
        $model = $this->findByID($id);
        return $model->update($payload);
    }

    public function updateByWhereIn($whereInField = '', $whereIn = [], $payload = [])
    {
        return $this->model->whereIn($whereInField, $whereIn)->update($payload);
    }

    //Xóa mềm
    public function delete($id)
    {
        return $this->findByID($id)->delete();
    }

    //Xóa cứng
    public function forceDelete($id)
    {
        return $this->findByID($id)->forceDelete();
    }

    public function pagination($column = ['*'], $condition = [], $join = [], $perpage = 1, $extend = [], $relation = [], $orderBy = [])
    {
        $query = $this->model->select($column)->where(function ($query) use ($condition) {
            if (isset($condition['keyword']) && !empty($condition['keyword'])) {
                $query->where('name', 'LIKE', '%' . $condition['keyword'] . '%');
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


    public function createLanguagePivot($model, $payload = [])
    {
        return $model->languages()->attach($model->id, $payload);
    }
}
