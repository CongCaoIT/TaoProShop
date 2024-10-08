<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all($relation = []);
    public function findByID($modelId, $column, $relation);
    public function create($payload);
    public function update($id, $payload);
    public function updateByWhereIn($whereInField = '', $whereIn = [], $payload = []);
    public function delete($id);
    public function pagination(
        $column = ['*'],
        $condition = [],
        $perpage = 1,
        $orderBy = ['id', 'DESC'],
        $extend = [],
        $join = [],
        $relation = [],
        $rawQuery = []
    );
    public function createPivot($model, $payload = [], $relation = '');
}
