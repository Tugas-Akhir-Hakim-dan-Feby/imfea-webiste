<?php

namespace App\Http\Facades;

use App\Models\Invoice;
use Illuminate\Support\Facades\Http;
use Xendit\Configuration;
use Xendit\Invoice\InvoiceApi;
use Xendit\XenditSdkException;

class PaymentFixer
{
    protected $externalId;
    protected $apiUrl = "https://api.xendit.co/v2/invoices";

    public function __construct()
    {
        $this->externalId = (string) mt_rand(000000000, 999999999);
    }

    public function createInvoiceMember($userId, $description, $amount)
    {
        $request = [
            "external_id" => $this->externalId,
            "description" => $description,
            "amount" => $amount,
            'success_redirect_url' => route('web.invoice.show', $this->externalId)
        ];

        $response = Http::withHeaders([
            "Authorization" => "Basic " . config('xendit.key_auth')
        ])->post($this->apiUrl, $request);
        $response = $response->object();

        $invoice = Invoice::create([
            "external_id" => $this->externalId,
            "user_id" => $userId,
            "payment_url" => $response->invoice_url,
            "amount" => $amount,
            "description" => $description,
        ]);

        return $invoice;
    }
}
