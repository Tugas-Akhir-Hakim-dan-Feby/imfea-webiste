<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Models\User;
use App\Models\Membership;
use App\Http\Requests\API\User\UpdateProfileRequest;
use App\Http\Facades\UploadDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UserController extends Controller
{
    protected $user, $membership;

    public function __construct(User $user, Membership $membership)
    {
        $this->user = $user;
        $this->membership = $membership;
    }

    public function checkProfile()
    {
        $user = $this->user->findOrFail(auth()->user()->id);

        if (!$user->membership) {
            return false;
        }

        return true;
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        DB::beginTransaction();

        $user = $this->user->findOrFail(auth()->user()->id);

        try {
            if ($request->hasFile('image_pas_photo')) {
                $path = str_replace(url('/'), '', $user->membership->pas_photo);
                File::delete(public_path($path));

                $filename = UploadDocument::getFilename($request->file('image_pas_photo'));
                $filename = Str::slug($filename, '_');

                UploadDocument::save(
                    $request->file('image_pas_photo'),
                    $this->membership->pathPasPhoto(),
                    $filename
                );

                $request->merge([
                    "pas_photo" => $this->membership->pathPasPhoto(). "/". $filename
                ]);
            }

            if ($request->hasFile('document_cv')) {
                $path = str_replace(url('/'), '', $user->membership->cv);
                File::delete(public_path($path));

                $filename = UploadDocument::getFilename($request->file('document_cv'));
                $filename = Str::slug($filename, '_');

                UploadDocument::save(
                    $request->file('document_cv'),
                    $this->membership->pathCv(),
                    $filename
                );

                $request->merge([
                    "cv" => $this->membership->pathCv(). "/". $filename
                ]);
            }

            $user->membership()->update($request->except(['email', 'name', 'image_pas_photo', 'document_cv']));
            $user->update($request->all());

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data `" . $user->name . "` berhasil disimpan.", MessageFixer::HTTP_OK);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
