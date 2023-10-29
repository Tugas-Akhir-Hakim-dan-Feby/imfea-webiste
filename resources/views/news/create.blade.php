@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@push('css')
    <style>
        .ck-editor__editable_inline {
            height: 250px;
        }
    </style>
@endpush

@section('content')
    <x-header-page :title="$title" :options="[
        ['link' => route('web.home.index'), 'text' => 'Dashboard'],
        ['link' => route('web.news.index'), 'text' => 'Berita'],
    ]" />

    @if (session('dangerMessage'))
        <x-alert class="mb-3" color="danger" dismissible>
            {{ session('dangerMessage') }}
        </x-alert>
    @endif

    <form action="{{ route('web.news.store') }}" method="post" enctype="multipart/form-data" class="needs-validation"
        novalidate>
        @csrf
        <x-row>
            <x-col xl="8" lg="8" md="7">
                <x-card>
                    <x-input label="Judul Berita" id="title" required autofocus />
                    <x-textarea label="Konten Berita" id="content" required />
                </x-card>
            </x-col>
            <x-col xl="4" lg="4" md="5">
                <x-card>
                    <x-slot:body>
                        <x-input label="Thumbnail Berita" id="image_thumbnail" required type="file" accept="image/*" />
                    </x-slot:body>
                    <x-slot:footer class="d-flex justify-content-between align-items-center">
                        <x-button size="sm" color="secondary" route="web.news.index" label="Batal" />
                        <x-button size="sm" type="submit" label="Simpan" />
                    </x-slot:footer>
                </x-card>
            </x-col>
        </x-row>
    </form>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        let editor;

        ClassicEditor
            .create(document.querySelector('#content'), {
                ckfinder: {
                    uploadUrl: "{{ route('web.news.upload.image') }}"
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
