@php
    $socials = collect(config('cso.socials'))->filter(fn ($s) => filled($s['url']));
    $folders = collect(config('cso.drive.folders'));
@endphp

<footer class="relative mt-24 overflow-hidden bg-ink-900 text-slate-300">
    <div class="glow top-[-8rem] left-1/2 h-72 w-[36rem] -translate-x-1/2 bg-brand-600/25"></div>

    <div class="container-page relative pt-16 pb-10">
        <div class="grid gap-12 lg:grid-cols-[1.4fr_1fr_1fr_1.2fr]">
            {{-- Brand --}}
            <div>
                <div class="flex items-center gap-3">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-brand-400 to-brand-700 text-white">
                        <x-icon name="cross" class="h-5 w-5" />
                    </span>
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
                    “{{ config('cso.org.motto') }}”
                </p>

                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($socials as $social)
                        <a
                            href="{{ $social['url'] }}"
                            target="_blank"
                            rel="noopener"
                            class="grid h-10 w-10 place-items-center rounded-xl border border-white/10 bg-white/5 text-slate-300 transition hover:border-brand-400/50 hover:bg-brand-500/10 hover:text-brand-300"
                            aria-label="{{ $social['label'] }}"
                        >
                            <x-icon :name="$social['icon']" class="h-4 w-4" />
                        </a>
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
                        'Contact Us' => 'contact',
                    ] as $label => $route)
                        <li><a href="{{ route($route) }}" class="link-quiet">{{ $label }}</a></li>
                    @endforeach
                    <li><a href="{{ route('contact') }}#join" class="link-quiet">Join CSO</a></li>
                </ul>
            </div>

            {{-- Drive resources --}}
            <div>
                <h3 class="text-xs font-bold tracking-[0.18em] text-white uppercase">Drive Resources</h3>
                <ul class="mt-5 space-y-3 text-sm">
                    @foreach ($folders as $folder)
                        <li>
                            @if ($folder['url'])
                                <a href="{{ $folder['url'] }}" target="_blank" rel="noopener" class="group inline-flex items-start gap-2 text-slate-400 transition hover:text-brand-300">
                                    <x-icon :name="$folder['icon']" class="mt-0.5 h-4 w-4 shrink-0" />
                                    <span>{{ $folder['title'] }}</span>
                                    <x-icon name="arrow-up-right" class="mt-0.5 h-3 w-3 shrink-0 opacity-0 transition group-hover:opacity-100" />
                                </a>
                            @else
                                <span class="inline-flex items-start gap-2 text-slate-600">
                                    <x-icon :name="$folder['icon']" class="mt-0.5 h-4 w-4 shrink-0" />
                                    <span>{{ $folder['title'] }} <span class="text-[11px]">(soon)</span></span>
                                </span>
                            @endif
                        </li>
                    @endforeach
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
