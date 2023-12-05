@if ($training->topicExams->count() > 0)
    <x-card>
        <x-slot:header class="d-flex justify-content-between align-items-center">
            <h3 class="fw-semibold">Daftar Ujian</h3>
            <div>
                <x-button label="Tambah Pertanyaan" class="text-white w-100" color="primary" size="sm"
                    route="web.exam.create" :parameter="$training" />
            </div>
        </x-slot:header>

        <x-slot:body>
            <div class="accordion custom-accordion" id="custom-accordion-one">
                @forelse ($training->topicExams as $topic)
                    <div class="card mb-0">
                        <div class="card-header" id="heading{{ $topic->slug }}">
                            <h5 class="m-0">
                                <a class="custom-accordion-title {{ $loop->first ? '' : 'collapsed' }} d-block py-1"
                                    data-bs-toggle="collapse" href="#collapse{{ $topic->slug }}"
                                    aria-expanded="{{ $loop->first ? true : false }}"
                                    aria-controls="collapse{{ $topic->slug }}">
                                    {{ $topic->title }} <small style="font-size: 10px">(Data Pertanyaan)</small> <i
                                        class="mdi mdi-chevron-down accordion-arrow"></i>
                                </a>
                            </h5>
                        </div>

                        <div id="collapse{{ $topic->slug }}" class="collapse {{ $loop->first ? 'show' : '' }}"
                            aria-labelledby="heading{{ $topic->slug }}" data-bs-parent="#custom-accordion-one">
                            <div class="card-body">
                                <ul class="list-group">
                                    @forelse ($topic->exams as $exam)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <h5 class="my-0">Pertanyaan {{ $loop->iteration }}</h5>
                                            <div class="d-flex">
                                                @if (auth()->user()->id == $training->user_id)
                                                    <x-button label="Edit" class="text-white w-100 me-2"
                                                        color="warning" size="sm" route="web.exam.edit"
                                                        :parameter="['training' => $training, 'exam' => $exam]" />
                                                    <form
                                                        action="{{ route('web.exam.destroy', ['training' => $training, 'exam' => $exam]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <x-button label="Hapus" class="btn-delete" color="danger"
                                                            size="sm" />
                                                    </form>
                                                @endif
                                            </div>
                                        </li>
                                    @empty
                                        <div class="alert alert-info">
                                            belum ada materi!
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info">
                        belum ada materi!
                    </div>
                @endforelse
            </div>
        </x-slot:body>
    </x-card>
@endif
