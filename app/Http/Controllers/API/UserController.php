<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function checkProfile()
    {
        $user = $this->user->findOrFail(auth()->user()->id);

        if (!$user->membership) {
            return false;
        }

        return true;
    }
}
