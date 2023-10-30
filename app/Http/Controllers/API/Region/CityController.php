<?php

namespace App\Http\Controllers\API\Region;

use App\Http\Controllers\Controller;
use App\Http\Facades\Region\City;
use App\Http\Resources\Region\City\CityCollection;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index($provinceId)
    {
        $cities = City::get($provinceId);
        return new CityCollection($cities);
    }
}
