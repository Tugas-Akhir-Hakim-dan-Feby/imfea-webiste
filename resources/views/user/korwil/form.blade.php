@php
    use Carbon\Carbon;
    use App\Http\Facades\Region\City;
    use App\Http\Facades\Region\Province;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[
        ['link' => route('web.home.index'), 'text' => 'Dashboard'],
        ['link' => route('web.user.korwil.clear'), 'text' => 'Koordinator Wilayah'],
    ]" />

    @include('templates.alert')

    <form action="{{ $action }}" method="post" class="needs-validation" novalidate>
        @csrf
        <x-card>
            @if ($user)
                @method('put')
                <input type="hidden" name="id" value="{{ $user->id }}">
            @endif
            <x-select label="Wilayah" required id="regional_id">
                <option value="" selected disabled></option>
                @foreach ($regionals as $regional)
                    <option value="{{ $regional->id }}" @selected($user && $user->korwilAssign->regional_id)>{{ strtoupper($regional->address) }} -
                        {{ City::show($regional->city_id)['name'] }} -
                        {{ Province::show($regional->province_id)['name'] }}</option>
                @endforeach
            </x-select>
            <x-input label="Nama Lengkap" id="name" required value="{{ old('name', $user->name ?? null) }}" />
            <x-input label="Email" type="email" id="email" required
                value="{{ old('email', $user->email ?? null) }}" />
            @if (!$user)
                <x-input label="Password" id="password" readonly required value="Password123!" />
            @endif
            <x-slot:footer class="d-flex align-items-center justify-content-between">
                <x-button route="web.user.admin-app.index" size="sm" color="secondary"
                    class="text-white">Batal</x-button>
                <x-button type="submit" size="sm" color="primary" class="text-white">Simpan</x-button>
            </x-slot:footer>
        </x-card>
    </form>
@endsection
