@props([
    'id' => null,
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

@php
    $attributes = $attributes->class(['form-control', "form-control-$size" => $size, 'is-invalid' => $error])->merge([
        'type' => $type,
        'name' => $id,
        'id' => $id,
        'required' => $required,
        'placeholder' => $placeholder,
        'value' => $value,
        'autofocus' => $autofocus,
    ]);
@endphp

<div @class([$margin])>
    <x-label :for="$id" :label="$label" />
    <input {{ $attributes }}>
    <div class="invalid-feedback">
        {{ $error ?? 'ini wajib diisi!' }}
    </div>
</div>
