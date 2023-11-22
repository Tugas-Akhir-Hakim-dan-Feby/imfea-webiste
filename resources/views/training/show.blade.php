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
            @include('training.topic.index')
            @include('training.course.index')
        </x-col>

        <x-col lg="4" xl="4" md="4">
            @include('training.detail.thumbnail')
            @include('training.detail.benefit')
            @include('training.detail.mentor')
        </x-col>
    </x-row>
@endsection
