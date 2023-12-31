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
        <x-col lg="3" md="4" sm="6" xl="3" class="mb-4">
            <x-link route="web.webinar.all">
                <x-card class="bg-primary h-100 shadow-lg">
                    <x-slot:body
                        class="h-100 d-flex justify-content-center flex-column align-items-center text-white text-center">
                        <i class="uil-folder-medical" style="font-size: 5em"></i>
                        <p class="mt-3 fw-bold">Tambah Webinar</p>
                    </x-slot:body>
                </x-card>
            </x-link>
        </x-col>

        @foreach ($webinars as $webinar)
            @php
                $activityDate = Carbon::parse($webinar->activity_date);
                $daysDifference = now()->diffInDays($activityDate);
            @endphp
            <x-col lg="3" md="4" sm="6" xl="3" class="mb-4">
                <x-card class="h-100 shadow-lg" :image="route('web.webinar.background', $webinar)">
                    <x-slot:body class="h-100 text-dark">
                        <h4 class="card-title">{{ $webinar->title }}</h4>
                        <p class="small m-0">
                            <span>
                                <x-icon name="mdi mdi-calendar" />
                                {{ Carbon::createFromFormat('Y-m-d H:i:s', $webinar->activity_date)->isoFormat('DD MMM YYYY') }}
                            </span>
                            <span> |
                                <x-icon name="dripicons-alarm" />
                                {{ $webinar->activity_time }}
                            </span>
                            <span> |
                                <x-icon name="dripicons-pin" />
                                Online
                            </span>
                            |
                            <x-icon name="dripicons-user-group" />&nbsp;
                            <x-badge color="info">{{ $webinar->participants->count() }} Peserta</x-badge>
                            <span> |
                                <x-icon name="dripicons-checkmark" />
                                Materi & Sertifikat
                            </span>
                        </p>
                    </x-slot:body>
                    <x-slot:footer class="d-flex justify-content-between align-items-center">
                        @if ($daysDifference < 2)
                            @if ($webinar->webinarParticipant)
                                <x-button label="Detail" class="text-white w-100" color="info" size="sm"
                                    route="web.webinar.show" :parameter="$webinar" />
                            @else
                                <span class="btn btn-sm btn-light w-100" style="cursor: default">Pendaftaran Ditutup</span>
                            @endif
                        @else
                            @if ($webinar->webinarParticipant)
                                <x-button label="Detail" class="text-white w-100" color="info" size="sm"
                                    route="web.webinar.show" :parameter="$webinar" />
                            @else
                                <x-button label="Daftar" class="text-white w-100 btn-register" color="primary"
                                    size="sm" toggle="modal" target="#registerWebinar"
                                    data-webinar="{{ $webinar }}" />
                            @endif
                        @endif
                    </x-slot:footer>
                </x-card>
            </x-col>
        @endforeach
    </x-row>
@endsection
