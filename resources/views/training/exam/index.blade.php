<x-card>
    <x-slot:header class="d-flex justify-content-between align-items-center">
        <h3 class="fw-semibold">Daftar Ujian</h3>
        <div>
            @if ($training->exam_active)
                <x-button label="Nonaktifkan Quiz" class="text-white w-100 d-inline me-2" color="dark" size="sm"
                    route="web.exam.training" :parameter="$training" />
                <x-button label="Tambah Pertanyaan" class="text-white w-100 d-inline" color="primary" size="sm"
                    route="web.exam.create" :parameter="$training" />
            @else
                <x-button label="Aktifkan Quiz" class="text-white w-100" color="success" size="sm"
                    route="web.exam.training" :parameter="$training" />
            @endif
        </div>
    </x-slot:header>

    <x-slot:body>
        <table class="table table-bordered table-hover" id="basic-datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($training->exams as $exam)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>{!! $exam->question !!}</td>
                        <td>
                            @if (auth()->user()->id == $training->user_id)
                                <x-button label="Edit" class="text-white w-100 me-2" color="warning" size="sm"
                                    route="web.exam.edit" :parameter="['training' => $training, 'exam' => $exam]" />
                                <form
                                    action="{{ route('web.exam.destroy', ['training' => $training, 'exam' => $exam]) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <x-button label="Hapus" class="btn-delete" color="danger" size="sm" />
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </x-slot:body>
</x-card>
