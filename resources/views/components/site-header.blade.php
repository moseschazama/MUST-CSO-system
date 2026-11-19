@props(['transparent' => false, 'home' => false])

@php
    $links = [
        ['label' => 'Home', 'route' => 'home', 'pattern' => 'home'],
        ['label' => 'About Us', 'route' => 'about', 'pattern' => 'about'],
        ['label' => 'Leadership', 'route' => 'leadership', 'pattern' => 'leadership'],
        ['label' => 'Activities', 'route' => 'activities', 'pattern' => 'activities*'],
        ['label' => 'News & Events', 'route' => 'news', 'pattern' => ['news', 'news.*', 'events.*']],
        ['label' => 'Gallery', 'route' => 'gallery', 'pattern' => 'gallery'],
        ['label' => 'Contact', 'route' => 'contact', 'pattern' => 'contact'],
    ];
@endphp

<header
    id="site-header"
    @class([
        'fixed inset-x-0 top-3 z-50 sm:top-4',
        'site-header-transparent' => $transparent,
    ])
>
    <div class="container-page">
        <div class="site-header-bar flex h-14 items-center justify-between gap-4 rounded-full border border-slate-200/70 bg-white/95 px-4 shadow-[0_8px_30px_-12px_rgba(15,23,42,.12)] backdrop-blur-xl transition-all duration-300 sm:gap-6 sm:px-7 lg:h-16">
            <a href="{{ route('home') }}" class="flex shrink-0 items-center gap-2.5" aria-label="{{ config('cso.org.name') }} home">
                @if (filled(config('cso.org.logo')))
                    <span class="grid h-10 w-10 shrink-0 place-items-center overflow-hidden rounded-full bg-white ring-1 ring-slate-200 sm:h-11 sm:w-11">
                        <img src="{{ config('cso.org.logo') }}" alt="{{ config('cso.org.name') }} logo" class="h-full w-full object-contain p-0.5">
                    </span>
                @else
                    <span class="grid h-10 w-10 shrink-0 place-items-center rounded-full bg-brand-700 text-white sm:h-11 sm:w-11">
                        <x-icon name="cross" class="h-4 w-4 sm:h-5 sm:w-5" />
                    </span>
                @endif
                <span class="text-sm font-extrabold tracking-wide text-slate-900 sm:text-base">MUST CSO</span>
            </a>

            <nav class="hidden flex-1 items-center justify-center gap-5 xl:gap-6 lg:flex" aria-label="Main navigation">
                @foreach ($links as $link)
                    @php($active = request()->routeIs($link['pattern']))
                    <a
                        href="{{ route($link['route']) }}"
                        @class([
                            'text-xs tracking-[0.14em] uppercase transition whitespace-nowrap',
                            'font-bold text-brand-800' => $active,
                            'font-medium text-slate-900 hover:text-slate-600' => ! $active,
                        ])
                        @if ($active) aria-current="page" @endif
                    >{{ $link['label'] }}</a>
                @endforeach
            </nav>

            <div class="hidden shrink-0 md:flex md:items-center">
                <a href="{{ route('daily-readings') }}" class="inline-flex items-center justify-center rounded-full bg-brand-700 px-5 py-2.5 text-xs font-semibold tracking-wide text-white uppercase shadow-[0_10px_24px_-12px_rgba(27,63,130,.65)] transition hover:bg-brand-800">
                    Get Reflection
                </a>
            </div>

            <button
                type="button"
                id="menu-toggle"
                class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-900 transition hover:border-brand-200 hover:bg-brand-50 hover:text-brand-800 lg:hidden"
                aria-expanded="false"
                aria-controls="mobile-menu"
                aria-label="Open menu"
            >
                <x-icon name="menu" class="h-4 w-4" id="menu-icon-open" />
                <x-icon name="x" class="hidden h-4 w-4" id="menu-icon-close" />
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden mx-auto mt-2 w-[calc(100%-1.5rem)] max-w-7xl overflow-hidden rounded-3xl border border-slate-200/70 bg-white/98 p-3 shadow-xl backdrop-blur-xl lg:hidden">
        <nav class="grid gap-1" aria-label="Mobile navigation">
            @foreach ($links as $link)
                @php($active = request()->routeIs($link['pattern']))
                <a
                    href="{{ route($link['route']) }}"
                    @class([
                        'flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-semibold uppercase tracking-wide transition',
                        'bg-brand-50 text-brand-800 ring-1 ring-brand-100' => $active,
                        'text-slate-700 hover:bg-slate-50' => ! $active,
                    ])
                    @if ($active) aria-current="page" @endif
                >
                    {{ $link['label'] }}
                    <x-icon name="chevron-right" class="h-4 w-4 opacity-40" />
                </a>
            @endforeach
            <div class="mt-2">
                <a href="{{ route('daily-readings') }}" class="inline-flex w-full items-center justify-center rounded-full bg-brand-700 px-5 py-3 text-xs font-bold tracking-[0.16em] text-white uppercase transition hover:bg-brand-800">
                    Get Reflection
                </a>
            </div>
        </nav>
    </div>
</header>
