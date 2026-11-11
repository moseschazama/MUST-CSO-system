@props(['eyebrow' => null, 'title' => null, 'description' => null, 'center' => false])

<div @class(['max-w-2xl', 'mx-auto text-center' => $center])>
    @if ($eyebrow)
        <p class="eyebrow">{{ $eyebrow }}</p>
    @endif

    <h2 class="mt-3 text-3xl font-extrabold text-balance text-ink-900 sm:text-4xl">
        {{ $title }}
    </h2>

    @if ($description)
        <p class="lead mt-4">{{ $description }}</p>
    @endif
</div>
