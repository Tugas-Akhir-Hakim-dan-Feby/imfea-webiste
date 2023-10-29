@props([
    'name' => null,
    'size' => null,
    'color' => null,
])

@php
    $attributes = $attributes->class([$name, $size => $size, "text-$color" => $color])->merge([]);
@endphp

@if ($name)
    <i {{ $attributes }}></i>
@endif
