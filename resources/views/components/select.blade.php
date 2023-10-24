@props([
    'id' => null,
    'label' => null,
    'placeholder' => null,
    'options' => [],
    'size' => null,
    'error' => null,
    'required' => null,
    'margin' => 'mb-3',
])

@php
    $attributes = $attributes->class(['form-select', "form-select-$size" => $size, 'is-invalid' => $error])->merge([
        'name' => $id,
        'id' => $id,
        'required' => $required,
    ]);
@endphp

<div @class([$margin])>
    <x-label :for="$id" :label="$label" />
    <select {{ $attributes }}>
        @if ($placeholder)
            <option selected disabled>{{ $placeholder }}</option>
        @endif

        {{ $slot }}

    </select>
    <div class="invalid-feedback">
        {{ $error ?? 'ini wajib diisi!' }}
    </div>
</div>
