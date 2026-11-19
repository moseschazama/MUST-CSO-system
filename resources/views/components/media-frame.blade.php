@props([
    'image' => null,
    'video' => null,
    'poster' => null,
    'alt' => '',
    'ratio' => 'aspect-[4/3]',
    'label' => 'Preview video',
    'seed' => 0,
    'imagePosition' => 'center 22%',
])

@php
    $fallbacks = (array) config('cso.media_fallbacks');
    $fallback = $fallbacks ? $fallbacks[$seed % count($fallbacks)] : null;
    $posterSrc = $poster ?: $image ?: $fallback;
    $resolvedPosition = request()->routeIs('home') ? 'center center' : $imagePosition;
@endphp

{{-- The card around this frame owns the `group` class, so the photograph
     zooms gently on hover while the shade and play button stay put. --}}
<div {{ $attributes->merge(['class' => 'media-frame '.$ratio]) }}>
    @if ($posterSrc)
        <img src="{{ $posterSrc }}" alt="{{ $alt }}" loading="lazy" style="object-position: {{ $resolvedPosition }};">
    @endif

    <span class="media-shade"></span>

    {{ $slot }}

    @if (filled($video))
        <button
            type="button"
            class="media-play"
            data-video-preview="{{ $video }}"
            data-video-poster="{{ $posterSrc }}"
            data-video-title="{{ $alt }}"
            aria-label="Play video: {{ $alt }}"
        >
            <span class="media-play-ring" aria-hidden="true"></span>
            <span class="media-play-btn">
                <x-icon name="play" class="ml-0.5 h-6 w-6" />
            </span>
        </button>
        <span class="media-play-label">{{ $label }}</span>
    @endif
</div>
