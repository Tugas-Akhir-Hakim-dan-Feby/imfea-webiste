<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class MembercardController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __invoke($slug)
    {
        $user = $this->user->whereSlug($slug)->first();
        if (!$user) {
            abort(404);
        }

        $memberId = str_pad(decbin($user->membership->id), 4, '0', STR_PAD_LEFT);

        return view('member.card', compact('user', 'memberId'));
    }
}
