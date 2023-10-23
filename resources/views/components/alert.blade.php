@props([
    'label' => null,
    'color' => 'success',
    'dismissible' => false,
])

<div class="alert alert-{{ $color }} fade show mb-0 {{ $dismissible ? 'alert-dismissible' : '' }}">
    {{ $label ?? $slot }}

    @if ($dismissible)
        <x-close dismiss="alert"></x-close>
    @endif
</div>
