<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function callback(Request $request)
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
                "status" => $request->status == "PAID" ? "Lunas" : 'Dibatalkan',
                "payment_method" => $request->bank_code,
            ]);

            DB::commit();
            return MessageFixer::customApiMessage(MessageFixer::SUCCESS, "selamat invoice #`$invoice->external_id` berhasil disimpan.", MessageFixer::HTTP_OK, $invoice);
        } catch (\Throwable $th) {
            DB::rollback();
            return MessageFixer::customApiMessage(MessageFixer::ERROR, $th->getMessage(), MessageFixer::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
