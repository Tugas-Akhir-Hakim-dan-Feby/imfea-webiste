@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[['link' => route('web.home.index'), 'text' => 'Dashboard']]" />

    @include('templates.alert')

    <x-row>
        @foreach ($news as $news)
            <x-col xl="3" lg="3" md="4" sm="6">
                <x-link color="dark" route="web.news.show.slug" :parameter="[
                    'date' => date('d', strtotime($news->created_at)),
                    'month' => date('m', strtotime($news->created_at)),
                    'year' => date('Y', strtotime($news->created_at)),
                    'slug' => $news->slug,
                ]">
                    <x-card :image="$news->thumbnail">
                        <h5 class="card-title">{{ Str::limit($news->title, 75, '...') }}</h5>
                        <span class="d-flex align-items-center">
                            <x-icon name="dripicons-alarm" class="me-1" />
                            {{ Carbon::createFromFormat('Y-m-d H:i:s', $news->created_at)->isoFormat('DD MMM YYYY') }}
                        </span>

                        <x-slot:footer>
                            <x-button class="w-100" label="Selengkapnya..."></x-button>
                        </x-slot:footer>
                    </x-card>
                </x-link>
            </x-col>
        @endforeach
    </x-row>
@endsection
