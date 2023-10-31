<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class VerificationController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __invoke(Request $request)
    {
        DB::beginTransaction();

        $user = $this->user->whereEmail($request->email)->first();
        if (!$user) {
            return MessageFixer::warningMessage("Maaf akun anda tidak terdaftar!", route('web.auth.login.index'));
        }

        $request->merge([
            "password" => ""
        ]);

        try {
            $status = Password::reset(
                $request->only('email', 'token', 'password'),
                function ($user, $password) {
                    $user->forceFill([
                        'email_verified_at' => Carbon::now()
                    ])->setRememberToken(Str::random(10));

                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            DB::commit();
            if ($status == Password::PASSWORD_RESET) {
                return MessageFixer::successMessage("Selamat akun anda berhasil diverifikasi!", route('web.auth.login.index'));
            } else {
                return MessageFixer::warningMessage("Maaf token sudah kedaluwarsa, silahkan lakukan reset password!", route('web.auth.login.index'));
            }
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.auth.login.index'));
        }
    }
}
