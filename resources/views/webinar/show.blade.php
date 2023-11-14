@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-card class="bg-dark mt-4">
        <x-breadcrumb :currentPage="$title ?? 'Dashboard'" :pages="[
            [
                ['link' => route('web.home.index'), 'text' => 'Dashboard'],
                ['link' => route('web.webinar.index'), 'text' => 'Webinar'],
            ],
        ]"></x-breadcrumb>

        <h2 class="fw-normal text-white">{{ $title }}</h2>

        <x-row class="mt-3">
            <x-col lg="6" xl="6" md="8" sm="10">
                <div class="d-flex justify-content-between flex-sm-row flex-column text-white">
                    <span>
                        <x-icon name="mdi mdi-calendar" />
                        {{ Carbon::createFromFormat('Y-m-d H:i:s', $webinar->activity_date)->isoFormat('DD MMM YYYY') }}
                    </span>
                    <span>
                        <x-icon name="dripicons-alarm" />
                        {{ $webinar->activity_time }}
                    </span>
                    <span>
                        <x-icon name="dripicons-user-group" />&nbsp;
                        <x-badge color="info">{{ $webinar->participants->count() }} Peserta</x-badge>
                    </span>
                    <span>
                        <x-icon name="dripicons-checkmark" />
                        Materi & Sertifikat
                    </span>
                </div>
            </x-col>
        </x-row>
    </x-card>

    <x-row>
        <x-col lg="8" xl="8" md="8">
            <x-card>
                <x-slot:header>
                    <h3 class="fw-normal">Deskripsi Webinar</h3>
                </x-slot:header>

                <x-slot:body>
                    {!! $webinar->description !!}
                </x-slot:body>
            </x-card>
        </x-col>

        <x-col lg="4" xl="4" md="4">
            <x-card :image="route('web.webinar.background', $webinar)">
                @if ($isNowMeet)
                    <x-button class="w-100" color="secondary" style="cursor: default">Webinar Belum Dimulai</x-button>
                @else
                    <x-button class="w-100" route="web.webinar.meet" :parameter="$webinar->slug" blank>Join Meet</x-button>
                @endif
            </x-card>
        </x-col>
    </x-row>

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
@endsection
