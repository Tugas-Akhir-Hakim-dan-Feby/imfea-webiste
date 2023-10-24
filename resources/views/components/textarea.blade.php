@props([
    'id' => null,
    'label' => null,
    'type' => 'text',
    'size' => null,
    'rows' => null,
    'cols' => null,
    'value' => null,
    'margin' => 'mb-3',
    'autofocus' => false,
    'required' => false,
    'placeholder' => '',
    'error' => null,
])

@php
    $attributes = $attributes->class(['form-control', "form-control-$size" => $size, 'is-invalid' => $error])->merge([
        'name' => $id,
        'id' => $id,
        'autofocus' => $autofocus,
        'required' => $required,
        'placeholder' => $placeholder,
        'value' => $value,
        'rows' => $rows,
        'cols' => $cols,
    ]);
@endphp

<div @class([$margin])>
    <x-label :for="$id" :label="$label" />
    <textarea {{ $attributes }}></textarea>
    <div class="invalid-feedback">
        {{ $error ?? 'ini wajib diisi!' }}
    </div>
</div>
