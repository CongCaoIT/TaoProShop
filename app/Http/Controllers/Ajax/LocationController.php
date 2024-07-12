<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\DistrictRepositoryInterface;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $districtRepository;

    public function __construct(DistrictRepositoryInterface $districtRepository)
    {
        $this->districtRepository = $districtRepository;
    }

    public function getLocation(Request $request)
    {
        $provinceID = $request->input('province_id');
        $districts = $this->districtRepository->findDistrictByProvinceID($provinceID);

        $response = [
            'html' => $this->renderHTML($districts)
        ];
        return response()->json($response);
    }

    public function renderHTML($districts)
    {
        $html = '<option value="0">[Chọn Quận/Huyện]</option>';
        foreach ($districts as $district) {
            $html .= '<option value="' . $district->code . '">' . $district->name . '</option>';
        }
        return $html;
    }
}
