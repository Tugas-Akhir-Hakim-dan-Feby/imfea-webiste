<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $data = [
            "title" => "Register"
        ];

        return view('auth.register', $data);
    }

    public function process(RegisterRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            "password" => Hash::make($request->password)
        ]);

        try {
            $user = $this->user->create($request->all());
            $user->assignRole(Role::findById($this->user::MEMBER, 'web'));

            DB::commit();
            return MessageFixer::successMessage("Selamat akun anda berhasil disimpan!", route('web.auth.login.index'));
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.auth.register.index'));
        }
    }
}
