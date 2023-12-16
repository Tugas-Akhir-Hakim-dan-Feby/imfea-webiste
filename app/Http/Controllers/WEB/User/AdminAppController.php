<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\WEB\User\AdminApp\CreateRequest;
use App\Http\Requests\WEB\User\AdminApp\UpdateRequest;
use App\Http\Facades\MessageFixer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAppController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->whereHas('roles', function ($query) {
            $query->where('id', User::ADMIN_APP);
        })->get();

        $data = [
            "title" => "Pengguna Admin",
            "page" => User::ADMIN_APP,
            "users" => $users,
        ];

        return view("user.admin_app.index", $data);
    }

    public function create()
    {
        $data = [
            "title" => "Tambah Baru",
            "user" => null,
            "action" => route('web.user.admin-app.store')
        ];

        return view("user.admin_app.form", $data);
    }

    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            "password" => Hash::make($request->password)
        ]);

        try {
            $user = $this->user->create($request->all());
            $user->assignRole(Role::findById($this->user::ADMIN_APP, 'web'));

            DB::commit();
            return MessageFixer::successMessage("selamat data `$user->name` berhasil disimpan.", route('web.user.admin-app.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.user.admin-app.create'));
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $adminApp)
    {
        $data = [
            "title" => "Edit Pengguna",
            "user" => $adminApp,
            "action" => route('web.user.admin-app.update', $adminApp)
        ];

        return view("user.admin_app.form", $data);
    }

    public function update(UpdateRequest $request, User $adminApp)
    {
        DB::beginTransaction();

        try {
            $adminApp->update($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data `$adminApp->name` berhasil disimpan.", route('web.user.admin-app.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.user.admin-app.edit', $adminApp));
        }
    }

    public function destroy(User $adminApp)
    {
        DB::beginTransaction();

        try {
            $adminApp->delete();

            DB::commit();
            return MessageFixer::successMessage("selamat data `$adminApp->name` berhasil dihapus.", route('web.user.admin-app.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.user.admin-app.index'));
        }
    }
}
