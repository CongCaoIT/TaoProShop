<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all();
    public function findByID($modelId, $column, $relation);
    public function create($payload);
    public function update($id, $payload);
    public function updateByWhereIn($whereInField = '', $whereIn = [], $payload = []);
    public function delete($id);
    public function pagination($column = ['*'], $condition = [], $join = [], $perpage = 20, $extend, $relation = []);
}
