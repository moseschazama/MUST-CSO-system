@props(['transparent' => false])

@php
    $links = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'About Us', 'route' => 'about'],
        ['label' => 'Leadership', 'route' => 'leadership'],
        ['label' => 'Activities', 'route' => 'activities'],
        ['label' => 'News & Events', 'route' => 'news'],
        ['label' => 'Gallery', 'route' => 'gallery'],
        ['label' => 'Contact', 'route' => 'contact'],
    ];
@endphp

<header
    id="site-header"
    @class([
        'absolute inset-x-0 top-0 z-50' => $transparent,
        'relative z-40' => ! $transparent,
    ])
>
    <div class="container-page pt-3 sm:pt-4">
        <div class="site-header-bar flex h-14 items-center justify-between gap-6 rounded-full border border-slate-200/80 bg-white px-5 shadow-[0_8px_30px_-12px_rgba(15,23,42,.18)] transition-all duration-300 sm:px-7 lg:h-16">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5" aria-label="{{ config('cso.org.name') }} home">
                <span class="grid h-9 w-9 place-items-center rounded-lg bg-slate-900 text-white">
                    <x-icon name="sparkles" class="h-4 w-4" />
                </span>
                <span class="text-sm font-extrabold tracking-wide text-slate-900 sm:text-base">MUST CSO</span>
            </a>

            {{-- Desktop navigation --}}
            <nav class="hidden flex-1 items-center justify-center gap-6 lg:flex" aria-label="Main navigation">
                @foreach ($links as $link)
                    <a
                        href="{{ route($link['route']) }}"
                        class="text-xs font-medium tracking-[0.14em] text-slate-900 uppercase transition hover:text-slate-600 {{ request()->routeIs($link['route']) ? 'font-bold' : '' }}"
                        @if (request()->routeIs($link['route'])) aria-current="page" @endif
                    >{{ $link['label'] }}</a>
                @endforeach
            </nav>

            {{-- Desktop CTA --}}
            <div class="hidden shrink-0 md:flex">
                <a href="{{ route('gallery') }}" class="inline-flex items-center justify-center rounded-full bg-[#8a7a32] px-5 py-2.5 text-xs font-semibold tracking-wide text-white uppercase transition hover:bg-[#7a6a28]">
                    Get Involved
                </a>
            </div>

            {{-- Mobile toggle --}}
            <button
                type="button"
                id="menu-toggle"
                class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-900 transition hover:border-slate-300 lg:hidden"
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="Open menu"
            >
                <x-icon name="menu" class="h-4 w-4" id="menu-icon-open" />
                <x-icon name="x" class="hidden h-4 w-4" id="menu-icon-close" />
            </button>
        </div>
    </div>

    {{-- Mobile panel --}}
    <div id="mobile-menu" class="hidden mx-auto mt-2 w-[calc(100%-1.5rem)] max-w-7xl overflow-hidden rounded-3xl border border-slate-200/80 bg-white p-3 shadow-lg lg:hidden">
        <nav class="grid gap-1" aria-label="Mobile navigation">
            @foreach ($links as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-semibold uppercase tracking-wide transition {{ request()->routeIs($link['route']) ? 'bg-slate-100 text-slate-900' : 'text-slate-700 hover:bg-slate-50' }}"
                >
                    {{ $link['label'] }}
                    <x-icon name="chevron-right" class="h-4 w-4 opacity-40" />
                </a>
            @endforeach

            <div class="mt-3">
                <a href="{{ route('contact') }}#join" class="inline-flex w-full items-center justify-center rounded-full bg-[#8a7a32] px-4 py-2.5 text-xs font-semibold tracking-wide text-white uppercase transition hover:bg-[#7a6a28]">
                    Get Involved
                </a>
            </div>
        </nav>
    </div>
</header>