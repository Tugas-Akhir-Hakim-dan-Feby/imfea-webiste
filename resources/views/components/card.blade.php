@props(['header' => null, 'footer' => null, 'image' => null])
<div class="card">
    @if ($image)
        <img src="{{ $image }}" class="card-img-top">
    @endif
    @if ($header)
        <div class="card-header">
            {{ $header }}
        </div>
    @endif

    <div class="card-body">
        {{ $slot }}
    </div>

    @if ($footer)
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>
