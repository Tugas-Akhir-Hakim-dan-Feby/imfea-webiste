@props([
    'id' => null,
    'label' => null,
    'type' => 'text',
    'size' => null,
    'rows' => '2',
    'cols' => '2',
    'value' => null,
    'margin' => 'mb-3',
    'autofocus' => false,
    'required' => false,
    'placeholder' => '',
    'error' => null,
])

<div @class([$margin])>
    <x-label :for="$id" :label="$label" />
    <textarea @class([
        'form-control',
        $size ? "form-control-$size" : '',
        $error ? 'is-invalid' : '',
    ]) {{ $id ? "name=$id id=$id" : '' }} {{ $autofocus ? 'autofocus' : '' }}
        {{ $required ? 'required' : '' }} placeholder="{{ $placeholder }}" value="{{ $value }}"
        rows="{{ $rows }}" cols="{{ $cols }}"></textarea>
    <div class="invalid-feedback">
        {{ $error ?? 'ini wajib diisi!' }}
    </div>
</div>
