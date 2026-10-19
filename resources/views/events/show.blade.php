<x-layouts.public
    :title="$event->title"
    :description="$event->excerpt ?: 'Event details published by the MUST Catholic Students Organisation.'"
>
    <section class="theme-dark hero-texture py-14 sm:py-16">
        <div class="container-page">
            <p class="text-sm text-ivory-100/70">
                <a href="{{ route('events.index') }}" class="underline underline-offset-4 hover:text-gold-300">
                    &larr; All events
                </a>
            </p>

            @if ($event->is_demo)
                <p class="mt-6">
                    <span class="badge badge-demo">Demonstration event</span>
                </p>
            @endif

            <h1 class="mt-4 max-w-4xl font-serif text-4xl leading-[1.08] text-ivory-50 sm:text-5xl">
                {{ $event->title }}
            </h1>

            <p class="mt-5 text-lg text-gold-300">{{ $event->scheduleSummary() }}</p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-page grid gap-12 lg:grid-cols-12">
            <article class="lg:col-span-8">
                @if ($event->is_demo)
                    <div role="note" class="mb-8 border-l-4 border-gold-500 bg-white px-5 py-4 text-sm text-charcoal-700 shadow-card">
                        <strong class="font-semibold text-charcoal-900">Demonstration content:</strong>
                        this is a sample event used to preview the events feature. It is not an official
                        CSO event, and its date, venue, and details are illustrative only.
                    </div>
                @endif

                <dl class="grid gap-6 border-b border-charcoal-900/10 pb-8 sm:grid-cols-2">
                    <div>
                        <dt class="eyebrow text-gold-700">When</dt>
                        <dd class="mt-2 text-base text-charcoal-800">{{ $event->scheduleSummary() }}</dd>
                    </div>

                    <div>
                        <dt class="eyebrow text-gold-700">Where</dt>
                        <dd class="mt-2 text-base text-charcoal-800">
                            {{ $event->location ?: 'Venue to be confirmed' }}
                        </dd>
                    </div>
                </dl>

                <div class="prose-cso mt-8 text-lg">
                    {!! nl2br(e($event->description)) !!}
                </div>
            </article>

            <aside class="lg:col-span-4">
                <div class="border border-charcoal-900/10 bg-ivory-100 p-6">
                    <h2 class="font-serif text-xl text-burgundy-950">Questions about this event?</h2>
                    <p class="mt-3 text-sm leading-relaxed text-charcoal-700">
                        If you need more information, please reach out to the CSO through the contact
                        form.
                    </p>
                    <a href="{{ route('contact') }}" class="btn btn-outline mt-5">Contact the CSO</a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.public>
