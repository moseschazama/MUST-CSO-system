@props(['event', 'seed' => 0, 'wide' => false])

<article @class(['media-card group', 'sm:flex-row' => $wide])>
    <x-media-frame
        :image="$event->image_url"
        :video="$event->video_url"
        :poster="$event->video_thumbnail_url"
        :alt="$event->title"
        :seed="$seed + (int) $event->id"
        :ratio="$wide ? 'aspect-[16/10] sm:aspect-auto sm:h-auto sm:min-h-[20rem] sm:w-[45%] sm:shrink-0' : 'aspect-[16/10]'"
        label="Watch preview"
    >
        <div class="absolute inset-x-0 top-0 z-10 flex items-start justify-between gap-2 p-4">
            <span class="date-badge">
                <span class="date-badge-day">{{ $event->day }}</span>
                <span class="date-badge-month">{{ $event->month }}</span>
            </span>

            @if ($event->is_featured)
                <span class="media-badge media-badge-gold">
                    <x-icon name="star" class="h-3 w-3" />
                    Featured
                </span>
            @elseif ($event->state === 'ongoing')
                <span class="media-badge media-badge-gold">Happening now</span>
            @endif
        </div>
    </x-media-frame>

    <div @class(['flex flex-1 flex-col p-5', 'sm:justify-center sm:p-8' => $wide])>
        <h3 class="text-lg leading-snug font-extrabold text-ink-900">
            <a href="{{ route('events.show', $event) }}" class="transition hover:text-brand-700">{{ $event->title }}</a>
        </h3>

        <div class="mt-2 flex flex-wrap items-center gap-x-4 gap-y-1.5 text-xs font-semibold text-ink-500">
            @if ($event->time)
                <span class="inline-flex items-center gap-1.5">
                    <x-icon name="clock" class="h-3.5 w-3.5" />
                    {{ $event->time }}
                </span>
            @endif
            @if ($event->venue)
                <span class="inline-flex items-center gap-1.5">
                    <x-icon name="map-pin" class="h-3.5 w-3.5" />
                    {{ $event->venue }}
                </span>
            @endif
        </div>

        @if ($event->description)
            <p @class([
                'mt-3 text-sm leading-relaxed text-ink-500',
                'line-clamp-3' => ! $wide,
                'line-clamp-4 sm:line-clamp-none' => $wide,
            ])>{{ $event->description }}</p>
        @endif

        <div class="mt-auto flex flex-wrap items-center gap-2 pt-5">
            @if ($event->registration_enabled && $event->state !== 'completed')
                <a href="{{ route('events.show', $event) }}#register" class="btn-primary btn-sm">
                    Register
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
                <a href="{{ route('events.show', $event) }}" class="btn-ghost btn-sm">Details</a>
            @else
                <a href="{{ route('events.show', $event) }}" class="btn-primary btn-sm">
                    {{ $event->state === 'completed' ? 'See highlights' : 'View event' }}
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            @endif
        </div>
    </div>
</article>
