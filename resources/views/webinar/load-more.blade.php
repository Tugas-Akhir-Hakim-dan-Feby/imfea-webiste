@php
    use Carbon\Carbon;
@endphp
@foreach ($webinars as $webinar)
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
