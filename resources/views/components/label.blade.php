@props([
    'label' => null,
    'for' => null,
    'class' => null,
])

@if ($label || !$slot->isEmpty())
    <label for="{{ $for }}" class="{{ $class }}">
        {{ $label ?? $slot }}
    </label>
@endif
