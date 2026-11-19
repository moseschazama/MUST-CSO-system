@php
    $org = config('cso.org');
@endphp

<x-layouts.app title="Events" description="Upcoming and past events of the MUST Catholic Students Organization.">

    <x-page-hero
        eyebrow="Events"
        title="Gather, worship, serve."
        description="Holy Mass, devotions, formation sessions and community events — all in one calendar."
        image="/images/gallery/1Pt2sQzEhFcWA6VP962TRptoVSN5J-qBP.jpg"
        breadcrumbs="Events"
    />

    <section class="section container-page">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <div>
                <p class="eyebrow">Filter</p>
                <div class="mt-3 flex flex-wrap gap-2">
                    <a href="{{ route('events.index', ['when' => 'upcoming']) }}"
                       @class(['chip', 'is-active' => $when === 'upcoming'])>Upcoming</a>
                    <a href="{{ route('events.index', ['when' => 'past']) }}"
                       @class(['chip', 'is-active' => $when === 'past'])>Past</a>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('events.index', ['when' => $when]) }}"
                   @class(['chip', 'is-active' => ! $type])>All types</a>
                @foreach ($types as $key => $label)
                    <a href="{{ route('events.index', ['when' => $when, 'type' => $key]) }}"
                       @class(['chip', 'is-active' => $type === $key])>{{ $label }}</a>
                @endforeach
            </div>
        </div>

        @if ($featured && ! $type)
            <article class="media-card group mt-10 lg:grid lg:grid-cols-[1.2fr_1fr]">
                <x-media-frame
                    :image="$featured->image_url"
                    :video="$featured->video_url"
                    :poster="$featured->video_thumbnail_url"
                    :alt="$featured->title"
                    :seed="$featured->id"
                    ratio="aspect-[16/10] lg:aspect-auto lg:h-full lg:min-h-[27rem]"
                    label="Watch event preview"
                >
                    <div class="absolute inset-x-0 top-0 z-10 flex items-start justify-between gap-2 p-5">
                        <span class="date-badge">
                            <span class="date-badge-day">{{ $featured->day }}</span>
                            <span class="date-badge-month">{{ $featured->month }}</span>
                        </span>
                        <span class="media-badge media-badge-gold">
                            <x-icon name="star" class="h-3 w-3" />
                            Featured event
                        </span>
                    </div>
                </x-media-frame>

                <div class="flex flex-col justify-center p-6 sm:p-9">
                    <p class="eyebrow">{{ $featured->type_label }}</p>
                    <h2 class="mt-3 text-3xl leading-tight font-extrabold text-ink-900 sm:text-4xl">
                        {{ $featured->title }}
                    </h2>

                    @if ($featured->description)
                        <p class="mt-3 line-clamp-3 text-[15px] leading-relaxed text-ink-500">{{ $featured->description }}</p>
                    @endif

                    <div class="mt-5 flex flex-wrap gap-2">
                        <span class="chip"><x-icon name="calendar-days" class="h-3.5 w-3.5" /> {{ $featured->starts_at->format('l, d F Y') }}</span>
                        @if ($featured->time)
                            <span class="chip"><x-icon name="clock" class="h-3.5 w-3.5" /> {{ $featured->time }}</span>
                        @endif
                        @if ($featured->venue)
                            <span class="chip"><x-icon name="map-pin" class="h-3.5 w-3.5" /> {{ $featured->venue }}</span>
                        @endif
                    </div>

                    <div class="mt-7 flex flex-wrap gap-2">
                        @if ($featured->registration_enabled)
                            <a href="{{ route('events.show', $featured) }}#register" class="btn-primary">
                                Register for this event
                                <x-icon name="arrow-right" class="h-4 w-4" />
                            </a>
                        @endif
                        <a href="{{ route('events.show', $featured) }}" class="btn-ghost">
                            View details
                        </a>
                    </div>
                </div>
            </article>
        @endif

        <div @class([
            'mt-10 grid gap-5',
            'sm:grid-cols-2' => $events->count() > 1,
            'lg:grid-cols-3' => $events->count() > 2,
        ])>
            @forelse ($events as $event)
                <x-event-card :event="$event" :seed="$loop->iteration" :wide="$events->count() === 1" />
            @empty
                <p class="col-span-full text-center text-ink-500">No events in this view yet.</p>
            @endforelse
        </div>
    </section>
</x-layouts.app>
