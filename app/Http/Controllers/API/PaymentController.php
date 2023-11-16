<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Facades\PaymentFixer;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $invoice, $payment, $user;

    public function __construct(Invoice $invoice, User $user)
    {
        $this->user = $user;
        $this->invoice = $invoice;
        $this->payment = new PaymentFixer();
    }

    public function callbackInvoice(Request $request)
    {
        DB::beginTransaction();

        $invoice = $this->invoice->where('external_id', $request->external_id)->first();
        if (!$invoice) {
            return MessageFixer::customApiMessage(
                MessageFixer::WARNING,
                "invoice not found!",
                MessageFixer::HTTP_NOT_FOUND
            );
        }

        try {
            if ($request->status == "PAID") {
                $invoice->update([
                    "status" => $this->invoice::SUCCESS,
                    "payment_method" => $request->bank_code,
                ]);
            } else {
                $invoice->update([
                    "recreated_at" => now(),
                    "status" => $this->invoice::CANCEL
                ]);
                $invoice = $this->payment->createInvoiceMember(auth()->user()->id, $request->description, $request->amount, true);
            }

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat invoice #`$invoice->external_id` berhasil disimpan.", MessageFixer::HTTP_OK, $invoice);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function callbackSuccessFva(Request $request)
    {
        DB::beginTransaction();

        $invoice = $this->invoice->where('external_id', $request->external_id)->first();
        if (!$invoice) {
            return MessageFixer::customApiMessage(
                MessageFixer::WARNING,
                "invoice not found!",
                MessageFixer::HTTP_NOT_FOUND
            );
        }

        try {
            $invoice->update([
                "status" => $this->invoice::SUCCESS,
            ]);

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat invoice #`$invoice->external_id` berhasil disimpan.", MessageFixer::HTTP_OK, $invoice);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function callbackRecreatedFva(Request $request)
    {
        DB::beginTransaction();

        $invoice = $this->invoice->where('external_id', $request->external_id)->first();
        if (!$invoice) {
            return MessageFixer::customApiMessage(
                MessageFixer::WARNING,
                "invoice not found!",
                MessageFixer::HTTP_NOT_FOUND
            );
        }

        $request->merge([
            "bank_code" => $invoice->payment_method
        ]);

        try {
            if ($request->status == "INACTIVE") {
                $invoice->update([
                    "status" => $this->invoice::CANCEL,
                    "recreated_at" => now()
                ]);
                $invoice = $this->payment->createApiInvoiceMember($invoice->user, $request, $invoice->amount, true);
            }

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat invoice #`$invoice->external_id` berhasil disimpan.", MessageFixer::HTTP_OK, $invoice);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
