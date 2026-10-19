<x-layouts.public>
    <section class="theme-dark hero-texture relative overflow-hidden">
        <div class="container-page relative grid gap-12 py-16 lg:grid-cols-12 lg:items-center lg:gap-10 lg:py-24">
            <div class="lg:col-span-7">
                <p class="eyebrow text-gold-300">MUST Catholic Students Organisation</p>

                <h1 class="mt-4 font-serif text-4xl leading-[1.05] text-ivory-50 sm:text-5xl lg:text-6xl">
                    A home for Catholic students at&nbsp;MUST.
                </h1>

                <p class="mt-5 font-serif text-2xl font-medium text-gold-300">
                    Faith. Fellowship. Service.
                </p>

                <p class="mt-6 max-w-xl text-lg leading-relaxed text-ivory-100/85">
                    We are a student community seeking to know Christ, to support one another,
                    and to serve the university and the wider community with joy.
                </p>

                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('about') }}" class="btn btn-gold">Discover the CSO</a>
                    <a href="{{ route('events.index') }}" class="btn btn-on-dark">Explore events</a>
                </div>
            </div>

            <div class="lg:col-span-5">
                <figure class="media-frame">
                    <img
                        src="{{ asset('images/hero-arch.svg') }}"
                        alt="Illustrative stained-glass-inspired artwork of a rose window beneath a pointed arch"
                        class="h-80 w-full object-cover sm:h-[26rem] lg:h-[34rem]"
                        width="900"
                        height="1150"
                    >
                    <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-burgundy-950 via-burgundy-950/85 to-transparent p-6 pt-16">
                        <p class="font-serif text-xl leading-snug text-ivory-50">
                            &ldquo;Let all that you do be done in love.&rdquo;
                        </p>
                        <p class="eyebrow mt-2 text-gold-300">1 Corinthians 16:14</p>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    <section class="section-texture py-16 sm:py-20">
        <div class="container-page grid gap-10 lg:grid-cols-12 lg:gap-14">
            <div class="lg:col-span-5">
                <x-section-heading
                    eyebrow="Who we are"
                    title="Catholic faith, student life, and a place to belong."
                />
            </div>

            <div class="lg:col-span-7">
                <div class="prose-cso text-lg">
                    <p>
                        The MUST Catholic Students Organisation brings together students who want to
                        live their Catholic faith within university life. Our common life is shaped by
                        prayer, the sacraments, friendship, and service.
                    </p>
                    <p>
                        This website is being developed so that students, parents, and the wider MUST
                        community can find the CSO more easily and stay connected with what is happening.
                    </p>
                </div>

                <dl class="mt-10 grid gap-6 sm:grid-cols-3">
                    <div class="border-t-2 border-gold-500 pt-4">
                        <dt class="font-serif text-xl text-burgundy-900">Faith</dt>
                        <dd class="mt-2 text-sm leading-relaxed text-charcoal-700">
                            Keeping Christ and the Eucharist at the centre of student life.
                        </dd>
                    </div>
                    <div class="border-t-2 border-gold-500 pt-4">
                        <dt class="font-serif text-xl text-burgundy-900">Fellowship</dt>
                        <dd class="mt-2 text-sm leading-relaxed text-charcoal-700">
                            Building genuine friendships that support students through university.
                        </dd>
                    </div>
                    <div class="border-t-2 border-gold-500 pt-4">
                        <dt class="font-serif text-xl text-burgundy-900">Service</dt>
                        <dd class="mt-2 text-sm leading-relaxed text-charcoal-700">
                            Following Christ by serving the campus and the surrounding community.
                        </dd>
                    </div>
                </dl>

                <a href="{{ route('about') }}" class="btn btn-outline mt-10">
                    More about the CSO
                </a>
            </div>
        </div>
    </section>

    <section id="faith-formation" class="theme-dark hero-texture py-16 sm:py-20">
        <div class="container-page">
            <x-section-heading
                eyebrow="Faith formation"
                title="Formed by prayer, Scripture, and the sacraments."
                description="Catholic students grow in faith when they are rooted in prayer and supported by a community that takes the faith seriously. The CSO seeks to make room for that growth at MUST."
                tone="dark"
            />

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                <div class="border border-ivory-50/15 bg-ivory-50/5 p-6">
                    <svg viewBox="0 0 40 40" fill="none" aria-hidden="true" class="h-10 w-10 text-gold-300">
                        <path d="M13 36V14h14v22" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M9 36h22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M20 8v6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M16.5 11.5h7" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M20 6a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5Z" fill="currentColor" opacity="0.35"/>
                    </svg>

                    <h3 class="mt-5 font-serif text-2xl text-ivory-50">Prayer &amp; Sacraments</h3>
                    <p class="mt-3 text-sm leading-relaxed text-ivory-100/80">
                        Space to encounter Christ in the Eucharist, in personal prayer, and in the
                        sacramental life of the Church.
                    </p>
                </div>

                <div class="border border-ivory-50/15 bg-ivory-50/5 p-6">
                    <svg viewBox="0 0 40 40" fill="none" aria-hidden="true" class="h-10 w-10 text-gold-300">
                        <path d="M20 11c-4-3-9-3.6-14-2v22c5-1.6 10-1 14 2 4-3 9-3.6 14-2V9c-5-1.6-10-1-14 2Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                        <path d="M20 11v22" stroke="currentColor" stroke-width="2"/>
                    </svg>

                    <h3 class="mt-5 font-serif text-2xl text-ivory-50">Scripture &amp; Formation</h3>
                    <p class="mt-3 text-sm leading-relaxed text-ivory-100/80">
                        Learning to read Scripture, understand the faith, and bring it into the
                        decisions of student life.
                    </p>
                </div>

                <div class="border border-ivory-50/15 bg-ivory-50/5 p-6">
                    <svg viewBox="0 0 40 40" fill="none" aria-hidden="true" class="h-10 w-10 text-gold-300">
                        <path d="M7 20h7l3-6 5 13 3-7h8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 33c-7 0-13-5-13-13" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
                        <path d="M20 33c7 0 13-5 13-13" stroke="currentColor" stroke-width="2" stroke-linecap="round" opacity="0.5"/>
                    </svg>

                    <h3 class="mt-5 font-serif text-2xl text-ivory-50">Service &amp; Mission</h3>
                    <p class="mt-3 text-sm leading-relaxed text-ivory-100/80">
                        Following Christ in service of others, with attention to the needs of the
                        university and surrounding community.
                    </p>
                </div>
            </div>

            <p class="mt-8 text-sm text-ivory-100/70">
                Specific programme dates, formation activities, and chaplaincy details will be
                published once they have been confirmed by the CSO.
            </p>
        </div>
    </section>

    <section class="bg-ivory-100 py-16 sm:py-20">
        <div class="container-page">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-section-heading
                    eyebrow="Upcoming events"
                    title="Gather with us."
                    description="Events published by the CSO will appear here, with the date, time, and venue details."
                />

                <a href="{{ route('events.index') }}" class="btn btn-outline">View all events</a>
            </div>

            @if ($upcomingEvents->contains('is_demo', true))
                <div role="note" class="mt-8 border-l-4 border-gold-500 bg-white px-5 py-4 text-sm text-charcoal-700 shadow-card">
                    <strong class="font-semibold text-charcoal-900">Demonstration content:</strong>
                    the events below are sample entries used to preview the events feature. They are
                    not official CSO events.
                </div>
            @endif

            <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse ($upcomingEvents as $event)
                    <x-event-card :event="$event" />
                @empty
                    <div class="card p-8 md:col-span-2 lg:col-span-3">
                        <h3 class="font-serif text-2xl text-burgundy-950">No upcoming events published yet</h3>
                        <p class="prose-cso mt-3 max-w-2xl">
                            When the CSO publishes its next gathering, it will appear here. In the
                            meantime, you are welcome to reach out to the community.
                        </p>
                        <a href="{{ route('contact') }}" class="btn btn-outline mt-6">Contact the CSO</a>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section id="community" class="py-16 sm:py-20">
        <div class="container-page">
            <x-section-heading
                eyebrow="Community"
                title="A community you can journey with."
                description="Worship, friendship, music, and campus life all have a place in the CSO."
                align="center"
            />

            <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <figure class="media-frame">
                    <img
                        src="{{ asset('images/community-worship.svg') }}"
                        alt="Illustrative artwork of candles beneath an arch"
                        class="h-56 w-full object-cover"
                        width="900"
                        height="700"
                        loading="lazy"
                    >
                    <figcaption class="border-t border-charcoal-900/10 bg-white p-5">
                        <h3 class="font-serif text-xl text-burgundy-950">Worship</h3>
                        <p class="mt-1 text-sm leading-relaxed text-charcoal-600">
                            Prayer and the sacraments at the centre of our life together.
                        </p>
                    </figcaption>
                </figure>

                <figure class="media-frame">
                    <img
                        src="{{ asset('images/community-fellowship.svg') }}"
                        alt="Illustrative artwork of a cloister arcade and a gathering"
                        class="h-56 w-full object-cover"
                        width="900"
                        height="700"
                        loading="lazy"
                    >
                    <figcaption class="border-t border-charcoal-900/10 bg-white p-5">
                        <h3 class="font-serif text-xl text-burgundy-950">Fellowship</h3>
                        <p class="mt-1 text-sm leading-relaxed text-charcoal-600">
                            Friendship and support for students navigating university life.
                        </p>
                    </figcaption>
                </figure>

                <figure class="media-frame">
                    <img
                        src="{{ asset('images/community-choir.svg') }}"
                        alt="Illustrative artwork of sound waves rising in an arched hall"
                        class="h-56 w-full object-cover"
                        width="900"
                        height="700"
                        loading="lazy"
                    >
                    <figcaption class="border-t border-charcoal-900/10 bg-white p-5">
                        <h3 class="font-serif text-xl text-burgundy-950">Choir</h3>
                        <p class="mt-1 text-sm leading-relaxed text-charcoal-600">
                            Music that lifts prayer and brings the community together.
                        </p>
                    </figcaption>
                </figure>

                <figure class="media-frame">
                    <img
                        src="{{ asset('images/community-campus.svg') }}"
                        alt="Illustrative artwork of a campus building with an arcade"
                        class="h-56 w-full object-cover"
                        width="900"
                        height="700"
                        loading="lazy"
                    >
                    <figcaption class="border-t border-charcoal-900/10 bg-white p-5">
                        <h3 class="font-serif text-xl text-burgundy-950">Campus life</h3>
                        <p class="mt-1 text-sm leading-relaxed text-charcoal-600">
                            A Catholic presence within the daily life of the university.
                        </p>
                    </figcaption>
                </figure>
            </div>

            <p class="mt-8 text-sm text-charcoal-600">
                The artwork on this page is illustrative. Approved CSO photographs of worship,
                fellowship, choir, and campus life will replace these panels once they are available.
            </p>
        </div>
    </section>

    <section class="theme-dark hero-texture py-14">
        <div class="container-page flex flex-col items-start justify-between gap-8 lg:flex-row lg:items-center">
            <div class="max-w-2xl">
                <h2 class="font-serif text-3xl leading-tight text-ivory-50 sm:text-4xl">
                    Come as you are. There is a place for you here.
                </h2>
                <p class="mt-4 text-base leading-relaxed text-ivory-100/80">
                    Whether you are new to MUST, returning to the faith, or simply curious about the
                    Catholic community on campus, you are welcome to reach out.
                </p>
            </div>

            <a href="{{ route('contact') }}" class="btn btn-gold">Get in touch</a>
        </div>
    </section>
</x-layouts.public>
