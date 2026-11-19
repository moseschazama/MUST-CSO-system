@props(['url' => null, 'label' => 'Featured MUST CSO TikTok video'])

@php
    $videoId = null;
    if (filled($url) && preg_match('~tiktok\.com/[^?/]+/video/(\d+)~', $url, $matches)) {
        $videoId = $matches[1];
    }
@endphp

@if ($videoId)
    <div class="relative mx-auto w-full max-w-sm overflow-hidden rounded-[1.75rem] bg-ink-950 shadow-[0_30px_70px_-30px_rgba(1,6,17,.75)] ring-1 ring-white/10">
        <div class="relative aspect-[9/16] w-full">
            <iframe
                class="absolute inset-0 h-full w-full"
                src="https://www.tiktok.com/embed/v2/{{ $videoId }}"
                title="{{ $label }}"
                allow="autoplay; fullscreen; encrypted-media; picture-in-picture"
                allowfullscreen
                loading="lazy"
                referrerpolicy="strict-origin-when-cross-origin"
            ></iframe>
        </div>
    </div>
@endif
