@props([
    'color' => 'primary',
    'size' => null,
    'label' => null,
    'route' => null,
    'parameter' => null,
    'url' => null,
    'href' => null,
    'type' => 'button',
    'dismiss' => null,
    'toggle' => null,
    'target' => null,
])

@php
    if ($route) {
        $href = route($route, $parameter);
    } elseif ($url) {
        $href = url($url);
    }

    $attributes = $attributes->class(["btn btn-$color", "btn-$size" => $size])->merge(['type' => !$href ? $type : null, 'href' => $href, 'data-bs-dismiss' => $dismiss, 'data-bs-toggle' => $toggle, 'data-bs-target' => $target]);
@endphp

<{{ $href ? 'a' : 'button' }} {{ $attributes }}>
    {{ $label ?? $slot }}
    </{{ $href ? 'a' : 'button' }}>
