@extends('templates.app')

@push('css')
    <style>
        .ck-editor__editable_inline {
            height: 300px;
        }
    </style>
@endpush

@section('content')
    <x-header-page :title="$title" :options="[
        ['link' => route('web.home.index'), 'text' => 'Dashboard'],
        ['link' => route('web.training.index'), 'text' => 'Pelatihan'],
        ['link' => route('web.training.show', $training), 'text' => $training->title],
    ]" />

    @include('templates.alert')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $action }}" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf
        @if ($exam)
            @method('put')
        @endif
        <x-card>
            <x-textarea label="Pertanyaan" id="question" required :value="old('question', $exam->question ?? '')" />
        </x-card>

        <x-card>
            <x-slot:header class="d-flex justify-content-between align-items-center">
                <x-select label="Tipe Pertanyaan" id="type" required>
                    <option selected disabled />
                    @foreach ($questionTypes as $type)
                        <option value="{{ $type['id'] }}"
                            {{ old('type', $exam->type ?? 0) == $type['id'] ? 'selected' : '' }}>
                            {{ $type['type'] }}</option>
                    @endforeach
                </x-select>
            </x-slot:header>

            <div id="multipleChoice">
            </div>

            <x-slot:footer class="d-flex justify-content-between align-items-center">
                <x-button size="sm" color="secondary" route="web.training.show" :parameter="$training" label="Batal" />
                <x-button size="sm" type="submit" label="Simpan" />
            </x-slot:footer>
        </x-card>
    </form>
@endsection

@push('js')
    <script src="{{ asset('assets/vendor/ckeditor/ckeditor.js') }}"></script>
    <script>
        let editor;

        ClassicEditor
            .create(document.querySelector('#question'), {
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
                },
                ckfinder: {
                    uploadUrl: "{{ route('web.news.upload.image') }}"
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    <script>
        $(document).ready(function() {
            initType()
            initFormAnswer()

            $("#type").change(function() {
                initType()
            })

            function initType() {
                if ($("#type").val() == 0) {
                    $("#addAnswer").prop('hidden', false)
                    $("#multipleChoice").append(`@include('training.exam.components.multiple-choice')`)
                    let counter = $(".duplication:last").data("id");
                    $(`#answer-${counter}`).find("button").hide()
                } else {
                    $("#addAnswer").prop('hidden', true)
                    $("#multipleChoice").html('')
                }
            }

            function initFormAnswer() {
                let counter = $(".duplication:last").data("id");
                let answers = []

                $("#addAnswer").on('click', function() {
                    let newElement;
                    counter++;

                    $(`.duplication:last`).clone(true)
                        .map(function() {
                            newElement = $(this).attr("id", `answer-${counter}`).attr("data-id",
                                counter).find("")
                        })

                    if ($("#answer-" + (counter - 1)).length) {
                        $("#answer-" + (counter - 1)).after(newElement);
                    } else {
                        $("#answer-0").after(newElement);
                    }

                    $('.duplication').find("button").show();
                    $("#answer-" + counter).find("button").hide();
                })

                $('body').on('click', '#deleteAnswer', function() {
                    deleteAnswer('answer-1', answers);
                    initSelectCorrectAnswer(answers)
                    $(this).parents('.duplication').remove();
                });
            }

            function deleteAnswer(param, answers) {
                let index = answers.find(answer => answer.key === param);
                if (index !== -1) {
                    answers.splice(index, 1);
                }
            }

            function initSelectCorrectAnswer(answers) {
                $("#correct_answer").empty()
                $("#correct_answer").append($('<option />').val("").text("").prop("selected", true).prop("disabled",
                    true))

                answers.forEach(answer => {
                    $("#correct_answer").append(new Option(answer.value, answer.value))
                });
            }
        })
    </script>
@endpush
