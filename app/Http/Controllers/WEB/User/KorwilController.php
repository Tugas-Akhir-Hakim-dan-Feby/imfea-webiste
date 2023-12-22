<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\User\Korwil\CreateRequest;
use App\Http\Requests\WEB\User\Korwil\UpdateRequest;
use App\Models\Regional;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class KorwilController extends Controller
{
    protected $user, $regional;

    public function __construct(User $user, Regional $regional)
    {
        $this->user = $user;
        $this->regional = $regional;
    }

    public function clear(Request $request)
    {
        $regional = $this->regional->first();
        $request->session()->put('page', $regional->id);

        return redirect(route('web.user.korwil.index'));
    }

    public function index(Request $request)
    {
        $users = $this->user->whereHas('roles', function ($query) {
            $query->where('id', User::KORWIL);
        })->whereHas('korwilAssign', function ($query) use ($request) {
            $query->where('regional_id', $request->session()->get('page'));
        })->get();

        $data = [
            "title" => "Koordinator Wilayah",
            "page" => User::KORWIL,
            "users" => $users,
            "regionals" => $this->regional->all()
        ];

        return view("user.korwil.index", $data);
    }

    public function toKorwil(Request $request, $id)
    {
        $request->session()->put('page', $id);

        return redirect(route('web.user.korwil.index'));
    }

    public function create()
    {
        $data = [
            "title" => "Tambah Baru",
            "user" => null,
            "action" => route('web.user.korwil.store'),
            "regionals" => $this->regional->all()
        ];

        return view('user.korwil.form', $data);
    }

    public function store(CreateRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            "password" => Hash::make($request->password)
        ]);

        try {
            $user = $this->user->create($request->all());
            $user->assignRole(Role::findById($this->user::KORWIL, 'web'));
            $user->korwilAssign()->create($request->only('regional_id'));

            DB::commit();
            return MessageFixer::successMessage("selamat data `$user->name` berhasil disimpan.", route('web.user.korwil.to', $request->regional_id));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.user.korwil.create'));
        }
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $korwil)
    {
        $data = [
            "title" => "Edit Korwil",
            "user" => $korwil,
            "action" => route('web.user.korwil.update', $korwil),
            "regionals" => $this->regional->all()
        ];

        return view('user.korwil.form', $data);
    }

    public function update(UpdateRequest $request, User $korwil)
    {
        DB::beginTransaction();

        try {
            $korwil->update($request->all());
            $korwil->korwilAssign()->update($request->only('regional_id'));

            DB::commit();
            return MessageFixer::successMessage("selamat data `$korwil->name` berhasil disimpan.", route('web.user.korwil.to', $request->regional_id));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.user.korwil.edit', $korwil));
        }
    }

    public function destroy(User $korwil)
    {
        DB::beginTransaction();

        try {
            $korwil->korwilAssign()->delete();
            $korwil->delete();

            DB::commit();
            return MessageFixer::successMessage("selamat data `$korwil->name` berhasil disimpan.", route('web.user.korwil.clear'));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.user.korwil.index'));
        }
    }
}
