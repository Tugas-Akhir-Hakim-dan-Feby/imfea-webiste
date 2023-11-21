<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\GenerateBackground;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = $this->user->find(auth()->user()->id);

        $data = [
            "title" => "Profil Saya",
            "user" => $user
        ];

        return view('profile.index', $data);
    }
}
