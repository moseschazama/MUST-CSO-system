@php
    $groups = collect($activities)->groupBy('category');
    $tabs = [
        'mass' => ['label' => 'Holy Mass & Liturgy', 'icon' => 'church'],
        'devotion' => ['label' => 'Devotions & Prayer', 'icon' => 'sunrise'],
        'meeting' => ['label' => 'Meetings & Fellowship', 'icon' => 'users'],
        'outreach' => ['label' => 'Charity & Outreach', 'icon' => 'heart-handshake'],
    ];
@endphp

<x-layouts.app title="Activities" description="The liturgical schedule, devotions, meetings and outreach programmes of MUST CSO.">

    <x-page-hero
        eyebrow="Activities & schedule"
        title="How we live our week."
        description="Masses, devotions, meetings and outreach — with the days, times and venues where we gather."
    />

    <section class="section container-page">
        <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-ink-500">Filter the schedule by the way you want to get involved.</p>
            <a href="{{ route('documents.projects') }}" class="btn-ghost btn-sm">
                <x-icon name="download" class="h-4 w-4" />
                Download activities PDF
            </a>
        </div>

        <div data-tab-group>
            <div class="flex flex-wrap gap-2 rounded-2xl border border-slate-200/70 bg-slate-50/70 p-1.5">
                @foreach ($tabs as $key => $tab)
                    <button
                        type="button"
                        data-tab="{{ $key }}"
                        @class([
                            'is-active' => $key === 'mass',
                            'inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition',
                        ])
                        aria-selected="{{ $key === 'mass' ? 'true' : 'false' }}"
                    >
                        <x-icon :name="$tab['icon']" class="h-4 w-4" />
                        {{ $tab['label'] }}
                        <span class="rounded-full bg-white/70 px-2 py-0.5 text-[11px] font-bold text-ink-500">
                            {{ $groups->get($key, collect())->count() }}
                        </span>
                    </button>
                @endforeach
            </div>

            @foreach ($tabs as $key => $tab)
                <div data-panel="{{ $key }}" @class(['mt-10', 'hidden' => $key !== 'mass'])>
                    <div class="grid gap-4 md:grid-cols-2">
                        @forelse ($groups->get($key, collect()) as $activity)
                            <article class="card card-hover flex items-start gap-4 p-6">
                                <span class="icon-badge h-12 w-12 rounded-2xl">
                                    <x-icon :name="$activity->icon ?: 'church'" class="h-5 w-5" />
                                </span>
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-extrabold text-ink-900">{{ $activity->title }}</h3>
                                    <div class="mt-2 flex flex-wrap gap-2">
                                        <span class="chip">
                                            <x-icon name="calendar-days" class="h-3 w-3" />
                                            {{ $activity->day }}
                                        </span>
                                        <span class="chip">
                                            <x-icon name="clock" class="h-3 w-3" />
                                            {{ $activity->time }}
                                        </span>
                                        @if ($activity->venue)
                                            <span class="chip">
                                                <x-icon name="map-pin" class="h-3 w-3" />
                                                {{ $activity->venue }}
                                            </span>
                                        @endif
                                    </div>
                                    @if ($activity->description)
                                        <p class="mt-3 text-sm leading-relaxed text-ink-500">{{ $activity->description }}</p>
                                    @endif
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-ink-500">No activities in this category yet.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container-page pb-16">
        <div class="rounded-3xl border border-brand-200/60 bg-gradient-to-br from-brand-50 to-white p-8 sm:p-10">
            <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
                <div>
                    <p class="eyebrow">New members welcome</p>
                    <h2 class="mt-2 text-2xl font-extrabold text-ink-900">Come as you are — just turn up.</h2>
                    <p class="mt-2 text-sm leading-relaxed text-ink-500">
                        No registration is needed to attend Mass, devotion or the Friday meeting.
                        Introduce yourself to the secretary after any gathering to be added to the register.
                    </p>
                </div>
                <a href="{{ route('contact') }}#join" class="btn-primary">
                    How to join
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
