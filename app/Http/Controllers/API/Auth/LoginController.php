<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __invoke(LoginRequest $request)
    {
        DB::beginTransaction();

        $user = $this->user->whereEmail($request->email)->first();
        if (!$user) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf akun anda belum terdaftar!", MessageFixer::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!Hash::check($request->password, $user->password)) {
            return MessageFixer::customApiMessage(MessageFixer::WARNING, "maaf password anda salah!", MessageFixer::HTTP_UNPROCESSABLE_ENTITY);
        }

        $role = $user->roles->pluck('name');

        try {
            $token = $user->createToken('api', $role->toArray())->plainTextToken;

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat anda berhasil login!", MessageFixer::HTTP_OK, $user, true, $token);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
