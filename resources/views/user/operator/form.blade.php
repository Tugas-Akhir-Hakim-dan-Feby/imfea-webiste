@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[
        ['link' => route('web.home.index'), 'text' => 'Dashboard'],
        ['link' => route('web.user.operator.index'), 'text' => 'Operator'],
    ]" />

    @include('templates.alert')

    <form action="{{ $action }}" method="post" class="needs-validation" novalidate>
        @csrf
        @if ($user)
            @method('put')
            <input type="hidden" name="id" value="{{ $user->id }}">
        @endif
        <x-card>
            <x-input-row label="Nama Lengkap" id="name" required value="{{ old('name', $user->name ?? null) }}" />
            <x-input-row label="Email" type="email" id="email" required
                value="{{ old('email', $user->email ?? null) }}" />
            @if (!$user)
                <x-input-row label="Password" id="password" readonly required value="Password123!" />
            @endif
            <x-slot:footer class="d-flex align-items-center justify-content-between">
                <x-button route="web.user.operator.index" size="sm" color="secondary"
                    class="text-white">Batal</x-button>
                <x-button type="submit" size="sm" color="primary" class="text-white">Simpan</x-button>
            </x-slot:footer>
        </x-card>
    </form>
@endsection
