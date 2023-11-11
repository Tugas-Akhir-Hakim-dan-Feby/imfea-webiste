<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Auth\NewPasswordRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;

class NewPasswordController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        if (!$request->has('token')) {
            return MessageFixer::warningMessage("Maaf token invalid!", route('web.auth.login.index'));
        }

        if (!$request->has('email')) {
            return MessageFixer::warningMessage("Maaf email invalid!", route('web.auth.login.index'));
        }

        return view('auth.new-password');
    }

    public function process(NewPasswordRequest $request)
    {
        DB::beginTransaction();

        $user = $this->user->whereEmail($request->email)->first();
        if (!$user) {
            return MessageFixer::warningMessage("Maaf akun anda tidak terdaftar!", route('web.auth.login.index'));
        }

        try {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user, $password) {
                    $user->forceFill([
                        'password' => bcrypt($password),
                        'email_verified_at' => Carbon::now()
                    ])->setRememberToken(Str::random(10));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            DB::commit();
            if ($status == Password::PASSWORD_RESET) {
                return MessageFixer::successMessage("Selamat password anda berhasil diubah!", route('web.auth.login.index'));
            } else {
                return MessageFixer::warningMessage("Maaf token sudah kedaluwarsa, silahkan lakukan reset password!", route('web.auth.login.index'));
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.auth.login.index'));
        }
    }
}
