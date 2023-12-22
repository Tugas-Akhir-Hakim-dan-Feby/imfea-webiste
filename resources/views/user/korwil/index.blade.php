@php
    use Carbon\Carbon;
    use App\Http\Facades\Region\City;
    use App\Http\Facades\Region\Province;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[['link' => route('web.home.index'), 'text' => 'Dashboard']]" />

    @include('templates.alert')
    @include('user.menu')

    @if ($regionals->count() < 1)
        <x-alert color="danger" class="mt-3">
            <strong>data wilayah belum tersedia!</strong> silahkan masuk ke menu <x-link route="web.regional.index"
                style="text-decoration: underline">kelola
                wilayah</x-link> untuk menambah data.
        </x-alert>
    @endif

    <x-row class=" mt-3">
        <x-col xl="4" lg="4" md="4" class="mb-3">
            <x-card>
                <x-slot:header>
                    <a class="text-dark d-flex align-items-center justify-content-between" data-bs-toggle="collapse"
                        href="#korwil" role="button" aria-expanded="false" aria-controls="korwil">
                        <h5>Wilayah</h5>
                        <i class='uil uil-angle-down font-18'></i>
                    </a>
                </x-slot:header>

                <x-slot:body class="collapse show" id="korwil">
                    @if ($regionals->count() < 1)
                        <x-alert label="data wilayah belum tersedia!" color="warning" />
                    @else
                        <div data-simplebar="" style="max-height: 400px;">
                            @foreach ($regionals as $regional)
                                <x-link route="web.user.korwil.to" :parameter="$regional" class="text-body">
                                    <div @class([
                                        'bg-light' => $regional->id == session()->get('page'),
                                        'd-flex mt-2 p-2',
                                    ])>
                                        <div class="ms-2">
                                            <h5 class="mt-0 mb-0">
                                                {{ City::show($regional->city_id)['name'] }} -
                                                {{ Province::show($regional->province_id)['name'] }}
                                            </h5>
                                            <p class="mt-1 mb-0 text-muted">
                                                {{ ucwords($regional->address) }}
                                            </p>
                                        </div>
                                    </div>
                                </x-link>
                            @endforeach
                        </div>
                    @endif
                </x-slot:body>

                <x-slot:footer class="collapse show" id="korwil">
                    <x-button route="web.regional.index" label="Kelola Wilayah" size="sm" class="w-100" />
                </x-slot:footer>
            </x-card>
        </x-col>
        <x-col xl="8" lg="8" md="8" class="mb-3">
            <div class="card">
                <div class="card-header">
                    @if ($regionals->count() > 0)
                        <x-button route="web.user.korwil.create" size="sm" color="primary" class="text-white">Tambah
                            Kordinator
                            Baru</x-button>
                    @endif
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->id != 1)
                                                <x-button route="web.user.korwil.edit" :parameter="$user" size="sm"
                                                    color="warning" class="text-white">Edit</x-button>
                                                <form action="{{ route('web.user.korwil.destroy', $user) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('delete')
                                                    <button
                                                        class="btn btn-sm btn-danger text-white btn-delete">Hapus</button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </x-col>
    </x-row>
@endsection
