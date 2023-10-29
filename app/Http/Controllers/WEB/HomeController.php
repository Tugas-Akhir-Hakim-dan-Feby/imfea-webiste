<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $data = [
            "title" => "Dashboard"
        ];

        return view('home.index', $data);
    }
}
