@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[
        ['link' => route('web.home.index'), 'text' => 'Dashboard'],
        ['link' => route('web.training.index'), 'text' => 'Pelatihan'],
    ]" />

    @if (session('successMessage'))
        <x-alert class="mb-3" color="success">
            {{ session('successMessage') }}
        </x-alert>
    @endif

    <x-row id="loadMore">
        @foreach ($trainings as $training)
            <x-col lg="3" md="4" sm="6" xl="3" class="mb-4">
                <x-card class="h-100 shadow-lg" :image="$training->thumbnail">
                    <x-slot:body class="h-100">
                        <h4 class="card-title">{{ $training->title }}</h4>
                        <p class="small m-0">
                            <span>
                                <x-icon name="mdi mdi-calendar" />
                                {{ Carbon::createFromFormat('Y-m-d H:i:s', $training->created_at)->isoFormat('DD MMM YYYY') }}
                            </span>
                            <span> |
                                <x-icon name="dripicons-pin" />
                                Online
                            </span>
                            |
                            <x-icon name="dripicons-user-group" />&nbsp;
                            <x-badge color="info">{{ $training->participants->count() }} Peserta</x-badge>
                            <span> |
                                <x-icon name="dripicons-checkmark" />
                                Materi & Sertifikat
                            </span>
                        </p>
                    </x-slot:body>
                    <x-slot:footer class="d-flex justify-content-between align-items-center">
                        <x-button label="Daftar" class="text-white w-100 btn-register" color="primary" size="sm"
                            toggle="modal" target="#registerTraining" data-training="{{ $training }}" />
                    </x-slot:footer>
                </x-card>
            </x-col>
        @endforeach
    </x-row>

    <div class="text-center mb-4">
        <x-button size="sm" color="light" id="loadMoreBtn">
            Load More <x-icon name="dripicons-clockwise" />
        </x-button>
    </div>
@endsection

@push('modal')
    <x-modal id="registerTraining" title="Daftar Training <span id='title'></span>"
        form="{{ route('web.training.register', 1) }}">
        <x-input label="Nama Pendaftar" id="name" disabled value="{{ auth()->user()->name }}" />
        <x-input label="Email Pendaftar" id="email" disabled value="{{ auth()->user()->email }}" />

        <x-slot:footer class="d-flex justify-content-between">
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Batal</button>
            <x-button type="submit" color="primary" size="sm" label="Daftar" />
        </x-slot:footer>
    </x-modal>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            let page = {{ $trainings->currentPage() }};
            const lastPage = {{ $trainings->lastPage() }};

            if (page == lastPage) {
                $('#loadMoreBtn').hide();
            }

            $('#loadMoreBtn').on('click', function() {
                if (page < lastPage) {
                    page++;

                    $.ajax({
                        url: '{{ route('web.training.load.more') }}',
                        data: {
                            page: page
                        },
                        method: 'GET',
                        success: function(data) {
                            $('#loadMore').append(data);

                            if (page === lastPage) {
                                $('#loadMoreBtn').hide();
                            }
                        }
                    });
                } else {
                    $('#loadMoreBtn').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("body").on("click", ".btn-register", function() {
                let target = $(this).data('bs-target');
                let training = $(this).data('training')

                $(`${target} form`).attr('action', `{{ url('training/register/') }}/${training.id}`)
                $(`${target} #title`).html(`(${training.title})`)
            })
        })
    </script>
@endpush
