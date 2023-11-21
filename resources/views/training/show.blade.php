@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-card class="bg-dark mt-4">
        <x-breadcrumb class="d-sm-block d-none" :currentPage="$title ?? 'Dashboard'" :pages="[
            [
                ['link' => route('web.home.index'), 'text' => 'Dashboard'],
                ['link' => route('web.training.index'), 'text' => 'training'],
            ],
        ]" />


        <h2 class="fw-normal text-white">{{ $title }}</h2>

        <x-row class="mt-3 align-items-center">
            <x-col lg="5" xl="5" md="7" sm="8">
                <div class="d-flex justify-content-between flex-sm-row flex-column text-white">
                    <span>
                        <x-icon name="mdi mdi-calendar" />
                        {{ Carbon::createFromFormat('Y-m-d H:i:s', $training->created_at)->isoFormat('DD MMM YYYY') }}
                    </span>
                    <span>
                        <x-icon name="dripicons-user-group" />&nbsp;
                        <x-badge color="info">0 Peserta</x-badge>
                    </span>
                    <span>
                        <x-icon name="dripicons-checkmark" />
                        Materi & Sertifikat
                    </span>
                </div>
            </x-col>
            <x-col lg="7" xl="7" md="5" sm="4"
                class="d-flex justify-content-sm-end justify-content-start pt-sm-0 pt-3">
                <x-button label="Edit" class="text-white me-2" color="warning" size="sm" route="web.training.edit"
                    :parameter="$training" />
                <form action="{{ route('web.training.destroy', $training) }}" method="post">
                    @csrf
                    @method('delete')
                    <x-button label="Hapus" class="btn-delete" color="danger" size="sm" />
                </form>
            </x-col>
        </x-row>
    </x-card>

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
        <x-col lg="8" xl="8" md="8">
            <x-card>
                <x-slot:header>
                    <h3 class="fw-normal">Deskripsi Pelatihan</h3>
                </x-slot:header>

                <x-slot:body>
                    {!! $training->content !!}
                </x-slot:body>
            </x-card>
            <x-card>
                <x-slot:header class="d-flex justify-content-between align-items-center">
                    <h3 class="fw-normal">Daftar Materi</h3>
                    <div>
                        <x-button label="Tambah Materi" class="text-white w-100" color="primary" size="sm"
                            route="web.training.create" />
                    </div>
                </x-slot:header>

                <x-slot:body>
                </x-slot:body>
            </x-card>
        </x-col>

        <x-col lg="4" xl="4" md="4">
            <x-card :image="$training->thumbnail">
                {{-- <x-button label="Mulai Belajar" class="text-white w-100" color="primary" route="web.training.edit"
                    :parameter="$training" /> --}}
            </x-card>
            <ul class="list-group mb-3 shadow">
                <li class="list-group-item">
                    <h3 class="fw-normal text-secondary">Manfaat</h3>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <img src="{{ asset('assets/images/certificate.jpg') }}" height="50" width="50">
                    <h5 class="ms-2 my-0">Sertifikat</h5>
                </li>
                <li class="list-group-item d-flex align-items-center">
                    <img src="{{ asset('assets/images/materi.jpg') }}" height="50" width="50">
                    <h5 class="ms-2 my-0">Akses Materi</h5>
                </li>
            </ul>
            <x-card>
                <x-slot:header>
                    <h3 class="fw-normal">Mentor</h3>
                </x-slot:header>
                <x-slot:body>
                    <div class="d-flex align-items-center">
                        <img class="img-fluid objectfit-cover rounded-2"
                            src="https://ui-avatars.com/api/?background=random&size=50&length=2&name={{ $training->user->name }}"
                            alt="{{ $training->user->name }}">
                        <h5 class="fw-bolder ms-2">{{ $training->user->name }}</h5>
                    </div>
                </x-slot:body>
            </x-card>
        </x-col>
    </x-row>
@endsection
