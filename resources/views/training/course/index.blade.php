<x-card>
    <x-slot:header class="d-flex justify-content-between align-items-center">
        <h3 class="fw-semibold">Daftar Materi</h3>
        <div>
            @if ($training->topics->count() > 0)
                <x-button label="Tambah Materi" class="text-white w-100" color="primary" size="sm"
                    route="web.course.create" :parameter="$training" />
            @endif
        </div>
    </x-slot:header>

    <x-slot:body>
        @if ($training->topics->count() < 1)
            <div class="alert alert-warning">
                Silahkan buat topik terlebih dahulu!
            </div>
        @endif
        <div class="accordion custom-accordion" id="custom-accordion-one">
            @forelse ($training->topics as $topic)
                <div class="card mb-0">
                    <div class="card-header" id="heading{{ $topic->slug }}">
                        <h5 class="m-0">
                            <a class="custom-accordion-title {{ $loop->first ? '' : 'collapsed' }} d-block py-1"
                                data-bs-toggle="collapse" href="#collapse{{ $topic->slug }}"
                                aria-expanded="{{ $loop->first ? true : false }}"
                                aria-controls="collapse{{ $topic->slug }}">
                                {{ $topic->title }} <i class="mdi mdi-chevron-down accordion-arrow"></i>
                            </a>
                        </h5>
                    </div>

                    <div id="collapse{{ $topic->slug }}" class="collapse {{ $loop->first ? 'show' : '' }}"
                        aria-labelledby="heading{{ $topic->slug }}" data-bs-parent="#custom-accordion-one">
                        <div class="card-body">
                            <ul class="list-group">
                                @forelse ($topic->courses as $course)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <h5 class="my-0">{{ $course->title }}</h5>
                                        <div class="d-flex">
                                            <x-button label="Edit" class="text-white w-100 me-2" color="warning"
                                                size="sm" route="web.course.edit" :parameter="['training' => $training, 'course' => $course]" />
                                            <form
                                                action="{{ route('web.course.destroy', ['training' => $training, 'course' => $course]) }}"
                                                method="post">
                                                @csrf
                                                @method('delete')
                                                <x-button label="Hapus" class="btn-delete" color="danger"
                                                    size="sm" />
                                            </form>
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
