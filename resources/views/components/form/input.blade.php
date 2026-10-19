@props(['name', 'type' => 'text', 'value' => null])

@php
    $id = $attributes->get('id', $name);
    $inputClasses = 'form-input'.($errors->has($name) ? ' border-red-700' : '');
@endphp

<input
    type="{{ $type }}"
    name="{{ $name }}"
    id="{{ $id }}"
    value="{{ old($name, $value) }}"
    @if ($errors->has($name)) aria-invalid="true" aria-describedby="{{ $id }}-error" @endif
    {{ $attributes->except(['id', 'value'])->merge(['class' => $inputClasses]) }}
>

@error($name)
    <p id="{{ $id }}-error" class="form-error">{{ $message }}</p>
@enderror
