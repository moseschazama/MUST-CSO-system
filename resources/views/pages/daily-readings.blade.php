<x-layouts.app title="Daily Readings & Reflection" description="Daily Catholic readings and reflection shared by the MUST Catholic Students Organization.">

    @php
        $heroVideo = '/videos/catholic/bible-candle.mp4';
        $heroPoster = '/images/catholic/bible-candle.jpg';
        $featureVideo = '/videos/catholic/catholic-altar.mp4';
        $featurePoster = '/images/catholic/catholic-altar.jpg';

        $practices = [
            [
                'image' => '/images/catholic/rosary-bible.jpg',
                'icon' => 'book-open',
                'title' => 'Read the Word',
                'copy' => 'Open the daily readings and sit with the Gospel for a few minutes before the day begins.',
            ],
            [
                'image' => '/images/catholic/crucifix.jpg',
                'icon' => 'heart',
                'title' => 'Pray it',
                'copy' => 'Name one person, one worry and one gift. Offer each of them to God in today’s prayer.',
            ],
            [
                'image' => '/images/catholic/sunlit-altar.jpg',
                'icon' => 'users',
                'title' => 'Live it',
                'copy' => 'Choose one small act of service or kindness that makes today’s Word visible to someone else.',
            ],
        ];
    @endphp

    <section class="daily-hero relative isolate flex min-h-[420px] w-full items-center overflow-hidden bg-ink-950 sm:min-h-[470px] lg:min-h-[520px]">
        <div class="cinematic-media absolute inset-0" aria-hidden="true">
            <img src="{{ $heroPoster }}" alt="" class="cinematic-poster absolute inset-0 h-full w-full object-cover" fetchpriority="high" decoding="async">
            <video
                class="cinematic-video absolute inset-0 h-full w-full object-cover"
                autoplay
                muted
                loop
                playsinline
                preload="metadata"
                disablepictureinpicture
                poster="{{ $heroPoster }}"
                data-cinematic-video
                tabindex="-1"
            >
                <source src="{{ $heroVideo }}" type="video/mp4">
            </video>
        </div>
        <div class="cinematic-scrim daily-hero-scrim absolute inset-0" aria-hidden="true"></div>
        <div class="cinematic-shimmer absolute inset-0" aria-hidden="true"></div>
        <div class="cinematic-edge absolute inset-0" aria-hidden="true"></div>

        <div class="container-page relative z-10 w-full pt-32 pb-14 sm:pt-36 sm:pb-16 lg:pt-40 lg:pb-20">
            <div class="max-w-4xl">
                <nav aria-label="Breadcrumb" class="mb-6">
                    <ol class="daily-crumbs flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-bold tracking-[0.16em] uppercase">
                        <li><a href="{{ route('home') }}" class="transition hover:text-white">Home</a></li>
                        <li aria-hidden="true" class="text-white/30">
                            <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                        </li>
                        <li class="min-w-0">
                            <span class="text-white/95" aria-current="page">Daily readings</span>
                        </li>
                    </ol>
                </nav>

                <span class="daily-hero-eyebrow">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                    Daily readings
                </span>

                <h1 class="daily-hero-title mt-5 max-w-3xl text-4xl leading-[1.05] font-extrabold text-balance sm:text-5xl lg:text-[3.5rem]">
                    A word for today.
                </h1>

                <p class="daily-hero-copy mt-5 max-w-2xl text-base leading-relaxed sm:text-lg">
                    Pause with the day's readings and reflection, then carry the Word into your lectures, hostels and friendships.
                </p>
            </div>
        </div>
    </section>

    <section class="section container-page">
        <div class="daily-layout grid gap-8 lg:grid-cols-[1.45fr_.85fr] lg:items-start">
            <div class="space-y-6">
                <article class="daily-feature overflow-hidden rounded-[2rem] border border-gold-200/60 bg-white shadow-[0_28px_70px_-40px_rgba(5,13,29,.65)]">
                    @if ($reflection['found'] && !empty($reflection['reflection']))
                        @php($item = $reflection['reflection'])
                        <div class="relative aspect-[16/8] bg-ink-950 sm:aspect-[16/7]">
                            <div class="cinematic-media absolute inset-0" aria-hidden="true">
                                <img src="{{ $featurePoster }}" alt="" class="cinematic-poster absolute inset-0 h-full w-full object-cover" loading="lazy" decoding="async">
                                <video
                                    class="cinematic-video absolute inset-0 h-full w-full object-cover"
                                    autoplay
                                    muted
                                    loop
                                    playsinline
                                    preload="metadata"
                                    disablepictureinpicture
                                    poster="{{ $featurePoster }}"
                                    data-cinematic-video
                                    tabindex="-1"
                                >
                                    <source src="{{ $featureVideo }}" type="video/mp4">
                                </video>
                            </div>
                            <div class="cinematic-scrim daily-feature-scrim absolute inset-0" aria-hidden="true"></div>
                            <div class="cinematic-shimmer absolute inset-0" aria-hidden="true"></div>
                            <div class="cinematic-edge absolute inset-0" aria-hidden="true"></div>
                            <div class="relative z-10 flex h-full items-end p-6 sm:p-8">
                                <span class="daily-feature-symbol">
                                    <x-icon name="book-open" class="h-6 w-6" />
                                </span>
                            </div>
                        </div>

                        <div class="daily-feature-body p-6 sm:p-8">
                            <p class="daily-feature-label">Verse &amp; reflection of the day</p>
                            <p class="daily-feature-date mt-2 text-sm font-bold">{{ $reflection['date_label'] }}</p>

                            <h2 class="daily-feature-title mt-4 text-2xl font-extrabold leading-snug sm:text-3xl">{{ $item['title'] }}</h2>
                            @if (!empty($item['liturgical_day']))
                                <p class="daily-feature-liturgy mt-3 text-sm font-bold sm:text-base">{{ $item['liturgical_day'] }}</p>
                            @endif
                            <p class="daily-feature-excerpt mt-4 text-sm leading-relaxed sm:text-[15px]">{{ $item['excerpt'] ?? '' }}</p>

                            <div class="mt-7 flex flex-wrap items-center gap-3">
                                <button
                                    type="button"
                                    class="daily-primary-button"
                                    data-reflection-open
                                    data-reflection-payload='@json($reflection)'
                                >
                                    <x-icon name="book-open" class="h-4 w-4" />
                                    Read full daily readings
                                </button>
                                <a href="{{ $item['url'] ?? 'https://catholic-daily-reflections.com/' }}" target="_blank" rel="noopener" class="daily-source-button btn-sm">
                                    View source
                                    <x-icon name="external-link" class="h-4 w-4" />
                                </a>
                            </div>
                            <p class="daily-source mt-4 text-xs">Source: <a href="https://catholic-daily-reflections.com/" target="_blank" rel="noopener" class="font-semibold">Catholic Daily Reflections</a></p>
                        </div>
                    @else
                        <div class="relative aspect-[16/7] bg-ink-950">
                            <img src="{{ $heroPoster }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                            <div class="cinematic-scrim daily-feature-scrim absolute inset-0" aria-hidden="true"></div>
                            <div class="relative z-10 grid h-full place-items-center p-8 text-center">
                                <div>
                                    <span class="daily-fallback-icon">
                                        <x-icon name="sunrise" class="h-7 w-7" />
                                    </span>
                                    <p class="mt-4 text-sm font-semibold text-white/85">{{ $reflection['message'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="daily-feature-body p-6 sm:p-8">
                            <p class="daily-feature-label">Verse &amp; reflection of the day</p>
                            <p class="daily-feature-date mt-2 text-sm font-bold">{{ $reflection['date_label'] }}</p>
                            <div class="daily-fallback-panel mt-5 p-5">
                                <p class="text-sm font-bold text-ink-900">{{ $reflection['message'] }}</p>
                                <p class="mt-2 text-sm leading-relaxed text-ink-600">Please check back soon, or browse previous daily reflections below.</p>
                                <a href="https://catholic-daily-reflections.com/" target="_blank" rel="noopener" class="daily-source-link mt-4 inline-flex items-center gap-2 text-sm font-bold">
                                    Visit Catholic Daily Reflections
                                    <x-icon name="arrow-right" class="h-4 w-4" />
                                </a>
                            </div>
                        </div>
                    @endif
                </article>

                <div class="grid gap-4 md:grid-cols-3">
                    @foreach ($practices as $practice)
                        <article class="daily-practice-card">
                            <div class="daily-practice-image">
                                <img src="{{ $practice['image'] }}" alt="" loading="lazy" decoding="async">
                                <div class="daily-practice-shade" aria-hidden="true"></div>
                                <span class="daily-practice-icon">
                                    <x-icon :name="$practice['icon']" class="h-5 w-5" />
                                </span>
                            </div>
                            <div class="p-6">
                                <h2 class="daily-practice-title text-lg font-extrabold">{{ $practice['title'] }}</h2>
                                <p class="daily-practice-copy mt-2 text-sm leading-relaxed">{{ $practice['copy'] }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <aside class="space-y-4 lg:sticky lg:top-24">
                <div class="daily-side-card p-5 sm:p-6">
                    <p class="daily-side-eyebrow">Browse by date</p>
                    <form method="GET" action="{{ route('daily-readings') }}" class="mt-4 flex flex-col gap-3 sm:flex-row lg:flex-col">
                        <label class="sr-only" for="reflection-date">Select date</label>
                        <input id="reflection-date" type="date" name="date" value="{{ $reflection['date'] }}" max="{{ $todayDate }}" class="field-input" required>
                        <button type="submit" class="daily-primary-button daily-primary-button--compact justify-center">View reflection</button>
                    </form>
                    <p class="daily-side-hint mt-3 text-xs leading-relaxed">Each date shows the daily reflection sourced from Catholic Daily Reflections when available.</p>
                </div>

                <div class="daily-side-card p-5 sm:p-6">
                    <p class="daily-side-eyebrow">Recent reflections</p>
                    <div class="mt-4 space-y-2">
                        <a href="{{ route('daily-readings', ['date' => $todayDate]) }}" @class([
                            'daily-date-link flex items-center justify-between gap-3 rounded-xl border px-3 py-3 text-sm transition',
                            'daily-date-link--active' => $reflection['date'] === $todayDate,
                        ])>
                            <span class="min-w-0">
                                <span class="block font-bold">Today</span>
                                <span class="daily-date-sub block truncate text-xs">{{ \Carbon\Carbon::parse($todayDate, 'Africa/Blantyre')->format('D, j M Y') }}</span>
                            </span>
                            <x-icon name="chevron-right" class="h-4 w-4 shrink-0" />
                        </a>
                        @foreach ($reflectionHistory as $item)
                            <a href="{{ route('daily-readings', ['date' => $item['date']]) }}" @class([
                                'daily-date-link flex items-center justify-between gap-3 rounded-xl border px-3 py-3 text-sm transition',
                                'daily-date-link--active' => $reflection['date'] === $item['date'],
                            ])>
                                <span class="min-w-0">
                                    <span class="block font-bold">{{ \Carbon\Carbon::parse($item['date'], 'Africa/Blantyre')->format('D, j M Y') }}</span>
                                    <span @class([
                                        'daily-date-sub block truncate text-xs',
                                        'daily-date-sub--found' => $item['found'],
                                    ])>{{ $item['found'] ? ($item['reflection']['title'] ?? 'Daily reflection') : 'Not yet available' }}</span>
                                </span>
                                <x-icon name="chevron-right" class="h-4 w-4 shrink-0" />
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="daily-prayer-card p-6">
                    <div class="daily-prayer-glow" aria-hidden="true"></div>
                    <p class="daily-prayer-title text-sm font-extrabold">Need prayer?</p>
                    <p class="daily-prayer-copy mt-1 text-sm">Send an anonymous intention for Mass.</p>
                    <a href="{{ route('prayer-intentions.create') }}" class="daily-prayer-button mt-4 inline-flex w-full items-center justify-center gap-2">
                        <x-icon name="heart" class="h-4 w-4" />
                        Prayer intentions
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
