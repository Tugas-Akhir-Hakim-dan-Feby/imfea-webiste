@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[['link' => route('web.home.index'), 'text' => 'Dashboard']]" />

    @include('templates.alert')

    <x-card>
        <x-table :isComplete="true" class="table-bordered table-hover">
            <x-slot:thead>
                <th>Invoice</th>
                <th>Tanggal Invoice</th>
                <th>Total</th>
                <th>Status</th>
            </x-slot:thead>
            <x-slot:tbody>
                @foreach ($invoices as $invoice)
                    @php
                        $colorStatus = 'success';

                        if ($invoice::PENDING == $invoice->status) {
                            $colorStatus = 'danger';
                        }

                        if ($invoice::CANCEL == $invoice->status) {
                            $colorStatus = 'secondary';
                        }
                    @endphp
                    <tr style="cursor: pointer" onclick="redirectTo({{ $invoice->external_id }})">
                        <th class="text-primary">#{{ $invoice->external_id }}</th>
                        <td>{{ Carbon::createFromFormat('Y-m-d H:i:s', $invoice->created_at)->isoFormat('DD MMMM YYYY') }}
                        </td>
                        <td>Rp. {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                        <td>
                            <x-badge color="{{ $colorStatus }}" style="height: 10px; width: 10px" /> {{ $invoice->status }}
                        </td>
                    </tr>
                @endforeach
            </x-slot:tbody>
        </x-table>
    </x-card>
@endsection

@push('js')
    <script>
        function redirectTo(externalId) {
            window.location.href = "{{ url('invoice') }}/" + externalId
        }
    </script>
@endpush
