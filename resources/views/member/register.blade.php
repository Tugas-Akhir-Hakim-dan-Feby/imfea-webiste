@php
    use Carbon\Carbon;
    $maxDateBirth = now()
        ->subYears(15)
        ->format('Y-m-d');
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[['link' => route('web.home.index'), 'text' => 'Dashboard']]" />

    @include('templates.alert')

    <form action="{{ route('web.member.register.process') }}" method="post" enctype="multipart/form-data"
        class="needs-validation" novalidate>
        @csrf
        <x-card>
            <x-slot:body>
                <x-row>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-input label="NIK / No. KTP" id="nin" required value="{{ old('nin') }}" />
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-select label="Jenis Kelamin" id="gender" required>
                            <option value="" selected disabled></option>
                            <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </x-select>
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-row>
                            <x-col lg="6" md="6" xl="6">
                                <x-input label="Tempat Lahir" id="place_birth" required value="{{ old('place_birth') }}" />
                            </x-col>
                            <x-col lg="6" md="6" xl="6">
                                <x-input label="Tanggal Lahir" id="date_birth" type="date" required
                                    value="{{ old('date_birth') }}" max="{{ $maxDateBirth }}" />
                            </x-col>
                        </x-row>
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-select label="Kewarganegaraan" id="citizenship" required>
                            <option value="" selected disabled></option>
                            <option value="WNI" {{ old('citizenship') == 'WNI' ? 'selected' : '' }}>Warga Negara
                                Indonesia</option>
                            <option value="WNA" {{ old('citizenship') == 'WNA' ? 'selected' : '' }}>Warga Negara Asing
                            </option>
                        </x-select>
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-select label="Provinsi" id="province_id" required>
                            <option value="" selected disabled></option>
                            @foreach ($provinces as $province)
                                <option value="{{ $province['id'] }}">{{ $province['name'] }}</option>
                            @endforeach
                        </x-select>
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-select label="Kota / Kabupaten" disabled id="city_id" required>
                            <option value="" selected disabled></option>
                        </x-select>
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-input label="Alamat" id="address" required value="{{ old('address') }}" />
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-input label="Kode Pos" id="postal_code" required value="{{ old('postal_code') }}" />
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-input label="No. Telepon" id="phone" required value="{{ old('phone') }}" />
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-select label="Jenis Pekerjaan" id="work_type_id" required>
                            <option value="" selected disabled></option>
                            @foreach ($work_types as $type)
                                <option value="{{ $type->id }}"
                                    {{ old('work_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </x-select>
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-input label="Pas Foto / Foto Profil" id="image_pas_photo"
                            accept="image/jpg, image/png, image/jpeg" type="file" required />
                    </x-col>
                    <x-col lg="6" md="6" xl="6" sm="6">
                        <x-input label="CV / Daftar Riwayat Hidup" id="document_cv" accept=".pdf" type="file"
                            required />
                    </x-col>
                </x-row>
            </x-slot:body>
            <x-slot:footer class="d-flex justify-content-between align-items-center">
                <x-button route="web.home.index" label="Batal" size="sm" color="secondary" />
                <x-button type="submit" label="Daftar" size="sm" />
            </x-slot:footer>
        </x-card>
    </form>
@endsection

@push('js')
    <script>
        $("#province_id").change(function() {
            let provinceId = $(this).val()
            $("#city_id").attr("disabled");
            $.ajax({
                url: "{{ url('api/region/city') }}/" + provinceId,
                type: "get",
                success: function(response) {
                    $("#city_id").removeAttr("disabled");
                    let optionHtml = "";

                    optionHtml += "<option selected disabled value=''>silahkan pilih</option>"
                    response.data.forEach(city => {
                        optionHtml += "<option value='" + city.id + "'>" + city.name +
                            "</option>"
                    });

                    $("#city_id").empty().append(optionHtml)
                },
                error: function(error) {
                    console.error(error);
                }
            })
        })
    </script>
@endpush
