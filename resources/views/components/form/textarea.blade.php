@props(['name', 'value' => null, 'rows' => 6])

@php
    $id = $attributes->get('id', $name);
    $textareaClasses = 'form-input'.($errors->has($name) ? ' border-red-700' : '');
@endphp

<textarea
    name="{{ $name }}"
    id="{{ $id }}"
    rows="{{ $rows }}"
    @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif
    {{ $attributes->except(['id'])->merge(['class' => $textareaClasses]) }}
>{{ old($name, $value) }}</textarea>

@error($name)
    <p id="{{ $id }}-error" class="form-error">{{ $message }}</p>
@enderror
