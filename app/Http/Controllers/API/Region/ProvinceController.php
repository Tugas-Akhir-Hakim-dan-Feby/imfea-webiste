<?php

namespace App\Http\Controllers\API\Region;

use App\Http\Controllers\Controller;
use App\Http\Facades\Region\Province;
use App\Http\Resources\Region\Province\ProvinceCollection;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::get();
        return new ProvinceCollection($provinces);
    }
}
