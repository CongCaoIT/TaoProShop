<?php

namespace App\Repositories;

use App\Models\Router;
use App\Repositories\Interfaces\RouterRepositoryInterface;
use App\Repositories\BaseRepository;

class RouterRepository extends BaseRepository implements RouterRepositoryInterface
{
    protected $model;

    public function __construct(Router $model)
    {
        $this->model = $model;
    }

    // Xóa dữ liệu khỏi csdl theo điểu kiện
    public function forceDeleteByCondition($condition = [])
    {
        // Khởi tạo một đối tượng truy vấn mới từ model
        $query = $this->model->newQuery();

        // Thêm điều kiện vào truy vấn
        foreach ($condition as $key => $val) {
            $query->where($val[0], $val[1], $val[2]);
        }

        return $query->forceDelete();
    }
}
