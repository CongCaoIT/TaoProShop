<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\DistrictRepository;
use App\Repositories\ProvinceRepository;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $districtRepository;
    protected $provinceRepository;

    public function __construct(DistrictRepository $districtRepository, ProvinceRepository $provinceRepository)
    {
        $this->districtRepository = $districtRepository;
        $this->provinceRepository = $provinceRepository;
    }

    public function getLocation(Request $request)
    {
        $get = $request->input();
        $html = '';

        if ($get['target'] == 'districts') {
            $province = $this->provinceRepository->findByID($get['data']['location_id'], ['code', 'name'], ['districts']);
            $html = $this->renderHTML($province->districts);
        } else if ($get['target'] == 'wards') {
            $district = $this->districtRepository->findByID($get['data']['location_id'], ['code', 'name'], ['wards']);
            $html = $this->renderHTML($district->wards, '[Chọn Phường/Xã]');
        }

        $response = [
            'html' => $html
        ];
        return response()->json($response);
    }

    public function renderHTML($districts, $root = '[Chọn Quận/Huyện]')
    {
        $html = '<option value="0">' . $root . '</option>';
        foreach ($districts as $district) {
            $html .= '<option value="' . $district['code'] . '">' . $district['name'] . '</option>';
        }
        return $html;
    }
}
