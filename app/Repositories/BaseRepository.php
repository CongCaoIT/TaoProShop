<?php

namespace App\Repositories;

use App\Models\Base;
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
}
