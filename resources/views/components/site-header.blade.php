@php
    $navigation = [
        ['label' => 'Home', 'url' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'About', 'url' => route('about'), 'active' => request()->routeIs('about')],
        ['label' => 'Events', 'url' => route('events.index'), 'active' => request()->routeIs('events.*')],
        ['label' => 'Faith Formation', 'url' => route('home').'#faith-formation', 'active' => false],
        ['label' => 'Community', 'url' => route('home').'#community', 'active' => false],
        ['label' => 'Contact', 'url' => route('contact'), 'active' => request()->routeIs('contact*')],
    ];
@endphp

<header class="sticky top-0 z-40 border-b border-charcoal-900/10 bg-ivory-50/95 backdrop-blur">
    <div class="theme-dark hidden bg-burgundy-950 text-ivory-100 sm:block">
        <div class="container-page flex flex-wrap items-center justify-between gap-x-4 gap-y-1 py-2 text-xs">
            <p class="font-semibold uppercase tracking-[0.18em]">MUST Catholic Students Organisation</p>
            <p class="text-gold-300">Faith. Fellowship. Service.</p>
        </div>
    </div>

    <div class="container-page flex items-center justify-between gap-4 py-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <x-brand-mark class="h-11 w-11 text-burgundy-800" />
            <span class="font-serif text-lg font-semibold leading-tight text-burgundy-950">
                Catholic Students
                <span class="block font-sans text-xs font-semibold uppercase tracking-[0.2em] text-gold-700">
                    Organisation at MUST
                </span>
            </span>
        </a>

        <nav aria-label="Primary" class="hidden items-center gap-6 lg:flex">
            @foreach ($navigation as $item)
                <a
                    href="{{ $item['url'] }}"
                    class="nav-link @if ($item['active']) nav-link-active @endif"
                    @if ($item['active']) aria-current="page" @endif
                >
                    {{ $item['label'] }}
                </a>
            @endforeach

            <a href="{{ route('contact') }}" class="btn btn-primary">Get in touch</a>
        </nav>

        <button
            type="button"
            class="inline-flex items-center gap-2 border border-charcoal-900/20 px-4 py-2 text-sm font-semibold text-charcoal-900 lg:hidden"
            aria-controls="site-menu"
            aria-expanded="false"
            data-mobile-menu-button
        >
            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="h-5 w-5">
                <path d="M3 5h14M3 10h14M3 15h14" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
            </svg>
            Menu
        </button>

        <noscript>
            <style>
                [data-mobile-menu-button] { display: none !important; }
                [data-mobile-menu] { display: block !important; }
            </style>
        </noscript>
    </div>

    <div id="site-menu" class="hidden border-t border-charcoal-900/10 bg-ivory-50 lg:hidden" data-mobile-menu>
        <nav aria-label="Mobile" class="container-page flex flex-col gap-1 py-4">
            @foreach ($navigation as $item)
                <a
                    href="{{ $item['url'] }}"
                    class="px-3 py-3 text-base font-medium text-charcoal-900 transition-colors hover:bg-ivory-100 hover:text-burgundy-800"
                    @if ($item['active']) aria-current="page" @endif
                >
                    {{ $item['label'] }}
                </a>
            @endforeach

            <a href="{{ route('contact') }}" class="btn btn-primary mt-3">Get in touch</a>
        </nav>
    </div>
</header>
