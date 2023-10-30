@php
    use Carbon\Carbon;

    $colorStatus = 'success';

    if ($invoice::PENDING == $invoice->status) {
        $colorStatus = 'danger';
    }

    if ($invoice::CANCEL == $invoice->status) {
        $colorStatus = 'secondary';
    }
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[
        ['link' => route('web.home.index'), 'text' => 'Dashboard'],
        ['link' => route('web.invoice.index'), 'text' => 'Tagihan'],
    ]" />

    @if (session('dangerMessage'))
        <x-alert class="mb-3" color="danger">
            {{ session('dangerMessage') }}
        </x-alert>
    @endif

    <x-row>
        <x-col xl="9" lg="9" md="9">
            <x-card>
                <x-slot:header class="d-flex justify-content-between align-items-center">
                    <h2 class="fw-normal">
                        Invoice #{{ $invoice->external_id }} <x-badge class="fw-normal" :color="$colorStatus"
                            :label="$invoice->status" />
                    </h2>
                    <p class="m-0">Tanggal Invoice : {{ date('d-m-Y', strtotime($invoice->created_at)) }}</p>
                </x-slot:header>
                <x-slot:body>
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h5>Dibayar Ke : </h5>
                            <p>IMFEA</p>
                        </div>
                        <div>
                            <h5>Ditagih Kepada : </h5>
                            <p>
                                Hakim Asrori <br>
                                {{ ucwords($invoice->user->membership->address) }}
                            </p>
                        </div>
                    </div>

                    <h5>Invoice Item</h5>
                    <x-table class="table-bordered" :isComplete="true">
                        <x-slot:thead>
                            <th>Deskripsi</th>
                            <th>Total</th>
                        </x-slot:thead>
                        <x-slot:tbody>
                            <tr>
                                <td>{{ $invoice->description }}</td>
                                <td>Rp. {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                            </tr>
                        </x-slot:tbody>
                        <x-slot:tfoot>
                            <tr>
                                <th class="text-end">Total</th>
                                <th>Rp. {{ number_format($invoice->amount, 0, ',', '.') }}</th>
                            </tr>
                        </x-slot:tfoot>
                    </x-table>

                    @if ($invoice::SUCCESS == $invoice->status)
                        <h5>Transaksi</h5>
                        <x-table class="table-bordered" :isComplete="true">
                            <x-slot:thead>
                                <th>Tanggal Transaksi</th>
                                <th>Metode Pembayaran</th>
                                <th>ID Transaksi</th>
                                <th>Total</th>
                            </x-slot:thead>
                            <x-slot:tbody>
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($invoice->updated_at)) }}</td>
                                    <td>{{ $invoice->payment_method }}</td>
                                    <td>{{ date('Ymd', strtotime($invoice->updated_at)) . $invoice->external_id }}</td>
                                    <td>Rp. {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                </tr>
                            </x-slot:tbody>
                        </x-table>
                    @endif
                </x-slot:body>
            </x-card>
        </x-col>
        <x-col xl="3" lg="3" md="3">
            <x-card class="{{ $invoice::PENDING == $invoice->status ? 'bg-secondary text-white' : '' }}">
                @if ($invoice::PENDING == $invoice->status)
                    <x-label class="fw-normal">Total Pembayaran</x-label>
                    <p class="fs-3">Rp. {{ number_format($invoice->amount, 0, ',', '.') }}</p>
                    <x-button label="Bayar Sekarang" :url="$invoice->payment_url" class="w-100 text-white" color="warning" />
                @else
                    <x-button label="Unduh Invoice" class="w-100 text-white" color="primary" />
                @endif
            </x-card>
        </x-col>
    </x-row>
@endsection

@push('js')
@endpush
