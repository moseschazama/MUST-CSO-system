<x-layouts.public
    title="Events"
    description="Upcoming and recent events published by the MUST Catholic Students Organisation."
>
    <section class="border-b border-charcoal-900/10 bg-ivory-100 py-14 sm:py-16">
        <div class="container-page">
            <p class="eyebrow text-gold-700">Events</p>
            <h1 class="mt-4 font-serif text-4xl leading-tight text-burgundy-950 sm:text-5xl">
                Gather with us.
            </h1>
            <p class="mt-6 max-w-2xl text-lg leading-relaxed text-charcoal-700">
                Events published by the CSO appear here with their date, time, and venue details.
            </p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-page">
            <x-section-heading
                eyebrow="Upcoming"
                title="What is coming up"
            />

            @if ($upcomingEvents->contains('is_demo', true))
                <div role="note" class="mt-8 border-l-4 border-gold-500 bg-white px-5 py-4 text-sm text-charcoal-700 shadow-card">
                    <strong class="font-semibold text-charcoal-900">Demonstration content:</strong>
                    some events listed here are sample entries used to preview the events feature. They
                    are not official CSO events.
                </div>
            @endif

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($upcomingEvents as $event)
                    <x-event-card :event="$event" />
                @empty
                    <div class="card p-8 md:col-span-2 lg:col-span-3">
                        <h3 class="font-serif text-2xl text-burgundy-950">No upcoming events published yet</h3>
                        <p class="prose-cso mt-3 max-w-2xl">
                            When the CSO publishes its next gathering, it will appear here. Please check
                            back soon, or contact the CSO if you would like more information.
                        </p>
                        <a href="{{ route('contact') }}" class="btn btn-outline mt-6">Contact the CSO</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @if ($pastEvents->isNotEmpty())
        <section class="bg-ivory-100 py-16">
            <div class="container-page">
                <x-section-heading
                    eyebrow="Archive"
                    title="Recent gatherings"
                    description="A record of events that have already taken place."
                />

                <ul class="mt-10 divide-y divide-charcoal-900/10 border-y border-charcoal-900/10 bg-white">
                    @foreach ($pastEvents as $event)
                        <li class="flex flex-wrap items-center justify-between gap-4 p-6">
                            <div>
                                <p class="text-sm text-charcoal-600">{{ $event->starts_at->format('l, j F Y') }}</p>
                                <h3 class="mt-1 font-serif text-xl text-burgundy-950">
                                    <a href="{{ route('events.show', $event) }}" class="transition-colors hover:text-burgundy-700">
                                        {{ $event->title }}
                                    </a>
                                </h3>
                            </div>

                            <a href="{{ route('events.show', $event) }}" class="text-sm font-semibold text-burgundy-800 transition-colors hover:text-burgundy-600">
                                Event details <span aria-hidden="true">&rarr;</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif
</x-layouts.public>
