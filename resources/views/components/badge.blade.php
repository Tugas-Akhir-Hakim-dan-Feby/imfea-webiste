@props([
    'label' => null,
    'color' => 'primary',
])

<span class="badge bg-{{ $color }}">
    {{ $label ?? $slot }}
</span>
