@php
    use Carbon\Carbon;
    use Illuminate\Support\Str;
@endphp

@extends('templates.app')

@section('content')
    <x-header-page :title="$title" :options="[
        ['link' => route('web.home.index'), 'text' => 'Dashboard'],
        ['link' => route('web.news.index'), 'text' => 'Berita'],
    ]" />

    @if (session('successMessage'))
        <x-alert class="mb-3" color="success">
            {{ session('successMessage') }}
        </x-alert>
    @endif

    <x-row>
        <x-col>
            <x-card :image="$news->thumbnail" imageHeight="400px">
                <h3 class="card-title">{{ $news->title }}</h3>
                <small class="d-flex align-items-center mb-3">
                    <x-icon name="dripicons-alarm" class="me-1" />
                    {{ Carbon::createFromFormat('Y-m-d H:i:s', $news->created_at)->isoFormat('DD MMM YYYY') }}
                </small>
                <div class="card-text">
                    {!! $news->content !!}
                </div>
            </x-card>
        </x-col>
    </x-row>
@endsection
