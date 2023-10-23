@props([
    'color' => 'primary',
    'size' => null,
    'label' => null,
    'route' => null,
    'url' => null,
    'href' => null,
    'type' => 'button',
    'dismiss' => null,
    'toggle' => null,
])

@php
    if ($route) {
        $href = route($route);
    } elseif ($url) {
        $href = url($url);
    }
@endphp

<{{ $href ? 'a' : 'button' }} @class(['btn', 'btn-' . $color, 'btn-' . $size]) {{ !$href ? "type=$type" : "href=$href" }}
    {{ $toggle ? "data-bs-toggle=$toggle" : null }} {{ $dismiss ? "data-bs-dismiss=$dismiss" : null }}>
    {{ $label ?? $slot }}
    </{{ $href ? 'a' : 'button' }}>
