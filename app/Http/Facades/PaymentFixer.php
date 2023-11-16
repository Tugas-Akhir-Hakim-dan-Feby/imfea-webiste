<?php

namespace App\Http\Facades;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class PaymentFixer
{
    protected $externalId;
    protected $apiUrlInvoice = "https://api.xendit.co/v2/invoices";
    protected $apiUrlListVA = "https://api.xendit.co/available_virtual_account_banks";
    protected $apiUrlCreateVA = "https://api.xendit.co/callback_virtual_accounts";

    public function __construct()
    {
        $this->externalId = (string) mt_rand(000000000, 999999999);
    }

    public function listVA()
    {
        $response = Http::withHeaders([
            "Authorization" => "Basic " . config('xendit.key_auth')
        ])->get($this->apiUrlListVA);

        return $response->json();
    }

    public function createInvoiceMember($userId, $description, $amount)
    {
        $request = [
            "external_id" => $this->externalId,
            "description" => $description,
            "amount" => $amount,
        ];

        $response = Http::withHeaders([
            "Authorization" => "Basic " . config('xendit.key_auth')
        ])->post($this->apiUrlInvoice, $request);
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

    public function createApiInvoiceMember($user, $params, $amount)
    {
        $request = [
            "external_id" => $this->externalId,
            "expected_amount" => $amount,
            "bank_code" => $params->bank_code,
            "name" => $user->name,
            "is_closed" => true,
            "is_single_use" => true,
            "expiration_date" => Carbon::now()->addDays(1)->toISOString(),
        ];

        $response = Http::withHeaders([
            "Authorization" => "Basic " . config('xendit.key_auth')
        ])->post($this->apiUrlCreateVA, $request);
        $response = $response->object();

        $description = "Membership IMFEA (" . date('d-m-Y') . " - " . Carbon::now()->addYears(3)->isoFormat('DD-MM-YYYY') . ")";

        $invoice = Invoice::create([
            "external_id" => $this->externalId,
            "user_id" => $user->id,
            "amount" => $amount,
            "payment_method" => $params->bank_code,
            "description" => $description,
        ]);

        return $invoice;
    }
}
