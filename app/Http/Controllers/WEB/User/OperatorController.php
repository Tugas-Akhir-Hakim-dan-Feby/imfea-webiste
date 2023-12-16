<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Facades\MessageFixer;
use App\Models\User;
use App\Models\Role;
use App\Http\Requests\WEB\User\Operator\CreateRequest;
use App\Http\Requests\WEB\User\Operator\UpdateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Enums\RoleEnum;
use Illuminate\Support\Str;

class OperatorController extends Controller
{

    const PER_PAGE = 10;

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->whereHas('roles', function ($query) {
            $query->where('id', User::OPERATOR);
        })->get();

        $data = [
            'title' => "Pengguna Operator",
            'page' => User::OPERATOR,
            'users' => $users,
        ];

        return view('user.operator.index', $data);
    }

    public function create()
    {

        $data = [
            "title" => "Tambah Baru",
            "user" => null,
            "action" => route('web.user.operator.store')
        ];

        return view('user.operator.form', $data);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->merge([
            "password" => Hash::make($request->password)
        ]);

        try {
            $user = $this->user->create($request->all());
            $user->assignRole(Role::findById($this->user::OPERATOR, 'web'));

            DB::commit();
            return MessageFixer::successMessage("selamat data `$user->name` berhasil disimpan.", route('web.user.operator.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.user.operator.create'));
        }
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $operator)
    {
        $data = [
            "title" => "Edit Pengguna",
            "user" => $operator,
            "action" => route('web.user.operator.update', $operator)
        ];

        return view("user.operator.form", $data);
    }

    public function update(UpdateRequest $request, User $operator)
    {
        DB::beginTransaction();

        try {
            $operator->update($request->all());

            DB::commit();
            return MessageFixer::successMessage("selamat data `$operator->name` berhasil disimpan.", route('web.user.operator.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.user.operator.edit', $operator));
        }
    }

    public function destroy(User $operator)
    {
        DB::beginTransaction();

        try {
            $operator->delete();

            DB::commit();
            return MessageFixer::successMessage("selamat data `$operator->name` berhasil dihapus.", route('web.user.operator.index'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.user.operator.index'));
        }
    }
}
