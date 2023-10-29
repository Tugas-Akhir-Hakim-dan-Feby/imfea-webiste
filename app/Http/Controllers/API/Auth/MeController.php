<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Models\User;
use Illuminate\Http\Request;

class MeController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __invoke(Request $request)
    {
        $user = $this->user->find($request->user()->id);

        $data = [
            "user" => $user,
            "roles" => $user->roles->pluck("name")
        ];

        return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data pribadi anda berhasil diambil!", MessageFixer::HTTP_OK, $data);
    }
}
