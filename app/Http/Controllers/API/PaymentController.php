<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Facades\MessageFixer;
use App\Http\Facades\PaymentFixer;
use App\Models\Invoice;
use App\Models\User;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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

                $this->generateMembercard($invoice->user);
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

            $this->generateMembercard($invoice->user);

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

    protected function generateMembercard($user)
    {
        if (!File::exists('assets/images/qrcode')) {
            File::makeDirectory('assets/images/qrcode');
        }

        if (!File::exists('assets/images/qrcode/' . $user->id . '.png')) {
            $renderer = new ImageRenderer(
                new RendererStyle(400),
                new ImagickImageBackEnd(),
            );
            $writer = new Writer($renderer);
            $writer->writeFile(route('web.membercard', $user->slug), public_path('assets/images/qrcode/' . $user->id . '.png'));
        }
    }
}
