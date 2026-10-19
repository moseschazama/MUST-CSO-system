@props(['event'])

<article class="card group flex h-full flex-col">
    <div class="flex items-start gap-4 border-b border-charcoal-900/10 p-6">
        <time
            datetime="{{ $event->starts_at->toIso8601String() }}"
            class="flex w-16 shrink-0 flex-col items-center border border-gold-500/60 bg-ivory-100 px-2 py-3 text-center"
        >
            <span class="eyebrow text-gold-700">{{ $event->starts_at->format('M') }}</span>
            <span class="font-serif text-3xl leading-none text-burgundy-900">{{ $event->starts_at->format('j') }}</span>
        </time>

        <div class="min-w-0">
            @if ($event->is_demo)
                <span class="badge badge-demo">Demonstration event</span>
            @endif

            <h3 class="mt-2 font-serif text-2xl leading-snug text-burgundy-950">
                <a href="{{ route('events.show', $event) }}" class="transition-colors hover:text-burgundy-700">
                    {{ $event->title }}
                </a>
            </h3>

            <p class="mt-2 text-sm text-charcoal-600">{{ $event->scheduleSummary() }}</p>

            @if ($event->location)
                <p class="mt-1 text-sm text-charcoal-600">{{ $event->location }}</p>
            @endif
        </div>
    </div>

    @if ($event->excerpt)
        <p class="px-6 py-5 text-sm leading-relaxed text-charcoal-700">{{ $event->excerpt }}</p>
    @endif

    <div class="mt-auto px-6 pb-6">
        <a href="{{ route('events.show', $event) }}" class="text-sm font-semibold text-burgundy-800 transition-colors hover:text-burgundy-600">
            Event details
            <span aria-hidden="true">&rarr;</span>
        </a>
    </div>
</article>
