@props([
    'label' => null,
    'for' => null,
    'class' => null,
])

@php
    $attributes = $attributes->class(["$class"])->merge([
        'for' => $for,
    ]);
@endphp

@if ($label || !$slot->isEmpty())
    <label {{ $attributes }}>
        {{ $label ?? $slot }}
    </label>
@endif
