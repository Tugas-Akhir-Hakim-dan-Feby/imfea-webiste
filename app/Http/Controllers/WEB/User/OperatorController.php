<?php

namespace App\Http\Controllers\WEB\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\WEB\Operator\CreateRequest;
use App\Http\Facades\MessageFixer;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;

class OperatorController extends Controller
{

    const PER_PAGE = 10;

    protected $user;

    public function __construct(User $users)
    {
        $this->user = $users;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    $user = $this->user->whereHas('roles', function ($query) {
        $query->where('id', User::OPERATOR);
    });

    if (auth()->user()->hasRole(User::OPERATOR)) {
        $user->where('user_id', auth()->user()->id);
    }

    $user = $user->paginate(self::PER_PAGE);

    $data = [
        'title' => "Operator",
        'operator' => $user
    ];

    return view('user.operator.admin_operator', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $data = [
            "title" => "Tambah Operator Baru",
        ];

        return view('user.operator.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            "slug" => Str::slug($request->title . "-" . Str::random(16)),
        ]);
        try{
            $user = User::Create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('Password123!'),
            ]);
            $operator = $this->user->create($request->all());
            $user->assignRole(Role::findById(User::OPERATOR, 'web'));
            return MessageFixer::successMessage("selamat data `$operator->title` berhasil disimpan.", route('web.operator.index'));
        }catch(\Exception $e){
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
