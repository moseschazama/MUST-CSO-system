@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'align' => 'left',
    'tone' => 'light',
])

@php
    $titleClasses = $tone === 'dark' ? 'text-ivory-50' : 'text-charcoal-900';
    $eyebrowClasses = $tone === 'dark' ? 'text-gold-300' : 'text-gold-700';
    $descriptionClasses = $tone === 'dark' ? 'text-ivory-100/80' : 'text-charcoal-700';
    $wrapperClasses = $align === 'center' ? 'mx-auto max-w-3xl text-center' : 'max-w-3xl';
@endphp

<div {{ $attributes->merge(['class' => $wrapperClasses]) }}>
    @if ($eyebrow)
        <p class="eyebrow {{ $eyebrowClasses }}">{{ $eyebrow }}</p>
    @endif

    @if ($title)
        <h2 class="mt-3 font-serif text-3xl leading-tight sm:text-4xl lg:text-[2.75rem] {{ $titleClasses }}">
            {{ $title }}
        </h2>
    @endif

    @if ($description)
        <p class="mt-4 text-base leading-relaxed {{ $descriptionClasses }}">{{ $description }}</p>
    @endif

    {{ $slot }}
</div>
