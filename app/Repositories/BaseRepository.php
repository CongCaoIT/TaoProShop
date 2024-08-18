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
    public function all($relation = [])
    {
        return $this->model->with($relation)->get();
    }

    public function findByID($modelID, $column = ['*'], $relation = [])
    {
        return $this->model->select($column)->with($relation)->findOrFail($modelID);
    }

    public function findByCondition($condition = [])
    {
        $query = $this->model->newQuery();
        foreach ($condition as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }
        return $query->first();
    }

    public function create($payload = [])
    {
        $model = $this->model->create($payload);
        return $model->refresh();
    }

    public function createPivot($model, $payload = [], $relation = '')
    {
        return $model->languages()->attach($model->id, $payload);
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

    public function updateByWhere($where = [], $payload = [])
    {
        $query = $this->model->newQuery();
        foreach ($where as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }
        return $query->update($payload);
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
        $query = $this->model->select($column)->distinct();

        return $query
            ->keyword($condition['keyword'] ?? null)
            ->publish($condition['publish'] ?? -1)
            ->customWhere($condition['where'] ?? null)
            ->customWhereRaw($rawQuery['whereRaw'] ?? null)
            ->relationCount($relation ?? null)
            ->relation($relation ?? null)
            ->customJoin($join ?? null)
            ->customGroupBy($extend['groupBy'] ?? null)
            ->customOrderBy($orderBy ?? null)
            ->paginate($perpage)
            ->withQueryString()
            ->withPath(env('APP_URL') . $extend['path']);;
    }
}
