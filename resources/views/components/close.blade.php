@props([
    'color' => null,
    'dismiss' => null,
])

<button class="btn-close btn-close-{{ $color }}" type="button" {{ $dismiss ? "data-bs-dismiss=$dismiss" : null }}>
</button>
