@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[['link' => route('web.home.index'), 'text' => 'Dashboard']]" />

    @include('templates.alert')
    @include('user.menu')

    <x-row class=" mt-3">
        <x-col xl="4" lg="4" md="4" class="mb-3">
            <x-card>
                <x-slot:header>
                    <h5>Wilayah</h5>
                </x-slot:header>

                <div data-simplebar="" style="max-height: 535px;">
                    <a href="javascript:void(0);" class="text-body">
                        <div class="d-flex mt-2 p-2 bg-light">
                            <div class="ms-2">
                                <h5 class="mt-0 mb-0">
                                    Lunar
                                </h5>
                                <p class="mt-1 mb-0 text-muted">
                                    ID: proj101
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                <x-slot:footer>
                    <x-button route="web.regional.index" label="Kelola Wilayah" size="sm" class="w-100" />
                </x-slot:footer>
            </x-card>
        </x-col>
        <x-col xl="8" lg="8" md="8" class="mb-3">
            <div class="card">
                <div class="card-header">
                    <x-button route="web.user.admin-app.create" size="sm" color="primary" class="text-white">Tambah
                        Admin
                        Baru</x-button>
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
                                                <x-button route="web.user.admin-app.edit" :parameter="$user" size="sm"
                                                    color="warning" class="text-white">Edit</x-button>
                                                <form action="{{ route('web.user.admin-app.destroy', $user) }}"
                                                    method="POST" class="d-inline">
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
