<x-card>
    <x-slot:header class="d-flex justify-content-between align-items-center">
        <h3 class="fw-normal">Daftar Materi</h3>
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
    </x-slot:body>
</x-card>
