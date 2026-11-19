@php
    $featuredActivity = $activities->firstWhere('is_featured', true) ?: $activities->first();
    $rest = $activities->reject(fn ($activity) => $featuredActivity && $activity->id === $featuredActivity->id)->values();
    $featuredTiktok = config('cso.org.featured_tiktok_url');
    $tiktokAccount = collect(config('cso.socials'))->firstWhere('key', 'tiktok')['url'] ?? null;
@endphp

<x-layouts.app title="Activities" description="The activities and ministries of the MUST Catholic Students Organization.">

    <x-page-hero
        eyebrow="Activities"
        title="How we grow together."
        description="From Holy Mass to charity outreach, every activity is a doorway into community."
        image="/images/gallery/1I83BoNPnpOozJx7-iXThQOkPn8sr4xuV.jpg"
        breadcrumbs="Activities"
    />

    @if (filled($featuredTiktok))
        <section class="container-page pt-10 sm:pt-14">
            <div class="card grid items-center gap-8 p-6 md:grid-cols-[1fr_auto] md:p-10">
                <div>
                    <p class="eyebrow">Featured from TikTok</p>
                    <h2 class="mt-3 text-2xl font-extrabold text-ink-900 sm:text-3xl">A moment from our community</h2>
                    <p class="mt-3 max-w-lg text-sm leading-relaxed text-ink-500">
                        Watch a short highlight from MUST CSO, then explore the Masses, choir practice and outreach below.
                    </p>
                    @if (filled($tiktokAccount))
                        <a href="{{ $tiktokAccount }}" target="_blank" rel="noopener noreferrer" class="btn-ghost btn-sm mt-5">
                            <x-social-brand-icon name="tiktok" class="h-4 w-4" />
                            Follow @must.cso
                        </a>
                    @endif
                </div>
                <x-embed-tiktok :url="$featuredTiktok" />
            </div>
        </section>
    @endif

    @if ($featuredActivity)
        <section class="container-page pt-10 pb-4 sm:pt-14 sm:pb-6">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-heading eyebrow="Featured activity" title="Step into the life of the CSO." />
                <a href="{{ route('gallery') }}" class="btn-ghost btn-sm">
                    See the moments
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>

            <article class="media-card group mt-6 overflow-hidden lg:grid lg:grid-cols-[1fr_1.05fr] lg:items-stretch">
                <x-media-frame
                    :image="$featuredActivity->image_url"
                    :video="$featuredActivity->video_url"
                    :poster="$featuredActivity->video_thumbnail_url"
                    :alt="$featuredActivity->title"
                    :seed="$featuredActivity->id"
                    ratio="aspect-[16/10] lg:aspect-auto lg:h-full lg:max-h-[22rem]"
                    imagePosition="center 30%"
                    label="Watch this activity"
                >
                    <div class="absolute inset-x-0 top-0 z-10 flex items-start justify-between gap-2 p-4 sm:p-5">
                        <span class="media-badge">{{ $featuredActivity->category_label }}</span>
                        <span class="media-badge media-badge-gold">
                            <x-icon name="star" class="h-3 w-3" />
                            Featured
                        </span>
                    </div>
                </x-media-frame>

                <div class="flex flex-col justify-center p-5 sm:p-7 lg:p-8">
                    <p class="eyebrow">{{ $featuredActivity->day ?: 'MUST CSO' }}</p>
                    <h2 class="mt-2 text-2xl leading-tight font-extrabold text-ink-900 sm:text-3xl">
                        {{ $featuredActivity->title }}
                    </h2>

                    @if ($featuredActivity->summary)
                        <p class="mt-3 text-sm leading-relaxed text-ink-500 sm:text-[15px]">{{ $featuredActivity->summary }}</p>
                    @endif

                    <div class="mt-4 flex flex-wrap gap-2">
                        @if ($featuredActivity->time)
                            <span class="chip"><x-icon name="clock" class="h-3.5 w-3.5" /> {{ $featuredActivity->time }}</span>
                        @endif
                        @if ($featuredActivity->venue)
                            <span class="chip"><x-icon name="map-pin" class="h-3.5 w-3.5" /> {{ $featuredActivity->venue }}</span>
                        @endif
                    </div>

                    <div class="mt-5 flex flex-wrap gap-2">
                        <a href="{{ route('activities.show', $featuredActivity) }}" class="btn-primary btn-sm sm:px-5 sm:py-3 sm:text-sm">
                            Explore this activity
                            <x-icon name="arrow-right" class="h-4 w-4" />
                        </a>
                        @if ($featuredActivity->video_url)
                            <span class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-4 py-2 text-xs font-semibold text-ink-500">
                                <x-icon name="video" class="h-4 w-4 text-brand-600" />
                                Video preview available
                            </span>
                        @endif
                    </div>
                </div>
            </article>
        </section>
    @endif

    <section class="section container-page">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading eyebrow="All activities" title="Every way to belong." />
            <div class="flex flex-wrap gap-2">
                @foreach (\App\Models\Activity::CATEGORIES as $key => $label)
                    <span class="chip">{{ $label }} <span class="font-bold text-brand-700">{{ $activities->where('category', $key)->count() }}</span></span>
                @endforeach
            </div>
        </div>

        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($rest as $activity)
                <x-activity-card :activity="$activity" :seed="$loop->iteration" />
            @empty
                <p class="col-span-full text-center text-ink-500">No activities published yet.</p>
            @endforelse
        </div>

        @if (! $rest->count() && $featuredActivity)
            <div class="mt-8">
                <x-activity-card :activity="$featuredActivity" :seed="1" />
            </div>
        @endif
    </section>

    <section class="container-page pb-16">
        <div class="rounded-3xl border border-brand-200/60 bg-gradient-to-br from-brand-50 to-white p-8 sm:p-10">
            <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="eyebrow">New members welcome</p>
                    <h2 class="mt-2 text-2xl font-extrabold text-ink-900">Come as you are — just turn up.</h2>
                    <p class="mt-2 text-sm leading-relaxed text-ink-500">
                        No registration is needed to attend Mass, devotion or the Friday meeting.
                        Introduce yourself to the secretary after any gathering to be added to the register.
                    </p>
                </div>
                <a href="{{ route('contact') }}#join" class="btn-primary">
                    How to join
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
