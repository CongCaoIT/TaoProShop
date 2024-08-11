<?php

namespace App\Services;

use App\Repositories\ProvinceRepository;
use App\Services\Interfaces\ProvinceServiceInterface;

/**
 * Class ProvinceService
 * @package App\Services
 */
class ProvinceService implements ProvinceServiceInterface
{
    protected $provinceRepository;

    public function __construct(ProvinceRepository $provinceRepository)
    {
        $this->provinceRepository = $provinceRepository;
    }

    public function getProvince()
    {
        return $this->provinceRepository->all();
    }
}
