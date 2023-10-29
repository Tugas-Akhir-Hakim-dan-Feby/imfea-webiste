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
        ['link' => route('web.webinar.index'), 'text' => 'Webinar'],
    ]"></x-header-page>

    @if (session('dangerMessage'))
        <x-alert class="mb-3" color="danger" dismissible>
            {{ session('dangerMessage') }}
        </x-alert>
    @endif

    <form action="{{ route('web.webinar.store') }}" method="post" class="needs-validation" novalidate>
        @csrf
        <x-row>
            <x-col lg="7" xl="7" md="7">
                <x-card>
                    <x-input label="Judul Webinar" id="title" required />
                    <x-textarea label="Deskripsi Webinar" id="description" required />
                </x-card>
            </x-col>
            <x-col lg="5" xl="5" md="5">
                <x-card>
                    <x-input label="URL Webinar" id="url" required type="url" />
                    <x-row>
                        <x-col lg="6" xl="6" md="6" sm="6">
                            <x-input label="Tanggal Kegiatan" id="activity_date" required type="date"
                                min="{{ date('Y-m-d') }}" />
                        </x-col>
                        <x-col lg="6" xl="6" md="6" sm="6">
                            <x-input label="Waktu Kegiatan" id="activity_time" required type="time" />
                        </x-col>
                    </x-row>
                </x-card>
                <x-card>
                    <x-button size="sm" type="submit" label="Simpan" class="w-100 mb-2" />
                    <x-button size="sm" label="Batal" color="secondary" class="w-100 mb-2"
                        route="web.webinar.index" />
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
            .create(document.querySelector('#description'), {
                toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote'],
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        }
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
