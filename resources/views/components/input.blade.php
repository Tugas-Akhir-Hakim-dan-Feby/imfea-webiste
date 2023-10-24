@props([
    'id' => '',
    'label' => null,
    'type' => 'text',
    'size' => null,
    'value' => null,
    'margin' => 'mb-3',
    'autofocus' => false,
    'required' => false,
    'placeholder' => '',
    'error' => null,
])

<div @class([$margin])>
    <x-label :for="$id" :label="$label" />
    <input type="{{ $type }}" @class([
        'form-control',
        $size ? "form-control-$size" : '',
        $error ? 'is-invalid' : '',
    ]) name="{{ $id }}" id="{{ $id }}"
        {{ $autofocus ? 'autofocus' : '' }} {{ $required ? 'required' : '' }} placeholder="{{ $placeholder }}"
        value="{{ $value }}">
    <div class="invalid-feedback">
        {{ $error ?? 'ini wajib diisi!' }}
    </div>
</div>
