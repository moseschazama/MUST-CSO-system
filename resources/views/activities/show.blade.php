<x-layouts.app title="{{ $activity->title }}" description="{{ $activity->summary }}">

    <section class="relative isolate flex min-h-[380px] items-end overflow-hidden bg-brand-950 sm:min-h-[430px] lg:min-h-[500px]">
        <img src="{{ $activity->image_url ?: config('cso.media_fallbacks')[0] }}" alt="{{ $activity->title }}" class="absolute inset-0 -z-20 h-full w-full object-cover" style="object-position: center 22%;">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950/92 via-brand-950/82 to-brand-900/55"></div>
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950/75 via-ink-900/20 to-ink-950/30"></div>
        <div class="pointer-events-none absolute -right-20 -top-20 -z-10 h-72 w-72 rounded-full bg-brand-400/20 blur-3xl"></div>
        <div class="container-page relative w-full pt-28 pb-14 sm:pt-32 sm:pb-16 lg:pt-36 lg:pb-20">
            <div class="max-w-4xl">
                <nav aria-label="Breadcrumb" class="mb-6">
                    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-bold tracking-[0.16em] text-white/65 uppercase">
                        <li><a href="{{ route('home') }}" class="transition hover:text-white">Home</a></li>
                        <li aria-hidden="true" class="text-white/30"><x-icon name="chevron-right" class="h-3.5 w-3.5" /></li>
                        <li><a href="{{ route('activities') }}" class="transition hover:text-white">Activities</a></li>
                        <li aria-hidden="true" class="text-white/30"><x-icon name="chevron-right" class="h-3.5 w-3.5" /></li>
                        <li class="min-w-0 text-white/95" aria-current="page">{{ $activity->title }}</li>
                    </ol>
                </nav>
                <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-1.5 text-[10px] font-bold tracking-[0.2em] text-white/90 uppercase backdrop-blur-sm">
                    <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                    {{ $activity->category_label }}
                </span>
                <h1 class="mt-5 max-w-3xl text-4xl leading-[1.05] font-extrabold text-balance text-white sm:text-5xl lg:text-[3.25rem]">{{ $activity->title }}</h1>
                @if ($activity->summary)<p class="mt-5 max-w-2xl text-base leading-relaxed text-white/80 sm:text-lg">{{ $activity->summary }}</p>@endif
                <div class="mt-6 flex flex-wrap gap-x-5 gap-y-2 text-sm text-white/85">
                    @if ($activity->day)<span class="inline-flex items-center gap-2"><x-icon name="calendar" class="h-4 w-4 text-gold-300" /> {{ $activity->day }}</span>@endif
                    @if ($activity->time)<span class="inline-flex items-center gap-2"><x-icon name="clock" class="h-4 w-4 text-gold-300" /> {{ $activity->time }}</span>@endif
                    @if ($activity->venue)<span class="inline-flex items-center gap-2"><x-icon name="map-pin" class="h-4 w-4 text-gold-300" /> {{ $activity->venue }}</span>@endif
                </div>
            </div>
        </div>
    </section>

    <section class="section container-page">
        <div class="grid gap-10 lg:grid-cols-[1.5fr_1fr]">
            <div class="prose max-w-none text-ink-700">
                @if ($activity->video_url)
                    <div class="not-prose mb-8 overflow-hidden rounded-3xl border border-slate-200/70 shadow-sm">
                        <x-media-frame
                            :image="$activity->image_url"
                            :video="$activity->video_url"
                            :poster="$activity->video_thumbnail_url"
                            :alt="$activity->title"
                            :seed="$activity->id"
                            ratio="aspect-video"
                            label="Watch this activity"
                        />
                    </div>
                @endif

                @if ($activity->description)
                    <div class="text-[15px] leading-relaxed space-y-4">
                        {!! nl2br(e($activity->description)) !!}
                    </div>
                @endif

                @if ($photos->isNotEmpty())
                    <h2 class="mt-10 text-2xl font-extrabold text-ink-900">From the album</h2>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($photos as $photo)
                            <figure class="overflow-hidden rounded-2xl">
                                <img src="{{ $photo->url }}" alt="{{ $photo->caption ?: $photo->title }}" class="aspect-[4/3] w-full object-cover" style="object-position: center 20%;" loading="lazy">
                            </figure>
                        @endforeach
                    </div>
                @endif
            </div>

            <aside class="space-y-6">
                @if ($related->isNotEmpty())
                    <div class="card p-6">
                        <p class="eyebrow">Related activities</p>
                        <ul class="mt-4 space-y-3">
                            @foreach ($related as $relatedActivity)
                                <li>
                                    <a href="{{ route('activities.show', $relatedActivity) }}" class="block rounded-xl p-2 transition hover:bg-slate-50">
                                        <p class="text-sm font-bold text-ink-900">{{ $relatedActivity->title }}</p>
                                        <p class="text-xs text-ink-500">{{ $relatedActivity->category_label }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($events->isNotEmpty())
                    <div class="card p-6">
                        <p class="eyebrow">Upcoming events</p>
                        <ul class="mt-4 space-y-3">
                            @foreach ($events as $upcomingEvent)
                                <li>
                                    <a href="{{ route('events.show', $upcomingEvent) }}" class="block rounded-xl p-2 transition hover:bg-slate-50">
                                        <p class="text-sm font-bold text-ink-900">{{ $upcomingEvent->title }}</p>
                                        <p class="text-xs text-ink-500">{{ $upcomingEvent->starts_at->format('d M Y') }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </section>
</x-layouts.app>
