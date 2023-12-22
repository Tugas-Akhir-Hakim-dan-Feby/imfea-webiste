@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[
        ['link' => route('web.home.index'), 'text' => 'Dashboard'],
        ['link' => route('web.regional.index'), 'text' => 'Wilayah Cabang'],
    ]" />

    @include('templates.alert')

    <form action="{{ $action }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @if ($regional)
            @method('put')
        @endif
        <x-card>
            <x-select label="Provinsi" id="province_id" required data-toggle="select2" class="select2">
                <option value="" selected disabled></option>
                @foreach ($provinces as $province)
                    @if ($regional)
                        <option value="{{ $province['id'] }}" @selected($province['id'] == $regional->province_id)>{{ $province['name'] }}</option>
                    @else
                        <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                    @endif
                @endforeach
            </x-select>

            <x-select label="Kota / Kabupaten" :disabled="!$regional" id="city_id" required data-toggle="select2"
                class="select2">
                <option value="" selected disabled></option>
                @if ($regional)
                    @foreach ($cities as $city)
                        <option value="{{ $city['id'] }}" @selected($city['id'] == $regional->city_id)>{{ $city['name'] }}</option>
                    @endforeach
                @endif
            </x-select>

            <x-textarea label="Alamat" id="address"
                required>{{ $regional ? $regional->address : old('address') }}</x-textarea>

            <x-input label="Kode Pos" id="postal_code" required
                value="{{ $regional ? $regional->postal_code : old('postal_code') }}" />

            <x-slot:footer class="d-flex justify-content-between align-items-center">
                <x-button route="web.regional.index" size="sm" color="secondary">Batal</x-button>
                <x-button type="submit" size="sm" color="primary">Simpan</x-button>
            </x-slot:footer>
        </x-card>
    </form>
@endsection

@push('js')
    <script>
        $(function() {
            $("#province_id").change(function() {
                let provinceId = $(this).val()
                $("#city_id").prop("disabled", true);
                ajax_city(provinceId)
            })

            function ajax_city(provinceId) {
                $.ajax({
                    url: "{{ url('api/region/city') }}/" + provinceId,
                    type: "get",
                    success: function(response) {
                        $("#city_id").prop("disabled", false);
                        let optionHtml = "";

                        optionHtml +=
                            "<option selected disabled value=''>silahkan pilih</option>"
                        response.data.forEach(city => {
                            optionHtml += "<option value='" + city.id + "'>" + city
                                .name +
                                "</option>"
                        });

                        $("#city_id").empty().append(optionHtml)
                    },
                    error: function(error) {
                        console.error(error);
                    }
                })
            }
        })
    </script>
@endpush
