<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KorwilController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function clear(Request $request)
    {
        $request->session()->forget('page');

        return redirect(route('web.user.korwil.index'));
    }

    public function index()
    {
        $users = $this->user->whereHas('roles', function ($query) {
            $query->where('id', User::KORWIL);
        })->get();

        $data = [
            "title" => "Koordinator Wilayah",
            "page" => User::KORWIL,
            "users" => $users,
        ];

        return view("user.korwil.index", $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        //
    }

    public function edit(User $user)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $user)
    {
        //
    }
}
