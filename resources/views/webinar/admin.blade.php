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
        <x-col lg="3" md="4" sm="6" xl="3" class="mb-4">
            <x-link route="web.webinar.create">
                <x-card class="bg-primary h-100 shadow-lg">
                    <x-slot:body
                        class="h-100 d-flex justify-content-center flex-column align-items-center text-white text-center">
                        <i class=" uil-folder-medical" style="font-size: 5em"></i>
                        <p class="mt-3 fw-bold">Tambah Webinar</p>
                    </x-slot:body>
                </x-card>
            </x-link>
        </x-col>

        @foreach ($webinars as $webinar)
            <x-col lg="3" md="4" sm="6" xl="3" class="mb-4">
                <x-card class="h-100 shadow-lg" :image="$webinar->thumbnail ? url($webinar->thumbnail) : route('web.webinar.background', $webinar)">
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
                            <x-badge color="info">{{ $webinar->participants->count() }} Peserta</x-badge>
                            <span> |
                                <x-icon name="dripicons-checkmark" />
                                Materi & Sertifikat
                            </span>
                        </p>
                    </x-slot:body>
                    <x-slot:footer class="d-flex justify-content-between align-items-center">
                        <x-button label="Edit" class="text-white" color="warning" size="sm" route="web.webinar.edit"
                            :parameter="$webinar" />
                        <form action="{{ route('web.webinar.destroy', $webinar) }}" method="post">
                            @csrf
                            @method('delete')
                            <x-button label="Hapus" class="btn-delete" color="danger" size="sm" />
                        </form>
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
@endpush
