@props(['name', 'checked' => false])

<div>
    <input type="hidden" name="{{ $name }}" value="0">

    <label for="{{ $attributes->get('id', $name) }}" class="flex items-start gap-3">
        <input
            type="checkbox"
            name="{{ $name }}"
            id="{{ $attributes->get('id', $name) }}"
            value="1"
            @checked(old($name, $checked))
            {{ $attributes->except(['id'])->merge(['class' => 'form-checkbox mt-0.5']) }}
        >
        <span class="text-sm leading-relaxed text-charcoal-800">{{ $slot }}</span>
    </label>

    @error($name)
        <p class="form-error">{{ $message }}</p>
    @enderror
</div>
