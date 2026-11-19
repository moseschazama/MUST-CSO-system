@php
    $saint = config('cso.patron_saint');
    $org = config('cso.org');
@endphp

<x-layouts.app title="About Us" description="The background, mission and values of the MUST Catholic Students Organization.">

    <x-page-hero
        eyebrow="About MUST CSO"
        title="Rooted in faith, growing on campus."
        description="The story of a community of Catholic students at the Malawi University of Science and Technology — who we are, where we came from, and what we stand for."
        image="/images/gallery/1uk98FIgaYIusBOCr9qGfhKRXmfgDkX7n.jpg"
        breadcrumbs="About"
    />

    {{-- ===== Background & history ===== --}}
    <section class="section container-page">
        <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="eyebrow">Our story</p>
                <h2 class="mt-3 text-3xl font-extrabold text-ink-900 sm:text-4xl">
                    From a small circle to a campus family.
                </h2>

                <div class="mt-6 space-y-4 text-[15px] leading-relaxed text-ink-500">
                    <p>
                        The MUST Catholic Students Organization was formed in {{ $org['founded'] }} when a
                        small group of Catholic students began meeting weekly to pray, study Scripture
                        and support one another through the demands of university life at the
                        {{ $org['university'] }}.
                    </p>
                    <p>
                        Over the years the community has grown into a vibrant family that gathers every
                        week for Holy Mass, morning devotion and fellowship, while reaching out to the
                        sick and the needy in Thyolo and beyond. Today we welcome every Catholic
                        student — from first-year to final-year — into a home on campus where faith
                        and friendship walk together.
                    </p>
                    <p>
                        Our chaplaincy, patron and matron walk alongside the student executive to
                        keep the organization faithful to the Gospel and to the life of the Church.
                    </p>
                </div>

                <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-4">
                    @foreach (config('cso.stats') as $stat)
                        <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-4 text-center">
                            <p class="text-2xl font-extrabold text-brand-700">{{ $stat['value'] }}</p>
                            <p class="mt-1 text-[11px] font-bold tracking-wide text-ink-500 uppercase">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="relative">
                <div class="absolute -inset-4 -z-10 rounded-[2.75rem] bg-gradient-to-br from-brand-200/40 via-white to-gold-100/40 blur-xl"></div>
                <div class="card overflow-hidden rounded-[2rem] p-0">
                    <div class="relative aspect-[4/3] bg-slate-100">
                        <img
                            src="/images/gallery/1uk98FIgaYIusBOCr9qGfhKRXmfgDkX7n.jpg"
                            alt="CSO members in a campus gathering"
                            loading="lazy"
                            class="h-full w-full object-cover"
                            style="object-position: center 20%;"
                        >
                    </div>
                    <div class="p-6">
                        <p class="text-sm font-semibold text-ink-900">CSO Gathering — October 2026</p>
                        <p class="mt-1 text-xs text-ink-500">Teaching, the rosary and fellowship at MUST.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== Patron saint ===== --}}
    <section class="section container-page bg-slate-50/60 sm:rounded-[2.5rem]">
        <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-center">
            <div class="relative">
                <div class="aspect-[4/5] overflow-hidden rounded-[2rem] bg-gradient-to-br from-brand-100 via-white to-gold-100 ring-1 ring-brand-200/60">
                    <div class="flex h-full flex-col items-center justify-center p-8 text-center">
                        <span class="grid h-20 w-20 place-items-center rounded-3xl bg-gradient-to-br from-brand-500 to-brand-800 text-white shadow-xl shadow-brand-700/30">
                            <x-icon name="cross" class="h-10 w-10" />
                        </span>
                        <p class="mt-6 text-[10px] font-bold tracking-[0.2em] text-brand-700 uppercase">Patron saint</p>
                        <p class="mt-2 text-2xl leading-tight font-extrabold text-ink-900">{{ $saint['name'] }}</p>
                        <p class="mt-2 text-sm font-semibold text-gold-600">{{ $saint['title'] }}</p>
                        <p class="mt-4 text-xs text-ink-500">
                            Feast day &middot; {{ $saint['feast_day'] }}
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <p class="eyebrow">Patron saint spotlight</p>
                <h2 class="mt-3 text-3xl font-extrabold text-ink-900 sm:text-4xl">
                    {{ $saint['name'] }}
                </h2>

                <p class="mt-5 text-[15px] leading-relaxed text-ink-500">{{ $saint['bio'] }}</p>

                <blockquote class="mt-6 rounded-2xl border-l-4 border-brand-500 bg-brand-50/60 py-4 pl-5 pr-4">
                    <p class="text-base leading-relaxed font-semibold text-ink-900 italic">“{{ $saint['quote'] }}”</p>
                    <footer class="mt-2 text-xs font-bold tracking-wide text-brand-700 uppercase">
                        — {{ $saint['name'] }}
                    </footer>
                </blockquote>

                <p class="mt-6 text-sm leading-relaxed text-ink-500">
                    <span class="font-bold text-ink-900">Why we look to him:</span>
                    {{ $saint['inspiration'] }}
                </p>
            </div>
        </div>
    </section>

    {{-- ===== Objectives & values (bento) ===== --}}
    <section class="section container-page">
        <x-section-heading
            eyebrow="Objectives & core values"
            title="What we are building"
            description="Six pillars that shape our activities, our leadership and our community life."
            center
        />

        <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach (config('cso.values') as $index => $value)
                <article class="card card-hover reveal flex flex-col p-6 {{ $index === 0 ? 'sm:col-span-2 lg:col-span-1' : '' }}">
                    <div class="flex items-center gap-3">
                        <span class="icon-badge">
                            <x-icon :name="$value['icon']" class="h-5 w-5" />
                        </span>
                        <h3 class="text-base font-extrabold text-ink-900">{{ $value['title'] }}</h3>
                    </div>
                    <p class="mt-3 text-sm leading-relaxed text-ink-500">{{ $value['description'] }}</p>
                </article>
            @endforeach
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="container-page mb-4">
        <div class="rounded-3xl border border-brand-200/60 bg-gradient-to-br from-brand-50 to-white p-8 text-center sm:p-12">
            <h2 class="text-2xl font-extrabold text-ink-900 sm:text-3xl">Want to know us better?</h2>
            <p class="lead mx-auto mt-3 max-w-xl">
                Visit any Friday meeting at the Main Lecture Hall, or write to us — we would love to welcome you.
            </p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <a href="{{ route('contact') }}#join" class="btn-primary">
                    Join CSO
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
                <a href="{{ route('leadership') }}" class="btn-ghost">Meet the team</a>
            </div>
        </div>
    </section>
</x-layouts.app>
