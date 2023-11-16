<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Facades\PaymentFixer;
use App\Http\Facades\UploadDocument;
use App\Http\Requests\API\Member\RegisterRequest;
use App\Models\Membership;
use App\Models\WorkType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MemberController extends Controller
{
    protected $workType, $membership, $payment;

    public function __construct(WorkType $workType, Membership $membership)
    {
        $this->workType = $workType;
        $this->membership = $membership;
        $this->payment = new PaymentFixer();
    }

    public function register(RegisterRequest $request)
    {
        DB::beginTransaction();

        $request->merge([
            "user_id" => auth()->user()->id,
        ]);

        try {
            if ($request->hasFile('image_pas_photo')) {
                $filename = UploadDocument::getFilename($request->file('image_pas_photo'));
                UploadDocument::save(
                    $request->file('image_pas_photo'),
                    $this->membership->pathPasPhoto(),
                    $filename
                );

                $request->merge([
                    "pas_photo" => $filename
                ]);
            }

            if ($request->hasFile('document_cv')) {
                $filename = UploadDocument::getFilename($request->file('document_cv'));
                UploadDocument::save(
                    $request->file('document_cv'),
                    $this->membership->pathCv(),
                    $filename
                );

                $request->merge([
                    "cv" => $filename
                ]);
            }

            $membership = $this->membership->create($request->all());

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data `" . $membership->user->name . "` berhasil disimpan.", MessageFixer::HTTP_CREATED, $membership);
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
