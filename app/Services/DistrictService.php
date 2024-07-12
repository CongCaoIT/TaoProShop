<?php

namespace App\Services;

use App\Repositories\DistrictRepository;
use App\Services\Interfaces\DistrictServiceInterface;

/**
 * Class DistrictService
 * @package App\Services
 */
class DistrictService implements DistrictServiceInterface
{
    protected $districtRepository;

    public function __construct(DistrictRepository $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    public function getDistrict()
    {
        return $this->districtRepository->all();
    }
}
