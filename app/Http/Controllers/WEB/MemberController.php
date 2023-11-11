<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Facades\PaymentFixer;
use App\Http\Facades\Region\Province;
use App\Http\Facades\UploadDocument;
use App\Http\Requests\WEB\Member\RegisterRequest;
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

    public function index()
    {
        $data = [
            "title" => "Data Profil Member",
            "provinces" => Province::get(),
            "work_types" => $this->workType->all()
        ];

        return view('member.register', $data);
    }

    public function process(RegisterRequest $request)
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

            $description = "Membership IMFEA (" . date('d-m-Y') . " - " . Carbon::now()->addYears(3)->isoFormat('DD-MM-YYYY') . ")";
            $payment = $this->payment->createInvoiceMember(auth()->user()->id, $description, 1000000);

            $this->membership->create($request->all());
            DB::commit();
            return MessageFixer::successMessage("selamat data anda berhasil disimpan. silahkan lakukan pembayaran!", route('web.invoice.show', ["externalId" => $payment->external_id]));
        } catch (\Throwable $th) {
            DB::rollBack();
            return MessageFixer::dangerMessage($th->getMessage(), route('web.member.register.index'));
        }
    }
}
