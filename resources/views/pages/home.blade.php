@php
    $heroSlides = [
        ['image' => '/images/hero/congregation-prayer.jpg', 'label' => 'Students gathered in prayer'],
        ['image' => '/images/hero/altar-servers-mass.jpg', 'label' => 'Priest and altar servers at Mass'],
        ['image' => '/images/hero/catholic-mass.jpg', 'label' => 'Catholic Mass with altar boys'],
        ['image' => '/images/hero/ornate-mass-altar.jpg', 'label' => 'Catholic Mass at the ornate altar'],
    ];
    $org = config('cso.org');
    $faithVideo = '/videos/catholic/altar-stained-glass.mp4';
    $faithPoster = '/images/catholic/altar-stained-glass.jpg';
@endphp

<x-layouts.app description="{{ $org['mission'] }}">

    {{-- ================= HERO (dark full-bleed, dissolving into ivory) ================= --}}
    <section class="hero-stage relative overflow-hidden bg-ink-900 text-white">
        {{-- Cinematic HD backgrounds: real people in prayer, worship and Mass --}}
        <div class="home-hero-media cinematic-media absolute inset-0" data-hero-rotator aria-hidden="true">
            @foreach ($heroSlides as $slide)
                <img
                    src="{{ $slide['image'] }}"
                    alt=""
                    class="hero-slide cinematic-poster absolute inset-0 h-full w-full object-cover @if ($loop->first) is-active @endif"
                    data-hero-slide
                    loading="eager"
                    decoding="async"
                    @if ($loop->first) fetchpriority="high" @endif
                >
            @endforeach
        </div>
        <div class="cinematic-scrim home-hero-scrim absolute inset-0 bg-gradient-to-r from-ink-950/92 via-brand-950/82 to-brand-900/55" aria-hidden="true"></div>
        <div class="cinematic-scrim home-hero-scrim absolute inset-0 bg-gradient-to-t from-ink-950/75 via-ink-900/20 to-ink-950/30" aria-hidden="true"></div>
        <div class="hero-glow hero-glow--brand absolute" aria-hidden="true"></div>
        <div class="hero-glow hero-glow--gold absolute" aria-hidden="true"></div>
        <div class="cinematic-shimmer absolute inset-0" aria-hidden="true"></div>
        <div class="cinematic-edge absolute inset-0" aria-hidden="true"></div>

        <div class="relative z-10 flex min-h-[78svh] flex-col">
            {{-- Hero content (centered) --}}
            <div class="container-page flex flex-1 flex-col items-center justify-center px-4 pt-20 pb-16 text-center sm:pt-24 sm:pb-20">
                <h1 class="max-w-4xl text-4xl leading-[1.02] font-extrabold tracking-tight text-white sm:text-5xl lg:text-[3.5rem]">
                    {{ \App\Models\SiteSetting::get('hero_title_line_1') }}
                    <br class="hidden sm:block" />
                    <span class="text-brand-400">{{ \App\Models\SiteSetting::get('hero_title_line_2') }}</span>
                </h1>

                {{-- Motto & mission highlight pill --}}
                <div class="mt-6 inline-flex flex-wrap items-center justify-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-2 text-sm backdrop-blur">
                    <x-icon name="quote" class="h-4 w-4 text-brand-400" />
                    <span class="font-semibold text-white">{{ $org['motto'] }}</span>
                    <span class="text-slate-400">&bull;</span>
                    <span class="text-slate-300">{{ $org['tagline'] }}</span>
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                    <a href="{{ route('activities') }}" class="btn-primary">
                        Explore CSO Activities
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                    <a href="{{ route('gallery') }}" class="btn-glass">
                        View Gallery
                        <span class="ml-1 grid h-7 w-7 place-items-center rounded-full bg-brand-500 text-white">
                            <x-icon name="play" class="h-3.5 w-3.5" />
                        </span>
                    </a>
                </div>
            </div>

            {{-- Bottom ticker / horizontal cards --}}
            <div class="container-page pb-5 sm:pb-6">
                <p class="mb-3 text-center text-[11px] font-bold tracking-[0.22em] text-slate-400 uppercase">
                    — WEEKLY LITURGY &amp; CSO GATHERINGS —
                </p>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                    @foreach ([
                        ['icon' => 'church', 'title' => 'Holy Mass', 'sub' => 'Sunday & weekday liturgy', 'time' => '9:00 AM (Sun) · 6:30 AM (Tue/Thu)'],
                        ['icon' => 'sunrise', 'title' => 'Morning Devotion', 'sub' => 'Daily campus prayer', 'time' => '6:00 AM (Mon–Sat)'],
                        ['icon' => 'users', 'title' => 'Friday Meetings', 'sub' => 'Weekly CSO fellowship', 'time' => '7:00 PM (Friday)'],
                        ['icon' => 'music', 'title' => 'Choir & Liturgy', 'sub' => 'Sacred music ministry', 'time' => '7:00 PM (Wed) · 9:00 AM (Sat)'],
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

        {{-- Tall, multi-layer fade: photograph → warm ivory --}}
        <div class="hero-fade" aria-hidden="true">
            <span class="hero-fade-blur"></span>
        </div>
    </section>

    {{-- ================= EVERY STUDENT / ONE COMMUNITY (floating photo composition) ================= --}}
    @php
        $communityPhotos = [
            ['id' => '12usmszhcdLinTYwV3RjQD3rObfSgeLQL', 'label' => 'Holy Mass'],
            ['id' => '1I83BoNPnpOozJx7-iXThQOkPn8sr4xuV', 'label' => 'Morning Devotion'],
            ['id' => '1WS1K0jiEOHhCE-uwy2xagCFEUzHwRVn3', 'label' => 'Friday Meetings'],
            ['id' => '1Pt2sQzEhFcWA6VP962TRptoVSN5J-qBP', 'label' => 'Choir & Liturgy'],
            ['id' => '1HwaaaeG7vkZBJTMW4tLkPRgazSqq5A3g', 'label' => 'Charity & Outreach'],
            ['id' => '1bdmVvE8P672fSMjPOwR9Uq08nZpL2B2b', 'label' => 'Bible Study'],
        ];
    @endphp

    <section class="community-section relative overflow-hidden pb-16 sm:pb-20 lg:pb-24">
        <div class="community-atmosphere pointer-events-none absolute inset-0" aria-hidden="true"></div>

        <div class="container-page relative z-10">
            <div class="relative mx-auto max-w-7xl">
                {{-- Mobile & tablet: compact floating collage --}}
                <div class="community-collage mx-auto mb-10 grid max-w-xs grid-cols-2 gap-4 px-1 sm:max-w-md sm:gap-5 lg:hidden">
                    @foreach (array_slice($communityPhotos, 0, 4) as $card)
                        <figure @class([
                            'community-photo aspect-[4/5]',
                            '-rotate-[4deg] translate-y-1' => $loop->index === 0,
                            'rotate-[4deg]' => $loop->index === 1,
                            'rotate-[3deg] -translate-y-1' => $loop->index === 2,
                            '-rotate-[5deg] translate-y-2' => $loop->index === 3,
                        ])>
                            <img src="/images/gallery/{{ $card['id'] }}.jpg" alt="{{ $card['label'] }}" loading="lazy">
                            <figcaption class="community-photo-caption">
                                <span>{{ $card['label'] }}</span>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>

                {{-- Desktop: six floating photographs framing the message --}}
                <div class="pointer-events-none absolute inset-0 hidden lg:block">
                    {{-- Upper left --}}
                    <div class="absolute top-0 left-0 w-[clamp(180px,16vw,225px)] -rotate-[7deg]">
                        <figure class="community-photo community-float aspect-[4/5]" style="animation-delay: -0.4s">
                            <img src="/images/gallery/12usmszhcdLinTYwV3RjQD3rObfSgeLQL.jpg" alt="Holy Mass" loading="lazy">
                            <figcaption class="community-photo-caption">
                                <span>Holy Mass</span>
                            </figcaption>
                        </figure>
                    </div>

                    {{-- Upper right --}}
                    <div class="absolute top-8 right-0 w-[clamp(195px,17vw,245px)] rotate-[6deg]">
                        <figure class="community-photo community-float aspect-[3/4]" style="animation-delay: -2.1s">
                            <img src="/images/gallery/1I83BoNPnpOozJx7-iXThQOkPn8sr4xuV.jpg" alt="Morning Devotion" loading="lazy">
                            <figcaption class="community-photo-caption">
                                <span>Morning Devotion</span>
                            </figcaption>
                        </figure>
                    </div>

                    {{-- Middle left --}}
                    <div class="absolute top-[36%] -left-6 w-[clamp(175px,15.5vw,215px)] rotate-[5deg]">
                        <figure class="community-photo community-float aspect-[4/5]" style="animation-delay: -3.6s">
                            <img src="/images/gallery/1WS1K0jiEOHhCE-uwy2xagCFEUzHwRVn3.jpg" alt="Friday Meetings" loading="lazy">
                            <figcaption class="community-photo-caption">
                                <span>Friday Meetings</span>
                            </figcaption>
                        </figure>
                    </div>

                    {{-- Middle right --}}
                    <div class="absolute top-[44%] -right-6 w-[clamp(185px,16.5vw,235px)] -rotate-[6deg]">
                        <figure class="community-photo community-float aspect-[5/4]" style="animation-delay: -1.2s">
                            <img src="/images/gallery/1Pt2sQzEhFcWA6VP962TRptoVSN5J-qBP.jpg" alt="Choir & Liturgy" loading="lazy">
                            <figcaption class="community-photo-caption">
                                <span>Choir &amp; Liturgy</span>
                            </figcaption>
                        </figure>
                    </div>

                    {{-- Lower left --}}
                    <div class="absolute bottom-0 left-6 w-[clamp(190px,16.5vw,235px)] rotate-[9deg]">
                        <figure class="community-photo community-float aspect-[4/5]" style="animation-delay: -4.8s">
                            <img src="/images/gallery/1HwaaaeG7vkZBJTMW4tLkPRgazSqq5A3g.jpg" alt="Charity & Outreach" loading="lazy">
                            <figcaption class="community-photo-caption">
                                <span>Charity &amp; Outreach</span>
                            </figcaption>
                        </figure>
                    </div>

                    {{-- Lower right --}}
                    <div class="absolute right-2 bottom-6 w-[clamp(175px,15.5vw,220px)] -rotate-[8deg]">
                        <figure class="community-photo community-float aspect-[4/5]" style="animation-delay: -5.7s">
                            <img src="/images/gallery/1bdmVvE8P672fSMjPOwR9Uq08nZpL2B2b.jpg" alt="Bible Study" loading="lazy">
                            <figcaption class="community-photo-caption">
                                <span>Bible Study</span>
                            </figcaption>
                        </figure>
                    </div>
                </div>

                {{-- Central message --}}
                <div class="relative z-10 mx-auto flex max-w-xl flex-col items-center px-2 pt-10 text-center sm:pt-14 lg:min-h-[900px] lg:justify-center lg:py-24">
                    <h2 class="text-4xl font-extrabold leading-[0.95] tracking-tight sm:text-6xl lg:text-7xl">
                        <span class="block text-burgundy-600">Every Student</span>
                        <span class="block text-ink-900">One</span>
                        <span class="block text-ink-900">Community</span>
                    </h2>

                    <p class="mt-6 max-w-lg text-base leading-relaxed text-ink-500 sm:text-lg">
                        {{ \App\Models\SiteSetting::get('community_description') }}
                    </p>

                    <div class="mt-8 flex flex-col items-center gap-3 sm:flex-row sm:justify-center">
                        <a href="{{ route('join') }}" class="btn-primary">
                            Join CSO
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                        <a href="{{ route('gallery') }}" class="btn-ghost">
                            View Gallery
                        </a>
                    </div>

                    @if (filled($org['hero_video']))
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
        <div class="grid gap-10 lg:grid-cols-[1.6fr_1fr]">
            <div>
                <div class="flex items-center justify-between gap-4">
                    <x-section-heading eyebrow="Save the date" title="Upcoming events" />
                    <a href="{{ route('news') }}" class="inline-flex items-center gap-1 text-sm font-bold text-brand-700 hover:text-brand-800">
                        Read All <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>

                <div @class([
                    'mt-8 grid gap-5',
                    'sm:grid-cols-2' => $events->count() > 1,
                    'lg:grid-cols-3' => $events->count() > 2,
                ])>
                    @forelse ($events as $event)
                        <x-event-card :event="$event" :seed="$loop->iteration" :wide="$events->count() === 1" />
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

                <div class="mt-8 space-y-3">
                    @forelse ($announcements as $announcement)
                        <a href="{{ route('news.show', $announcement) }}"
                           class="group flex items-center gap-3 overflow-hidden rounded-2xl bg-white p-3 ring-1 ring-slate-200/60 transition hover:ring-brand-200">
                            <span class="relative h-16 w-20 shrink-0 overflow-hidden rounded-xl bg-slate-100">
                                <img
                                    src="{{ $announcement->image_url ?: config('cso.media_fallbacks')[$loop->index % count(config('cso.media_fallbacks'))] }}"
                                    alt=""
                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                    loading="lazy"
                                >
                            </span>
                            <span class="min-w-0">
                                <span class="block text-[10px] font-bold tracking-[0.14em] text-brand-700 uppercase">{{ $announcement->category_label }}</span>
                                <span class="mt-1 block line-clamp-2 text-sm font-bold text-brand-900">{{ $announcement->title }}</span>
                                <span class="mt-1 block text-[11px] text-slate-500">{{ $announcement->published_at->format('D d, M Y') }}</span>
                            </span>
                        </a>
                    @empty
                        <p class="p-4 text-sm text-ink-500">No announcements right now.</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Featured activities share the existing events section, keeping the page layout intact. --}}
        @if ($activities->isNotEmpty())
            <div class="mt-14 border-t border-slate-200/70 pt-10">
                <div class="flex flex-wrap items-end justify-between gap-4">
                    <x-section-heading eyebrow="Life in the CSO" title="Featured activities" />
                    <a href="{{ route('activities') }}" class="inline-flex items-center gap-1 text-sm font-bold text-brand-700 hover:text-brand-800">
                        Explore all <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>

                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($activities as $activity)
                        <x-activity-card :activity="$activity" :seed="$loop->iteration" />
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    {{-- ================= FAITH & COMMUNITY HUB ================= --}}
    <section class="section container-page">
        <div class="faith-shell relative overflow-hidden rounded-[2.5rem] p-5 sm:p-8 lg:p-10">
            <div class="faith-shell-glow faith-shell-glow--gold" aria-hidden="true"></div>
            <div class="faith-shell-glow faith-shell-glow--blue" aria-hidden="true"></div>
            <div class="faith-shell-rule" aria-hidden="true"></div>

            <div class="faith-header relative flex flex-wrap items-end justify-between gap-5">
                <x-section-heading
                    eyebrow="Faith & community"
                    title="A home for your faith on campus"
                    description="Pray, belong and serve with a community that walks with you through the academic year."
                />
                <a href="{{ route('join') }}" class="btn-ghost btn-sm faith-get-involved">
                    Get involved
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>

            <div class="faith-grid relative mt-9 grid gap-5 lg:grid-cols-[1.15fr_.85fr] lg:items-stretch">
                {{-- Daily reflection (Catholic Daily Reflections) --}}
                <article class="faith-feature relative flex min-h-[32rem] flex-col overflow-hidden rounded-[1.75rem] text-white sm:p-9 lg:min-h-[36rem] lg:p-10">
                    <div class="cinematic-media absolute inset-0" aria-hidden="true">
                        <img src="{{ $faithPoster }}" alt="" class="cinematic-poster absolute inset-0 h-full w-full object-cover" fetchpriority="high" decoding="async">
                        <video
                            class="cinematic-video absolute inset-0 h-full w-full object-cover"
                            autoplay
                            muted
                            loop
                            playsinline
                            preload="metadata"
                            disablepictureinpicture
                            poster="{{ $faithPoster }}"
                            data-cinematic-video
                            tabindex="-1"
                        >
                            <source src="{{ $faithVideo }}" type="video/mp4">
                        </video>
                    </div>
                    <div class="cinematic-scrim absolute inset-0" aria-hidden="true"></div>
                    <div class="cinematic-shimmer absolute inset-0" aria-hidden="true"></div>
                    <div class="cinematic-edge absolute inset-0" aria-hidden="true"></div>

                    <div class="relative z-10 flex h-full flex-col p-6 sm:p-8 lg:p-9">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <div class="faith-kicker">
                                <span class="faith-kicker-icon">
                                    <x-icon name="book-open" class="h-4 w-4" />
                                </span>
                                <p>Verse &amp; reflection of the day</p>
                            </div>
                            <span class="faith-date">
                                {{ $reflectionToday['date_label'] ?? '' }}
                            </span>
                        </div>

                        @if (($reflectionToday['found'] ?? false) && !empty($reflectionToday['reflection']))
                            <div class="mt-9 max-w-2xl">
                                <span class="faith-title-rule" aria-hidden="true"></span>
                                <h3 class="faith-title text-3xl leading-[1.15] font-extrabold text-balance sm:text-4xl lg:text-[2.55rem]">
                                    {{ $reflectionToday['reflection']['title'] }}
                                </h3>
                                @if (!empty($reflectionToday['reflection']['liturgical_day']))
                                    <p class="faith-liturgy mt-4 text-sm font-bold tracking-wide sm:text-base">
                                        {{ $reflectionToday['reflection']['liturgical_day'] }}
                                    </p>
                                @endif
                                <p class="faith-excerpt mt-6 max-w-xl text-sm leading-[1.85] sm:text-[15px]">
                                    {{ $reflectionToday['reflection']['excerpt'] ?? 'Open today’s full daily readings and reflection.' }}
                                </p>
                                <p class="faith-source mt-7 text-xs font-semibold tracking-wide uppercase">Source: Catholic Daily Reflections</p>
                            </div>

                            <div class="faith-actions mt-auto flex flex-wrap items-center gap-3 pt-10">
                                <button
                                    type="button"
                                    class="faith-primary-button"
                                    data-reflection-open
                                    data-reflection-payload='@json($reflectionToday)'
                                >
                                    Read Full Daily Readings
                                    <x-icon name="arrow-right" class="h-4 w-4" />
                                </button>
                                <a href="{{ route('daily-readings') }}" class="faith-secondary-button">
                                    Browse dates
                                </a>
                            </div>
                        @else
                            <div class="mt-9 max-w-xl">
                                <span class="faith-title-rule" aria-hidden="true"></span>
                                <h3 class="faith-title text-3xl leading-[1.15] font-extrabold text-balance sm:text-4xl">Verse &amp; Reflection of the Day</h3>
                                <p class="faith-fallback mt-6 p-5 text-sm leading-relaxed">
                                    {{ $reflectionToday['message'] ?? "Today's reflection is not yet available. Please check back soon." }}
                                </p>
                                <p class="faith-excerpt mt-5 text-sm leading-relaxed">Please check back soon or browse previous daily reflections.</p>
                            </div>
                            <div class="faith-actions mt-auto flex flex-wrap items-center gap-3 pt-10">
                                <a href="{{ route('daily-readings') }}" class="faith-primary-button">
                                    Read Full Daily Readings
                                    <x-icon name="arrow-right" class="h-4 w-4" />
                                </a>
                                <a href="{{ route('daily-readings') }}" class="faith-secondary-button">
                                    Browse dates
                                </a>
                            </div>
                        @endif
                    </div>
                </article>

                {{-- Community actions --}}
                <div class="faith-action-grid grid auto-rows-fr gap-4">
                    <a href="{{ route('join') }}" class="faith-action-card group flex h-full items-start gap-4 p-5 lg:p-6">
                        <span class="faith-action-icon faith-action-icon--blue">
                            <x-icon name="users" class="h-5 w-5" />
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="faith-action-title block text-base font-extrabold">Join the CSO</span>
                            <span class="faith-action-copy mt-1.5 block text-sm leading-relaxed">Become part of a Catholic family that prays, serves and grows together at MUST.</span>
                        </span>
                        <x-icon name="arrow-right" class="faith-action-arrow mt-1 h-4 w-4 shrink-0" />
                    </a>

                    <a href="{{ route('prayer-intentions.create') }}" class="faith-action-card group flex h-full items-start gap-4 p-5 lg:p-6">
                        <span class="faith-action-icon faith-action-icon--gold">
                            <x-icon name="heart" class="h-5 w-5" />
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="faith-action-title block text-base font-extrabold">Prayer intentions</span>
                            <span class="faith-action-copy mt-1.5 block text-sm leading-relaxed">Send an anonymous prayer request to be remembered at Mass and in the community’s prayers.</span>
                        </span>
                        <x-icon name="arrow-right" class="faith-action-arrow mt-1 h-4 w-4 shrink-0" />
                    </a>

                    <a href="{{ route('activities') }}" class="faith-action-card group flex h-full items-start gap-4 p-5 lg:p-6">
                        <span class="faith-action-icon faith-action-icon--emerald">
                            <x-icon name="music" class="h-5 w-5" />
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="faith-action-title block text-base font-extrabold">Ministries &amp; Choir</span>
                            <span class="faith-action-copy mt-1.5 block text-sm leading-relaxed">Choir, liturgical readers, charity outreach and small Christian communities.</span>
                        </span>
                        <x-icon name="arrow-right" class="faith-action-arrow mt-1 h-4 w-4 shrink-0" />
                    </a>
                </div>
            </div>

            <p class="faith-footnote relative mt-5 text-xs">
                Looking for reports and M’Phakati lists?
                <a href="{{ route('leadership') }}" class="faith-footnote-link">M’Phakati member lists &rarr;</a>
            </p>
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
