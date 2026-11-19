<x-layouts.app title="Leadership" description="The spiritual and advisory leadership, current executive committee, past chairpersons and M’Phakati lists of MUST CSO.">

    <x-page-hero
        eyebrow="Leadership"
        title="The students and shepherds who serve you."
        description="Spiritual and advisory leadership, the current executive committee, past chairpersons, and the M’Phakati lists that help you find your community."
        image="/images/gallery/1WS1K0jiEOHhCE-uwy2xagCFEUzHwRVn3.jpg"
        breadcrumbs="Leadership"
    />

    <section class="section container-page">
        <div data-tab-group>
            <div class="flex flex-wrap gap-2 rounded-2xl border border-slate-200/70 bg-slate-50/70 p-1.5">
                @foreach ([
                    'spiritual' => ['label' => 'Spiritual & advisory', 'icon' => 'church', 'count' => $spiritual->count()],
                    'executive' => ['label' => 'Current executive', 'icon' => 'users', 'count' => $executive->count()],
                    'past' => ['label' => 'Past chairpersons', 'icon' => 'clock', 'count' => $past->count()],
                    'mphakati' => ['label' => "M'Phakati lists", 'icon' => 'users', 'count' => $groups->count()],
                ] as $key => $tab)
                    <button
                        type="button"
                        data-tab="{{ $key }}"
                        @class([
                            'is-active' => $key === 'executive',
                            'inline-flex items-center gap-2 rounded-xl px-4 py-2.5 text-sm font-semibold transition',
                        ])
                        aria-selected="{{ $key === 'executive' ? 'true' : 'false' }}"
                    >
                        <x-icon :name="$tab['icon']" class="h-4 w-4" />
                        {{ $tab['label'] }}
                        <span class="rounded-full bg-white/70 px-2 py-0.5 text-[11px] font-bold text-ink-500">
                            {{ $tab['count'] }}
                        </span>
                    </button>
                @endforeach
            </div>

            <div data-panel="spiritual" class="hidden mt-10">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($spiritual as $leader)
                        <x-leader-card :leader="$leader" />
                    @empty
                        <p class="text-sm text-ink-500">Spiritual leadership will be published soon.</p>
                    @endforelse
                </div>
            </div>

            <div data-panel="executive" class="mt-10">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($executive as $leader)
                        <x-leader-card :leader="$leader" />
                    @empty
                        <p class="text-sm text-ink-500">The current executive committee will be published soon.</p>
                    @endforelse
                </div>
            </div>

            <div data-panel="past" class="hidden mt-10">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($past as $leader)
                        <x-leader-card :leader="$leader" />
                    @empty
                        <p class="text-sm text-ink-500">The archive of past chairpersons is being prepared.</p>
                    @endforelse
                </div>
            </div>

            <div data-panel="mphakati" class="hidden mt-10">
                <div class="bg-slate-50/60 p-5 sm:rounded-[2.5rem] sm:p-8">
                    <div class="flex flex-wrap items-end justify-between gap-6">
                        <x-section-heading
                            eyebrow="M’Phakati"
                            title="Small Christian community lists"
                            description="Approved members allocated to each M’Phakati, available as PDFs."
                        />
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('documents.mphakati.all') }}" class="btn-ghost btn-sm">
                                <x-icon name="download" class="h-4 w-4" />
                                Download all lists
                            </a>
                            <a href="{{ route('activities') }}" class="btn-ghost btn-sm">
                                Activities
                                <x-icon name="arrow-right" class="h-4 w-4" />
                            </a>
                        </div>
                    </div>

                    <div class="card mt-8 flex flex-wrap items-end gap-4 p-5 sm:p-6">
                        <div class="min-w-64 flex-1">
                            <label class="field-label" for="member-search-name">Find your name</label>
                            <input id="member-search-name" type="search" class="field-input" placeholder="Type your full name" autocomplete="off" data-member-search-input>
                            <p class="mt-1 text-xs text-ink-500">Search approved members to see their M’Phakati and requested affiliations.</p>
                        </div>
                        <button type="button" class="btn-primary btn-sm" data-member-search-open>View my details</button>
                    </div>

                    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @forelse ($groups as $group)
                            <article class="card flex h-full flex-col p-6">
                                <div class="flex items-start justify-between gap-4">
                                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gold-100 text-gold-700 ring-1 ring-gold-300/50">
                                        <x-icon name="users" class="h-5 w-5" />
                                    </span>
                                    <span class="chip">{{ $group['count'] }} {{ \Illuminate\Support\Str::plural('member', $group['count']) }}</span>
                                </div>
                                <h3 class="mt-4 text-base font-extrabold text-ink-900">{{ $group['name'] }}</h3>
                                <p class="mt-1 text-sm text-ink-500">M’Phakati member list</p>
                                <a href="{{ route('documents.mphakati', ['group' => $group['name']]) }}" class="btn-ghost btn-sm mt-auto pt-5">
                                    <x-icon name="download" class="h-4 w-4" />
                                    Download PDF
                                </a>
                            </article>
                        @empty
                            <div class="col-span-full rounded-2xl border border-slate-200/70 bg-white p-6">
                                <p class="text-sm font-bold text-ink-900">No M’Phakati member lists yet.</p>
                                <p class="mt-1 text-sm text-ink-500">Lists appear here once approved members are allocated to a M’Phakati by the CSO leadership.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="fixed inset-0 z-[100] hidden items-center justify-center bg-ink-950/70 p-4 backdrop-blur-sm" data-member-search-modal data-member-search-url="{{ route('members.search') }}" role="dialog" aria-modal="true" aria-labelledby="member-search-title" aria-hidden="true">
        <div class="card max-h-[85vh] w-full max-w-2xl overflow-hidden">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-6">
                <div>
                    <p class="eyebrow">M’Phakati lookup</p>
                    <h2 id="member-search-title" class="mt-2 text-2xl font-extrabold text-ink-900">Membership details</h2>
                </div>
                <button type="button" class="btn-ghost btn-sm" data-member-search-close aria-label="Close">Close</button>
            </div>
            <div class="max-h-[65vh] overflow-y-auto p-6">
                <p class="text-sm text-ink-500" data-member-search-hint>Type at least two letters of your name above, then open this dialog.</p>
                <div class="grid gap-3" data-member-search-results></div>
            </div>
        </div>
    </div>
</x-layouts.app>
