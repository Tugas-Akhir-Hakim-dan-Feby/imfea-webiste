<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function register(Request $request)
    {
        $data = [
            "title" => "Daftar Member"
        ];

        return view('member.register', $data);
    }
}
