@props([
    'eyebrow' => null,
    'title' => null,
    'description' => null,
    'image' => null,
    'imagePosition' => 'center 25%',
    'breadcrumbs' => [],
])

@php
    $crumbs = is_array($breadcrumbs) ? $breadcrumbs : (filled($breadcrumbs) ? [$breadcrumbs => null] : []);
    $heroImage = $image ?: asset('images/gallery/community-1.jpg');
@endphp

<section class="page-hero relative isolate flex min-h-[380px] w-full items-center overflow-hidden bg-brand-950 sm:min-h-[430px] lg:min-h-[480px]">
    <img src="{{ $heroImage }}" alt="" aria-hidden="true"
         class="absolute inset-0 -z-20 h-full w-full object-cover"
         style="object-position: {{ $imagePosition }};">
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950/92 via-brand-950/82 to-brand-900/55"></div>
    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950/75 via-ink-900/20 to-ink-950/30"></div>
    <div class="pointer-events-none absolute -right-20 -top-20 -z-10 h-72 w-72 rounded-full bg-brand-400/20 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-16 left-1/3 -z-10 h-56 w-56 rounded-full bg-gold-500/10 blur-3xl"></div>

    <div class="container-page relative w-full pt-32 pb-14 sm:pt-36 sm:pb-16 lg:pt-40 lg:pb-20">
        <div class="max-w-4xl">
            @if (count($crumbs))
                <nav aria-label="Breadcrumb" class="mb-6">
                    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-bold tracking-[0.16em] text-white/65 uppercase">
                        <li><a href="{{ route('home') }}" class="transition hover:text-white">Home</a></li>
                        @foreach ($crumbs as $label => $url)
                            <li aria-hidden="true" class="text-white/30">
                                <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                            </li>
                            <li class="min-w-0">
                                @if ($url)
                                    <a href="{{ $url }}" class="transition hover:text-white">{{ $label }}</a>
                                @else
                                    <span class="text-white/95" aria-current="page">{{ $label }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ol>
                </nav>
            @endif

            @if ($eyebrow)
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-1.5 text-[10px] font-bold tracking-[0.2em] text-white/90 uppercase backdrop-blur-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                    {{ $eyebrow }}
                </span>
            @endif

            <h1 class="mt-5 max-w-3xl text-4xl leading-[1.05] font-extrabold text-balance text-white sm:text-5xl lg:text-[3.5rem]">
                {{ $title }}
            </h1>

            @if ($description)
                <p class="mt-5 max-w-2xl text-base leading-relaxed text-white/80 sm:text-lg">{{ $description }}</p>
            @endif

            @isset($actions)
                <div class="mt-8 flex flex-wrap gap-3">{{ $actions }}</div>
            @endisset
        </div>

        @if (trim($slot))
            <div class="mt-8">
                {{ $slot }}
            </div>
        @endif
    </div>
</section>
