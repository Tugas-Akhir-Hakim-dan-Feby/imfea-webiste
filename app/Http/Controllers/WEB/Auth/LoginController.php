<?php

namespace App\Http\Controllers\WEB\Auth;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Requests\WEB\Auth\LoginRequest;
use App\Models\Role;
use App\Models\User;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LoginController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $data = [
            "title" => "Login"
        ];

        return view('auth.login', $data);
    }

    public function process(LoginRequest $request)
    {
        $user = $this->user->whereEmail($request->email)->first();
        if (!$user) {
            return MessageFixer::warningMessage("Maaf akun anda tidak terdaftar!", route('web.auth.login.index'));
        }

        if (!Hash::check($request->password, $user->password)) {
            return MessageFixer::warningMessage("Maaf password anda salah!", route('web.auth.login.index'));
        }

        // if (!File::exists('assets/images/qrcode')) {
        //     File::makeDirectory('assets/images/qrcode');
        // }

        if (Auth::attempt($request->validated())) {
            // if (!File::exists('assets/images/qrcode/' . $user->id . '.png')) {
            //     $renderer = new ImageRenderer(
            //         new RendererStyle(400),
            //         new ImagickImageBackEnd(),
            //     );
            //     $writer = new Writer($renderer);
            //     $writer->writeFile(url('/'), public_path('assets/images/qrcode/' . $user->id . '.png'));
            // }

            $request->session()->regenerate();
            return redirect()->intended("/");
        }
    }
}
