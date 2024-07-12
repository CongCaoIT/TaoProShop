<?php

namespace App\Repositories\Interfaces;

interface DistrictRepositoryInterface
{
    public function findDistrictByProvinceID(int $province_id);
}
