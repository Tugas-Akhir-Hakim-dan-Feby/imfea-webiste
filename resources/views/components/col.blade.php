@props([
    'xs' => '12',
    'sm' => '12',
    'md' => '12',
    'lg' => '12',
    'xl' => '12',
])

<div
    class="col-xs-{{ $xs }} col-sm-{{ $sm }} col-md-{{ $md }} col-lg-{{ $lg }} col-xl-{{ $xl }}">
    {{ $slot }}
</div>
