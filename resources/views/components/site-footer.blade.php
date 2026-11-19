@php
    $socials = collect(config('cso.socials', []));
@endphp

<footer class="relative mt-24 overflow-hidden bg-ink-900 text-slate-300">
    <div class="glow top-[-8rem] left-1/2 h-72 w-[36rem] -translate-x-1/2 bg-brand-600/25"></div>

    <div class="container-page relative pt-16 pb-10">
        <div class="grid gap-12 lg:grid-cols-[1.4fr_1fr_1fr]">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3">
                    @if (filled(config('cso.org.logo')))
                        <span class="grid h-12 w-12 shrink-0 place-items-center overflow-hidden rounded-2xl bg-white ring-1 ring-white/20">
                            <img
                                src="{{ config('cso.org.logo') }}"
                                alt="{{ config('cso.org.name') }} logo"
                                class="h-full w-full object-contain p-0.5"
                            >
                        </span>
                    @else
                        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-brand-400 to-brand-700 text-white">
                            <x-icon name="cross" class="h-5 w-5" />
                        </span>
                    @endif
                    <span class="leading-tight">
                        <span class="block text-sm font-extrabold tracking-tight text-white">MUST CSO</span>
                        <span class="block text-[10px] font-bold tracking-[0.16em] text-brand-300 uppercase">Catholic Students Org.</span>
                    </span>
                </div>

                <p class="mt-5 max-w-sm text-sm leading-relaxed text-slate-400">
                    {{ config('cso.org.name') }} at the {{ config('cso.org.university') }}.
                    {{ config('cso.org.tagline') }}
                </p>

                <p class="mt-4 text-sm font-semibold text-brand-300">
                    "{{ config('cso.org.motto') }}"
                </p>

                <div class="mt-6 flex flex-wrap items-center gap-3" aria-label="Follow us online">
                    @foreach ($socials as $social)
                        @if (filled($social['url'] ?? null))
                            <a
                                href="{{ $social['url'] }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="social-brand-link"
                                aria-label="{{ $social['label'] }}"
                                title="{{ $social['label'] }}"
                            >
                                <x-social-brand-icon :name="$social['key']" class="h-5 w-5" />
                            </a>
                        @else
                            <span
                                class="social-brand-link is-unset"
                                role="img"
                                aria-label="{{ $social['label'] }}"
                                title="{{ $social['label'] }}"
                                aria-disabled="true"
                            >
                                <x-social-brand-icon :name="$social['key']" class="h-5 w-5" />
                            </span>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Explore --}}
            <div>
                <h3 class="text-xs font-bold tracking-[0.18em] text-white uppercase">Explore</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach ([
                        'Home' => 'home',
                        'About Us' => 'about',
                        'Leadership' => 'leadership',
                        'Activities' => 'activities',
                    ] as $label => $route)
                        <li><a href="{{ route($route) }}" class="link-quiet">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            {{-- Connect --}}
            <div>
                <h3 class="text-xs font-bold tracking-[0.18em] text-white uppercase">Connect</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach ([
                        'News & Events' => 'news',
                        'Gallery' => 'gallery',
                        'Daily Readings' => 'daily-readings',
                        'Prayer Intentions' => 'prayer-intentions.create',
                        'Contact Us' => 'contact',
                    ] as $label => $route)
                        <li><a href="{{ route($route) }}" class="link-quiet">{{ $label }}</a></li>
                    @endforeach
                    <li><a href="{{ route('contact') }}#join" class="link-quiet">Join CSO</a></li>
                </ul>

                <a href="mailto:{{ config('cso.contact.email') }}" class="mt-6 inline-flex items-center gap-2 rounded-2xl border border-white/10 bg-white/5 px-4 py-3 text-sm font-semibold text-white transition hover:border-brand-400/40 hover:bg-brand-500/10">
                    <x-icon name="mail" class="h-4 w-4 text-brand-300" />
                    {{ config('cso.contact.email') }}
                </a>
            </div>
        </div>

        <div class="mt-12 h-px w-full bg-white/10"></div>

        <div class="mt-6 flex flex-col items-center justify-between gap-3 text-xs text-slate-500 sm:flex-row">
            <p>&copy; {{ date('Y') }} {{ config('cso.org.name') }}. All rights reserved.</p>
            <p class="text-center sm:text-right">
                {{ config('cso.org.university_short') }} &middot; {{ config('cso.org.campus') }}
            </p>
        </div>
    </div>
</footer>
