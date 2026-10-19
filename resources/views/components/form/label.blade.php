@props(['for', 'optional' => false])

<label for="{{ $for }}" {{ $attributes->merge(['class' => 'form-label']) }}>
    {{ $slot }}@if ($optional)<span class="font-normal text-charcoal-500"> (optional)</span>@endif
</label>
