<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\API\Auth\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected $user, $role;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->role = $role;
    }

    public function __invoke(RegisterRequest $request)
    {
        DB::beginTransaction();

        $role = $this->role->findById($this->user::MEMBER, 'web');

        $request->merge([
            "password" => Hash::make($request->password),
            "slug" => Str::slug($request->name . ' ' . mt_rand(000000, 999999))
        ]);

        try {
            $user = $this->user->create($request->all());
            $user->assignRole($role);

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "Selamat akun anda berhasil disimpan!", MessageFixer::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
