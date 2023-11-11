<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('auth.reset-password');
    }

    public function process(ResetPasswordRequest $request)
    {
        $user = $this->user->whereEmail($request->email)->first();
        if (!$user) {
            return MessageFixer::warningMessage("Maaf akun anda tidak terdaftar!", route('web.auth.reset-password.index'));
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status == Password::RESET_LINK_SENT) {
            return MessageFixer::successMessage("Reset password berhasil, silahkan periksa email anda untuk melakukan ubah password!", route('web.auth.reset-password.index'));
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)]
        ]);
    }
}
