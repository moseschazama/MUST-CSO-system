@props(['event'])

<article class="card card-hover flex h-full flex-col overflow-hidden">
    <div class="flex items-start gap-4 p-6 pb-0">
        <div class="grid h-16 w-16 shrink-0 place-items-center rounded-2xl bg-gradient-to-br from-brand-600 to-brand-800 text-white shadow-lg shadow-brand-700/20">
            <span class="text-xl leading-none font-extrabold">{{ $event->day }}</span>
            <span class="mt-0.5 text-[10px] font-bold tracking-[0.16em]">{{ $event->month }}</span>
        </div>

        <div class="min-w-0">
            @if ($event->is_featured)
                <span class="inline-flex items-center gap-1 rounded-full bg-gold-100 px-2.5 py-0.5 text-[10px] font-bold tracking-wider text-gold-600 uppercase">
                    <x-icon name="star" class="h-3 w-3" />
                    Featured
                </span>
            @endif
            <h3 class="mt-1 text-base leading-snug font-extrabold text-ink-900">{{ $event->title }}</h3>
        </div>
    </div>

    <div class="flex flex-wrap gap-2 px-6 pt-4">
        <span class="chip">
            <x-icon name="clock" class="h-3 w-3" />
            {{ $event->time }}
        </span>
        @if ($event->venue)
            <span class="chip">
                <x-icon name="map-pin" class="h-3 w-3" />
                {{ $event->venue }}
            </span>
        @endif
    </div>

    @if ($event->description)
        <p class="mt-3 flex-1 px-6 text-sm leading-relaxed text-ink-500">{{ $event->description }}</p>
    @endif

    <div class="flex flex-wrap gap-2 p-6">
        <a href="{{ $event->calendar_url }}" target="_blank" rel="noopener" class="btn-soft btn-sm">
            <x-icon name="calendar-plus" class="h-4 w-4" />
            Add to calendar
        </a>
        @if ($event->rsvp_url)
            <a href="{{ $event->rsvp_url }}" target="_blank" rel="noopener" class="btn-primary btn-sm">
                RSVP
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        @endif
    </div>
</article>
