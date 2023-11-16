<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Facades\PaymentFixer;
use App\Http\Requests\API\Xendit\CreateVaRequest;
use App\Http\Resources\Xendit\VAListCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class XenditController extends Controller
{
    protected $payment;

    public function __construct()
    {
        $this->payment = new PaymentFixer();
    }

    public function listVA()
    {
        $listVa = $this->payment->listVA();

        return new VAListCollection($listVa);
    }

    public function createVA(CreateVaRequest $request)
    {
        DB::beginTransaction();

        try {
            $payment = $this->payment->createApiInvoiceMember(auth()->user(), $request, 1000000);
            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat data berhasil disimpan.", MessageFixer::HTTP_CREATED, $payment);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
