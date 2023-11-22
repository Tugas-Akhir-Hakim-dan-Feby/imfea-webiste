<ul class="list-group mb-3 shadow">
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <h3 class="fw-normal text-secondary">Daftar Topik Materi</h3>
        <div>
            <x-button label="Tambah Topic" class="text-white w-100" color="primary" size="sm" toggle="modal"
                target="#addNewTopic" />
        </div>
    </li>
    @foreach ($training->topics as $topic)
        <li class="list-group-item d-flex align-items-center justify-content-between">
            <h5 class="ms-2 my-0">{{ $topic->title }}</h5>
            <div class="d-flex align-items-center">
                <x-button label="Edit" class="text-white me-2 btn-edit" data-topic="{{ $topic }}"
                    color="warning" size="sm" toggle="modal" target="#editTopic" />
                <form action="{{ route('web.topic.destroy', ['training' => $training, 'topic' => $topic]) }}"
                    method="post">
                    @csrf
                    @method('delete')
                    <x-button label="Hapus" class="btn-delete" color="danger" size="sm" />
                </form>
            </div>
        </li>
    @endforeach
</ul>

@push('modal')
    <x-modal id="addNewTopic" title="Tambah Topik Baru" form="{{ route('web.topic.store', ['training' => $training]) }}">
        <x-input label="Judul Topik" id="title" value="{{ old('title') }}" required />

        <x-slot:footer class="d-flex justify-content-between">
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
            <x-button type="submit" color="primary" size="sm" label="Simpan" />
        </x-slot:footer>
    </x-modal>
    <x-modal id="editTopic" title="Edit Topik" form="{{ route('web.topic.store', ['training' => $training]) }}">
        @method('put')
        <x-input label="Judul Topik" id="title" value="{{ old('title') }}" required />

        <x-slot:footer class="d-flex justify-content-between">
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
            <x-button type="submit" color="primary" size="sm" label="Simpan" />
        </x-slot:footer>
    </x-modal>
@endpush

@push('js')
    <script>
        $(function() {
            $("body").on("click", ".btn-edit", function() {
                let topic = $(this).data("topic");

                $("#editTopic #title").val(topic.title);
                $("#editTopic form").attr("action",
                    `{{ url('/') }}/training/${topic.training_id}/topic/${topic.id}`);
            })
        })
    </script>
@endpush
