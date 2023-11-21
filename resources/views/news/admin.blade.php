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

    <x-row>
        <x-col>
            <x-card>
                <x-slot:header class="d-flex justify-content-between align-items-center">
                    <x-button size="sm" color="primary" route="web.news.create">Tambah Berita Baru</x-button>

                    <div class="d-flex justify-content-between align-items-center">
                        <x-input margin="0" type="search" />
                        <x-pagination :paginator="$news" />
                    </div>
                </x-slot:header>
                <x-slot:body>
                    <x-table :isComplete="true" class="table-bordered table-hover table-sm">
                        <x-slot:thead>
                            <th>No.</th>
                            <th>Judul Berita</th>
                            <th>Penulis Berita</th>
                            <th>Status Berita</th>
                            <th>Aksi</th>
                        </x-slot:thead>
                        <x-slot:tbody>
                            @forelse ($news as $index => $new)
                                <tr>
                                    <th data-label="No.">{{ $index + $news->firstItem() }}.</th>
                                    <td data-label="Judul Berita">{{ $new->title }}</td>
                                    <td data-label="Penulis Berita">{{ $new->author->name }}</td>
                                    <td data-label="Status Berita">
                                        <div class="d-flex justify-content-between align-items-center" style="width: 50%">
                                            <small class="form-check-label {{ $new->status ? '' : 'text-danger' }}">Tidak
                                                Aktif</small>
                                            <div class="form-check form-switch ms-2 me-1">
                                                <form action="{{ route('web.news.update.status', $new) }}" method="POST">
                                                    @csrf
                                                    @method('put')
                                                    <input style="cursor: pointer"
                                                        class="form-check-input {{ $new->status ? 'btn-non-active' : 'btn-active' }}"
                                                        type="checkbox" role="switch" {{ $new->status ? 'checked' : '' }}>
                                                </form>
                                            </div>
                                            <small
                                                class="form-check-label {{ $new->status ? 'text-success' : '' }}">Aktif</small>
                                        </div>
                                    </td>
                                    <td data-label="Aksi">
                                        <div>
                                            <a href="{{ route('web.news.edit', $new) }}"
                                                class="btn btn-sm btn-warning text-white me-2">Edit</a>
                                            <form action="{{ route('web.news.destroy', $new) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger text-white btn-delete">Hapus</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <x-empty-table colspan="5" class="text-center">data tidak tersedia!</x-empty-table>
                            @endforelse
                        </x-slot:tbody>
                    </x-table>
                </x-slot:body>
            </x-card>
        </x-col>
    </x-row>

    {{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <a href="{{ route('web.news.create') }}" class="btn btn-sm btn-primary">Tambah Berita</a>

                    <div class="d-flex justify-content-between align-items-center">
                        <input type="text" class="form-control">
                        <x-pagination :paginator="$news" />
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th style="width: 25%">Judul Berita</th>
                                    <th>Penulis Berita</th>
                                    <th>Status Berita</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($news as $index => $new)
                                    <tr>
                                        <th>{{ $index + $news->firstItem() }}.</th>
                                        <td style="width: 25%">{{ $new->title }}</td>
                                        <td>{{ $new->author->name }}</td>
                                        <td>
                                            <div class="d-flex justify-content-between align-items-center"
                                                style="width: 50%">
                                                <small
                                                    class="form-check-label {{ $new->status ? '' : 'text-danger' }}">Tidak
                                                    Aktif</small>
                                                <div class="form-check form-switch">
                                                    <form action="{{ route('web.news.update.status', $new) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('put')
                                                        <input style="cursor: pointer"
                                                            class="form-check-input {{ $new->status ? 'btn-non-active' : 'btn-active' }}"
                                                            type="checkbox" role="switch"
                                                            {{ $new->status ? 'checked' : '' }}>
                                                    </form>
                                                </div>
                                                <small
                                                    class="form-check-label {{ $new->status ? 'text-success' : '' }}">Aktif</small>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ route('web.news.edit', $new) }}"
                                                class="btn btn-sm btn-warning text-white me-2">Edit</a>
                                            <form action="{{ route('web.news.destroy', $new) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-sm btn-danger text-white btn-delete">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">data tidak tersedia!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $(".btn-non-active").click(function(e) {
                e.preventDefault();

                let form = $(this).closest("form");

                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Anda akan non aktifkan berita ini!",
                    icon: 'warning',
                    showDenyButton: true,
                    denyButtonText: 'Non Aktif',
                    confirmButtonText: 'Batal',
                    confirmButtonColor: '#6c757d'
                }).then((result) => {
                    if (result.isDenied) {
                        form.submit()
                    }
                })
            })

            $(".btn-active").click(function(e) {
                e.preventDefault();

                let form = $(this).closest("form");
                form.submit()
            })
        })
    </script>
@endpush
