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
        ['link' => route('web.training.index'), 'text' => 'Pelatihan'],
        ['link' => route('web.training.show', $training), 'text' => $training->title],
    ]" />

    @if (session('dangerMessage'))
        <x-alert class="mb-3" color="danger" dismissible>
            {{ session('dangerMessage') }}
        </x-alert>
    @endif

    <form action="{{ route('web.course.store', $training) }}" method="post" enctype="multipart/form-data"
        class="needs-validation" novalidate>
        @csrf
        <x-row>
            <x-col xl="8" lg="8" md="7">
                <x-card>
                    <x-input label="Judul Materi" id="title" required autofocus :value="old('title')" />
                    <x-textarea label="Konten Materi" id="content" required :value="old('content')" />
                </x-card>
            </x-col>
            <x-col xl="4" lg="4" md="5">
                <x-card>
                    <x-slot:body>
                        <x-select label="Topik Materi" id="topic_id" required>
                            <option selected disabled />
                            @foreach ($training->topics as $topic)
                                <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                                    {{ $topic->title }}</option>
                            @endforeach
                        </x-select>
                        <x-input label="Link Video" id="link_video" required :value="old('link_video')" />
                    </x-slot:body>
                    <x-slot:footer class="d-flex justify-content-between align-items-center">
                        <x-button size="sm" color="secondary" route="web.training.index" label="Batal" />
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
                toolbar: [
                    'heading', '|', 'bold', 'italic', '|', 'link', 'insertTable',
                    '|',
                    'bulletedList',
                    'numberedList', 'blockQuote'
                ],
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
