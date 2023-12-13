<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Models\User;
use Illuminate\Http\Request;

class MeController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function __invoke(Request $request)
    {
        $user = $this->user->find($request->user()->id);

        $data = [
            "name" => $user->name,
            "email" => $user->email,
            "slug" => $user->slug,
            "email_verified_at" => $user->email_verified_at,
            "role" => $user->invoice ? 'Member Aplikasi' : $user->roles[0]->name,
            "role_id" => $user->invoice ? User::MEMBER_APP : $user->roles[0]->id,
            "is_member" => $user->invoice ? true : false,
        ];

        if ($data['is_member']) {
            $data['nik'] = $user->membership->nin;
            $data['gender'] = $user->membership->gender;
            $data['place_birth'] = $user->membership->place_birth;
            $data['date_birth'] = $user->membership->date_birth;
            $data['citizenship'] = $user->membership->citizenship;
            $data['province'] = $user->membership->province;
            $data['city'] = $user->membership->city;
            $data['postal_code'] = $user->membership->postal_code;
            $data['phone'] = $user->membership->phone;
            $data['address'] = $user->membership->address;
            $data['work_type'] = $user->membership->workType;
            $data['pas_photo'] = url($user->membership->pas_photo);
            $data['cv'] = url($user->membership->cv);
        }

        return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data pribadi anda berhasil diambil!", MessageFixer::HTTP_OK, $data);
    }
}
