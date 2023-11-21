@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[['link' => route('web.home.index'), 'text' => 'Dashboard']]" />

    @if (session('successMessage'))
        <x-alert class="mb-3" color="success">
            {{ session('successMessage') }}
        </x-alert>
    @endif

    @if (session('dangerMessage'))
        <x-alert class="mb-3" color="danger">
            {{ session('dangerMessage') }}
        </x-alert>
    @endif

    <x-row>
        <x-col xl="3" lg="3">
            <img src="{{ asset("assets/images/qrcode/$user->id.png") }}" alt="{{ $user->name }}" width="100%">
            <small class="m-0 text-danger">* Scan qrcode untuk melihat KTA.</small>
        </x-col>
        <x-col xl="9" lg="9">
            <x-card>
                <x-input-row label="Nama Lengkap" sm="3" />
                <x-input-row label="Email Pengguna" sm="3" />
            </x-card>
            <x-card>
                <x-input-row label="NIK" sm="3" />
                <x-input-row label="Jenis Kelamin" sm="3" />
                <x-input-row label="Tempat Lahir" sm="3" />
                <x-input-row label="Tanggal Lahir" sm="3" />
                <x-input-row label="Kewarganegaraan" sm="3" />
                <x-input-row label="Provinsi" sm="3" />
                <x-input-row label="Kota/Kabupaten" sm="3" />
                <x-input-row label="Alamat" sm="3" />
                <x-input-row label="Kode Pos" sm="3" />
                <x-input-row label="Telepon" sm="3" />
            </x-card>
            <x-card>
                <x-input-row label="Password" sm="3" />
                <x-input-row label="Konfirmasi Password" sm="3" />
            </x-card>
        </x-col>
    </x-row>
@endsection
