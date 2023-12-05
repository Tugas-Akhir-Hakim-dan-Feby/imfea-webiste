@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[['link' => route('web.home.index'), 'text' => 'Dashboard']]" />

    @include('templates.alert')

    <x-row>
        <x-col lg="3" md="4" sm="6" xl="3" class="mb-4">
            <x-link route="web.training.create">
                <x-card class="bg-primary h-100 shadow-lg">
                    <x-slot:body
                        class="h-100 d-flex justify-content-center flex-column align-items-center text-white text-center">
                        <i class=" uil-folder-medical" style="font-size: 5em"></i>
                        <p class="mt-3 fw-bold">Tambah Pelatihan</p>
                    </x-slot:body>
                </x-card>
            </x-link>
        </x-col>
        @foreach ($trainings as $training)
            <x-col lg="3" md="4" sm="6" xl="3" class="mb-4">
                <x-card class="h-100 shadow-lg" :image="$training->thumbnail">
                    <x-slot:body class="h-100">
                        <h4 class="card-title">{{ $training->title }}</h4>
                        <p class="small m-0">
                            <span>
                                <x-icon name="mdi mdi-calendar" />
                                {{ Carbon::createFromFormat('Y-m-d H:i:s', $training->created_at)->isoFormat('DD MMM YYYY') }}
                            </span>
                            <span> |
                                <x-icon name="dripicons-pin" />
                                Online
                            </span>
                            |
                            <x-icon name="dripicons-user-group" />&nbsp;
                            <x-badge color="info">{{ $training->participants->count() }} Peserta</x-badge>
                            <span> |
                                <x-icon name="dripicons-checkmark" />
                                Materi & Sertifikat
                            </span>
                        </p>
                    </x-slot:body>
                    <x-slot:footer class="d-flex justify-content-between align-items-center">
                        <x-button label="Detail" class="text-white w-100" color="info" size="sm"
                            route="web.training.show" :parameter="$training" />
                    </x-slot:footer>
                </x-card>
            </x-col>
        @endforeach
    </x-row>
@endsection
