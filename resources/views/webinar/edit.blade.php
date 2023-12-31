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

    @if ($errors->any())
        <x-alert color="danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-alert>
    @endif

    <form action="{{ route('web.webinar.update', $webinar) }}" method="post" enctype="multipart/form-data"
        class="needs-validation" novalidate>
        @csrf
        @method('put')
        <x-row>
            <x-col lg="7" xl="7" md="7">
                <x-card>
                    <x-input label="Judul Webinar" id="title" required :value="$webinar->title" />
                    <x-textarea label="Deskripsi Webinar" id="description" required>{{ $webinar->description }}</x-textarea>
                </x-card>
            </x-col>
            <x-col lg="5" xl="5" md="5">
                <x-card>
                    <x-input label="Thumbnail Webinar" id="thumbnail_webinar" type="file" />
                    <img src="{{ url($webinar->thumbnail) }}" alt="{{ $webinar->title }}" width="100%" height="150"
                        class="mb-3">
                    <x-input label="URL Webinar" id="url" required type="url" :value="$webinar->url" />
                    <x-row>
                        <x-col lg="6" xl="6" md="6" sm="6">
                            <x-input label="Tanggal Kegiatan" id="activity_date" required type="date"
                                min="{{ date('Y-m-d') }}" :value="date('Y-m-d', strtotime($webinar->activity_date))" />
                        </x-col>
                        <x-col lg="6" xl="6" md="6" sm="6">
                            <x-input label="Waktu Kegiatan" id="activity_time" required type="time" :value="$webinar->activity_time" />
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
