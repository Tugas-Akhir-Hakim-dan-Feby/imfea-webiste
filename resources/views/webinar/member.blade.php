@php
    use Carbon\Carbon;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[['link' => route('web.home.index'), 'text' => 'Dashboard']]" />

    @if (session('successMessage'))
        <x-alert class="mb-3" color="success">
            {{ session('successMessage') }}
        </x-alert>
    @endif

    @if (session('dangerMessage'))
        <x-alert class="mb-3" color="danger">
            {{ session('dangerMessage') }}
        </x-alert>
    @endif

    <x-row id="loadMore">
        @foreach ($webinars as $webinar)
            @php
                $activityDate = Carbon::parse($webinar->activity_date);
                $daysDifference = now()->diffInDays($activityDate);
            @endphp
            <x-col lg="3" md="4" sm="6" xl="3" class="mb-4">
                <x-card class="h-100 shadow-lg" :image="route('web.webinar.background', $webinar)">
                    <x-slot:body class="h-100 text-dark">
                        <h4 class="card-title">{{ $webinar->title }}</h4>
                        <p class="small m-0">
                            <span>
                                <x-icon name="mdi mdi-calendar" />
                                {{ Carbon::createFromFormat('Y-m-d H:i:s', $webinar->activity_date)->isoFormat('DD MMM YYYY') }}
                            </span>
                            <span> |
                                <x-icon name="dripicons-alarm" />
                                {{ $webinar->activity_time }}
                            </span>
                            <span> |
                                <x-icon name="dripicons-pin" />
                                Online
                            </span>
                            |
                            <x-icon name="dripicons-user-group" />&nbsp;
                            <x-badge color="info">0 Peserta</x-badge>
                            <span> |
                                <x-icon name="dripicons-checkmark" />
                                Materi & Sertifikat
                            </span>
                        </p>
                    </x-slot:body>
                    <x-slot:footer class="d-flex justify-content-between align-items-center">
                        @if ($daysDifference < 2)
                            @if ($webinar->webinarParticipant)
                                <x-button label="Detail" class="text-white w-100" color="info" size="sm" />
                            @else
                                <span class="btn btn-sm btn-light">Pendaftaran Ditutup</span>
                            @endif
                        @else
                            @if ($webinar->webinarParticipant)
                                <x-button label="Detail" class="text-white w-100" color="info" size="sm" />
                            @else
                                <x-button label="Daftar" class="text-white w-100 btn-register" color="primary"
                                    size="sm" toggle="modal" target="#registerWebinar"
                                    data-webinar="{{ $webinar }}" />
                            @endif
                        @endif
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
    <x-modal id="registerWebinar" title="Daftar Webinar <span id='title'></span>"
        form="{{ route('web.webinar.register', 1) }}">
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
            let page = {{ $webinars->currentPage() }};
            const lastPage = {{ $webinars->lastPage() }};

            if (page == lastPage) {
                $('#loadMoreBtn').hide();
            }

            $('#loadMoreBtn').on('click', function() {
                if (page < lastPage) {
                    page++;

                    $.ajax({
                        url: '{{ route('web.webinar.load.more') }}',
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
                let webinar = $(this).data('webinar')

                $(`${target} form`).attr('action', `{{ url('webinar/register/') }}/${webinar.id}`)
                $(`${target} #title`).html(`(${webinar.title})`)
            })
        })
    </script>
@endpush
