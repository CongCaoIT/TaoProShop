<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function getAllPaginate()
    {
        return User::paginate(15); //Đọc dữ liệu trong bảng
    }
}
