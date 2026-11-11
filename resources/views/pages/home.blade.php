@php
    $heroPhoto = '10YvZrv8fIpp3UXPudDo4tuAo_B9z6_OZ';
    $org = config('cso.org');
@endphp

<x-layouts.app description="{{ $org['mission'] }}" transparentHeader>

    {{-- ================= HERO (YonsePay-style dark full-bleed) ================= --}}
    <section class="relative min-h-[100svh] overflow-hidden bg-ink-900 text-white">
        {{-- Background photo --}}
        <img
            src="/images/gallery/17rtTWn0HMsfeOBuUTX0v2HmNkNdm3CwH.jpg"
            alt="MUST CSO members gathered in prayer and fellowship"
            class="absolute inset-0 h-full w-full object-cover"
            fetchpriority="high"
        >
        {{-- Dark gradient vignette overlay (exact match to screenshot) --}}
        <div class="absolute inset-0 bg-gradient-to-b from-ink-900/85 via-ink-900/65 to-ink-900/95"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(59,130,246,0.18),transparent_55%)]"></div>

        <div class="relative z-10 flex min-h-[100svh] flex-col">
            {{-- Hero content (centered) --}}
            <div class="container-page flex flex-1 flex-col items-center justify-center px-4 pt-32 pb-44 text-center sm:pt-36">
                <span class="pill-on-dark">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-400"></span>
                    MALAWI UNIVERSITY OF SCIENCE AND TECHNOLOGY &bull; CATHOLIC STUDENTS
                </span>

                <h1 class="mt-6 max-w-4xl text-4xl leading-[1.02] font-extrabold tracking-tight text-white sm:text-5xl lg:text-[4.25rem]">
                    Faith, Fellowship &amp; Service
                    <br class="hidden sm:block" />
                    <span class="text-brand-400">for MUST Catholic Students</span>
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-relaxed text-slate-200 sm:text-lg">
                    Welcome to the MUST Catholic Students Organization. Growing together in Christ through
                    Holy Mass, morning devotion, leadership, and campus charity.
                </p>

                {{-- Motto & mission highlight pill --}}
                <div class="mt-6 inline-flex flex-wrap items-center justify-center gap-2 rounded-full border border-white/15 bg-white/5 px-5 py-2.5 text-sm backdrop-blur">
                    <x-icon name="quote" class="h-4 w-4 text-brand-400" />
                    <span class="font-semibold text-white">{{ $org['motto'] }}</span>
                    <span class="text-slate-400">&bull;</span>
                    <span class="text-slate-300">{{ $org['tagline'] }}</span>
                </div>

                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('activities') }}" class="btn-primary">
                        Explore CSO Activities
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                    <a href="{{ route('gallery') }}" class="btn-glass">
                        View Gallery &amp; Drive
                        <span class="ml-1 grid h-7 w-7 place-items-center rounded-full bg-brand-500 text-white">
                            <x-icon name="play" class="h-3.5 w-3.5" />
                        </span>
                    </a>
                </div>
            </div>

            {{-- Bottom ticker / horizontal cards --}}
            <div class="container-page pb-8 sm:pb-10">
                <p class="mb-4 text-center text-[11px] font-bold tracking-[0.22em] text-slate-400 uppercase">
                    — WEEKLY LITURGY &amp; CSO GATHERINGS —
                </p>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-5">
                    @foreach ([
                        ['icon' => 'church', 'title' => 'Holy Mass', 'sub' => 'Sunday & weekday liturgy', 'time' => '9:00 AM (Sun) · 6:30 AM (Tue/Thu)'],
                        ['icon' => 'sunrise', 'title' => 'Morning Devotion', 'sub' => 'Daily campus prayer', 'time' => '6:00 AM (Mon–Sat)'],
                        ['icon' => 'users', 'title' => 'Friday Meetings', 'sub' => 'Weekly CSO fellowship', 'time' => '7:00 PM (Friday)'],
                        ['icon' => 'music', 'title' => 'Choir & Liturgy', 'sub' => 'Sacred music ministry', 'time' => '7:00 PM (Wed) · 9:00 AM (Sat)'],
                        ['icon' => 'heart-handshake', 'title' => 'Charity & Outreach', 'sub' => 'Community service', 'time' => 'Weekends'],
                    ] as $card)
                        <div class="hero-card">
                            <span class="grid h-9 w-9 place-items-center rounded-xl bg-brand-500/20 text-brand-300 ring-1 ring-brand-400/30">
                                <x-icon :name="$card['icon']" class="h-5 w-5" />
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-extrabold text-white">{{ $card['title'] }}</p>
                                <p class="mt-0.5 text-[10px] font-bold tracking-wide text-slate-400 uppercase">{{ $card['sub'] }}</p>
                                <p class="mt-0.5 text-[10px] font-semibold text-brand-300">{{ $card['time'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ================= EVERY GATHERING / ONE COMMUNITY (YonsePay-style) ================= --}}
    <section class="relative overflow-hidden bg-ink-900 py-20 text-white sm:py-28">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_50%_0%,rgba(59,130,246,0.12),transparent_60%)]"></div>

        {{-- Mobile: compact photo grid --}}
        <div class="container-page relative z-10 mb-10 grid grid-cols-3 gap-3 lg:hidden">
            @foreach ([
                ['id' => '12usmszhcdLinTYwV3RjQD3rObfSgeLQL', 'label' => 'Holy Mass'],
                ['id' => '1I83BoNPnpOozJx7-iXThQOkPn8sr4xuV', 'label' => 'Morning Devotion'],
                ['id' => '1WS1K0jiEOHhCE-uwy2xagCFEUzHwRVn3', 'label' => 'Friday Meetings'],
                ['id' => '1Pt2sQzEhFcWA6VP962TRptoVSN5J-qBP', 'label' => 'Choir & Liturgy'],
                ['id' => '1HwaaaeG7vkZBJTMW4tLkPRgazSqq5A3g', 'label' => 'Charity & Outreach'],
                ['id' => '1bdmVvE8P672fSMjPOwR9Uq08nZpL2B2b', 'label' => 'Bible Study'],
            ] as $card)
                <div class="ec-float overflow-hidden rounded-2xl border-2 border-white/20 bg-white/5" style="animation-delay: -{{ $loop->index * 0.7 }}s">
                    <img src="/images/gallery/{{ $card['id'] }}.jpg" alt="{{ $card['label'] }}" class="aspect-[3/4] w-full object-cover" loading="lazy">
                </div>
            @endforeach
        </div>

        <div class="container-page relative">
            <div class="relative mx-auto min-h-[640px] max-w-6xl">
                {{-- Tilted photo cards (desktop) --}}
                <div class="pointer-events-none absolute inset-0 hidden lg:block">
                    @php
                        $tilted = [
                            ['id' => '12usmszhcdLinTYwV3RjQD3rObfSgeLQL', 'label' => 'Holy Mass', 'class' => '-rotate-12 top-0 left-0'],
                            ['id' => '1I83BoNPnpOozJx7-iXThQOkPn8sr4xuV', 'label' => 'Morning Devotion', 'class' => 'rotate-6 top-4 right-4'],
                            ['id' => '1WS1K0jiEOHhCE-uwy2xagCFEUzHwRVn3', 'label' => 'Friday Meetings', 'class' => '-rotate-6 top-1/2 left-2 -translate-y-1/2'],
                            ['id' => '1Pt2sQzEhFcWA6VP962TRptoVSN5J-qBP', 'label' => 'Choir & Liturgy', 'class' => 'rotate-6 top-1/2 right-2 -translate-y-1/2'],
                            ['id' => '1HwaaaeG7vkZBJTMW4tLkPRgazSqq5A3g', 'label' => 'Charity & Outreach', 'class' => 'rotate-12 bottom-0 left-10'],
                            ['id' => '1bdmVvE8P672fSMjPOwR9Uq08nZpL2B2b', 'label' => 'Bible Study', 'class' => '-rotate-6 bottom-4 right-10'],
                        ];
                    @endphp
                    @foreach ($tilted as $card)
                        <div class="absolute w-44 {{ $card['class'] }}">
                            <div class="ec-float overflow-hidden rounded-2xl border-2 border-white/25 bg-white/5 shadow-2xl shadow-black/60 transition hover:scale-105" style="animation-delay: -{{ $loop->index * 0.9 }}s">
                                <img src="/images/gallery/{{ $card['id'] }}.jpg" alt="{{ $card['label'] }}" class="aspect-[3/4] w-full object-cover" loading="lazy">
                                <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/80 to-transparent p-3">
                                    <p class="text-xs font-extrabold text-white">{{ $card['label'] }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Central text --}}
                <div class="relative z-10 flex min-h-[640px] flex-col items-center justify-center text-center">
                    <h2 class="text-5xl font-extrabold leading-[0.95] tracking-tight sm:text-6xl lg:text-7xl">
                        <span class="block text-brand-400">Every Student</span>
                        <span class="block text-white">One</span>
                        <span class="block text-white">Community</span>
                    </h2>

                    <p class="mt-6 max-w-xl text-base leading-relaxed text-slate-300 sm:text-lg">
                        No more searching for where to belong. MUST CSO unites Catholic students into one
                        seamless family — worship, fellowship and service, all in one place, giving you the
                        community and support you need to thrive on campus.
                    </p>                    <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                        <a href="{{ route('contact') }}#join" class="btn-primary">
                            Join CSO
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                        <a href="{{ route('gallery') }}" class="btn-glass">
                            View Gallery
                        </a>
                    </div>                    @if (filled($org['hero_video']))
                        <div class="mt-8 flex justify-center">
                            <x-embed-video
                                src="{{ $org['hero_video'] }}"
                                poster="/images/gallery/17rtTWn0HMsfeOBuUTX0v2HmNkNdm3CwH.jpg"
                            />
                        </div>
                    @endif

            </div>

            </div>
        </div>
    </section>

    {{-- ================= MOTTO & MISSION ================= --}}
    <section class="container-page">
        <div class="grid gap-4 md:grid-cols-2">
            <div class="relative overflow-hidden rounded-3xl bg-ink-900 p-8 text-white">
                <div class="glow top-[-4rem] right-[-3rem] h-48 w-48 bg-brand-500/30"></div>
                <x-icon name="quote" class="h-7 w-7 text-brand-300" />
                <p class="mt-4 text-[10px] font-bold tracking-[0.2em] text-brand-300 uppercase">Our motto</p>
                <p class="mt-2 text-2xl leading-snug font-extrabold text-balance">“{{ $org['motto'] }}”</p>
                <p class="mt-4 text-sm text-slate-300">{{ $org['tagline'] }}</p>
            </div>

            <div class="card flex flex-col justify-between p-8">
                <div>
                    <p class="eyebrow">Our mission</p>
                    <p class="mt-3 text-lg leading-relaxed font-medium text-ink-700">{{ $org['mission'] }}</p>
                </div>
                <a href="{{ route('about') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-brand-700 hover:text-brand-800">
                    More about MUST CSO
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
        </div>
    </section>

    {{-- ================= CSO AT A GLANCE ================= --}}
    <section class="relative overflow-hidden py-16 text-white sm:py-20">
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-900 via-brand-900 to-blue-900"></div>
        <div class="absolute inset-0 bg-black/20"></div>

        <div class="container-page relative grid gap-10 lg:grid-cols-2 lg:items-center">
            <div>
                <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">CSO at a Glance</h2>
                <p class="mt-4 max-w-xl text-base leading-relaxed text-white/85">
                    MUST CSO unites Catholic students across campus through M'Phakatis (small Christian groups),
                    affiliations like the choir and CCJI, and a growing family of students walking together in faith,
                    fellowship and service.
                </p>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-6 lg:divide-x lg:divide-white/20">
                @foreach (config('cso.glance') as $stat)
                    <div class="flex min-w-[90px] flex-col items-center gap-2 text-center">
                        <span class="grid h-12 w-12 place-items-center rounded-2xl bg-white/10 ring-1 ring-white/20">
                            <x-icon :name="$stat['icon']" class="h-6 w-6 text-white" />
                        </span>
                        <span class="text-3xl font-extrabold leading-none">{{ $stat['value'] }}</span>
                        <span class="text-[10px] font-bold tracking-[0.18em] text-white/70 uppercase">{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= EVENTS & NOTICES ================= --}}
    <section class="section container-page bg-slate-50/60 py-16 sm:rounded-[2.5rem]">
        @php
            $eventImages = ['10YvZrv8fIpp3UXPudDo4tuAo_B9z6_OZ', '1cZpO3y2_w0rt0QekenHkzvMzf4K5XFu6', '1oedIYxnEIYKQZX_SaZS19RYmnrty67V4'];
        @endphp

        <div class="grid gap-10 lg:grid-cols-[1.6fr_1fr]">
            <div>
                <div class="flex items-center justify-between gap-4">
                    <x-section-heading eyebrow="Save the date" title="Upcoming events" />
                    <a href="{{ route('news') }}" class="inline-flex items-center gap-1 text-sm font-bold text-brand-700 hover:text-brand-800">
                        Read All <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>

                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($events as $event)
                        <article class="overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-slate-200/60">
                            <img
                                src="/images/gallery/{{ $eventImages[$loop->index % count($eventImages)] }}.jpg"
                                alt="{{ $event->title }}"
                                class="aspect-[4/3] w-full object-cover"
                                loading="lazy"
                            >
                            <div class="p-4">
                                <p class="text-xs text-slate-500">{{ $event->starts_at->format('d, M Y') }} / EVENT</p>
                                <h3 class="mt-1 text-base font-extrabold leading-snug text-brand-900">{{ $event->title }}</h3>
                                @if ($event->venue)
                                    <p class="mt-2 flex items-center gap-1 text-xs text-slate-500">
                                        <x-icon name="map-pin" class="h-3 w-3" />
                                        {{ $event->venue }}
                                    </p>
                                @endif
                                <p class="mt-1 flex items-center gap-1 text-xs text-slate-500">
                                    <x-icon name="clock" class="h-3 w-3" />
                                    {{ $event->time }}
                                </p>
                            </div>
                        </article>
                    @empty
                        <p class="text-sm text-ink-500">No events have been announced yet — check back soon.</p>
                    @endforelse
                </div>
            </div>

            <div>
                <div class="flex items-center justify-between gap-4">
                    <x-section-heading eyebrow="Notice board" title="Announcements" />
                    <a href="{{ route('news') }}" class="inline-flex items-center gap-1 text-sm font-bold text-brand-700 hover:text-brand-800">
                        Read All <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>

                <div class="mt-8 divide-y divide-slate-200 overflow-hidden rounded-2xl bg-slate-100/70 ring-1 ring-slate-200/60">
                    @forelse ($announcements as $announcement)
                        <div class="flex items-start gap-3 p-4">
                            <span class="mt-0.5 grid h-8 w-8 shrink-0 place-items-center rounded-full border border-brand-200 bg-white text-brand-700">
                                <x-icon name="message-circle" class="h-4 w-4" />
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-bold text-brand-900">{{ $announcement->title }}</p>
                                <p class="mt-0.5 text-xs text-slate-500">{{ $announcement->published_at->format('D d, M Y') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="p-4 text-sm text-ink-500">No announcements right now.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ================= GALLERY PREVIEW ================= --}}
    <section class="section container-page">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading eyebrow="Gallery" title="Moments from our community" />
            <a href="{{ route('gallery') }}" class="btn-ghost btn-sm">
                Open gallery
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        <div class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($highlights as $photo)
                <button
                    type="button"
                    data-lightbox="{{ $photo->full_image }}"
                    data-title="{{ $photo->title }}"
                    data-alt="{{ $photo->alt }}"
                    data-drive="{{ $photo->drive_url }}"
                    class="group relative aspect-square overflow-hidden rounded-2xl bg-slate-100"
                >
                    <img
                        src="{{ $photo->thumbnail }}"
                        alt="{{ $photo->alt }}"
                        loading="lazy"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                    >
                    <span class="absolute inset-0 bg-ink-900/0 transition group-hover:bg-ink-900/20"></span>
                </button>
            @endforeach
        </div>
    </section>

    {{-- ================= LEADERSHIP TEASER ================= --}}
    <section class="section container-page">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading eyebrow="Leadership" title="The students serving you" />
            <a href="{{ route('leadership') }}" class="btn-ghost btn-sm">
                Meet the team
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($members as $member)
                <x-leader-card :leader="$member" />
            @endforeach
        </div>
    </section>
</x-layouts.app>
