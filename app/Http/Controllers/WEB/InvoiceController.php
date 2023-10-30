<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Facades\PaymentFixer;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function index()
    {
        $invoices = $this->invoice->where(function ($query) {
            if (auth()->user()->isMember()) {
                $query->where('user_id', auth()->user()->id);
            }
        })->paginate(10);

        $data = [
            "title" => "Tagihan Saya",
            "invoices" => $invoices
        ];

        return view('invoice.index', $data);
    }

    public function show($externalId)
    {
        $invoice = $this->invoice->where('external_id', $externalId)->first();
        if (!$invoice) {
            abort(404);
        }

        $data = [
            "title" => "Detail Tagihan",
            "invoice" => $invoice
        ];

        return view('invoice.show', $data);
    }
}
