@props(['activity', 'seed' => 0])

<article class="media-card group">
    <x-media-frame
        :image="$activity->image_url"
        :video="$activity->video_url"
        :poster="$activity->video_thumbnail_url"
        :alt="$activity->title"
        :seed="$seed + (int) $activity->id"
        ratio="aspect-[16/10]"
        label="Watch activity"
    >
        <div class="absolute inset-x-0 top-0 z-10 flex items-start justify-between gap-2 p-4">
            <span class="media-badge">{{ $activity->category_label }}</span>
            @if ($activity->is_featured)
                <span class="media-badge media-badge-gold">
                    <x-icon name="star" class="h-3 w-3" />
                    Featured
                </span>
            @endif
        </div>

        <div class="absolute inset-x-0 bottom-0 z-10 p-4 pr-16">
            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] font-bold text-white/80">
                @if ($activity->day)
                    <span class="inline-flex items-center gap-1"><x-icon name="calendar-days" class="h-3 w-3" /> {{ $activity->day }}</span>
                @endif
                @if ($activity->time)
                    <span class="inline-flex items-center gap-1"><x-icon name="clock" class="h-3 w-3" /> {{ $activity->time }}</span>
                @endif
            </div>
        </div>
    </x-media-frame>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="text-lg leading-snug font-extrabold text-ink-900">
            <a href="{{ route('activities.show', $activity) }}" class="transition hover:text-brand-700">{{ $activity->title }}</a>
        </h3>

        @if ($activity->summary)
            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-ink-500">{{ $activity->summary }}</p>
        @endif

        <div class="mt-auto flex items-center justify-between gap-3 pt-5">
            @if ($activity->venue)
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-ink-500">
                    <x-icon name="map-pin" class="h-3.5 w-3.5" />
                    {{ $activity->venue }}
                </span>
            @else
                <span></span>
            @endif

            <a href="{{ route('activities.show', $activity) }}"
               class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-700 transition hover:gap-2.5 hover:text-brand-800">
                Explore
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>
    </div>
</article>
