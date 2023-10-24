@props(['currentPage' => '', 'pages' => []])

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @if (count($pages) < 1)
            <li class="breadcrumb-item active" aria-current="page">{{ $currentPage }}</li>
        @else
            @foreach ($pages as $page)
                <li class="breadcrumb-item"><a href="{{ $page['link'] }}">{{ $page['text'] }}</a></li>
            @endforeach
            <li class="breadcrumb-item active" aria-current="page">{{ $currentPage }}</li>
        @endif
    </ol>
</nav>
