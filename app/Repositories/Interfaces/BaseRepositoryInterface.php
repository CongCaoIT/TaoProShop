<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all();
    public function findByID($modelId, $column, $relation);
    public function create($payload);
    public function update($id, $payload);
    public function delete($id);
}
