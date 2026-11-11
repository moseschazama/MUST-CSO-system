<x-layouts.app title="Leadership" description="The spiritual and advisory leadership, current executive committee and past chairpersons of MUST CSO.">

    <x-page-hero
        eyebrow="Leadership"
        title="The students and shepherds who serve you."
        description="Spiritual and advisory leadership, the current executive committee, and the chairpersons who have carried MUST CSO through the years."
    />

    <section class="section container-page">
        <div data-tab-group>
            {{-- Tab bar --}}
            <div class="flex flex-wrap gap-2 rounded-2xl border border-slate-200/70 bg-slate-50/70 p-1.5">
                @foreach ([
                    'spiritual' => ['label' => 'Spiritual & advisory', 'icon' => 'church', 'count' => $spiritual->count()],
                    'executive' => ['label' => 'Current executive', 'icon' => 'users', 'count' => $executive->count()],
                    'past' => ['label' => 'Past chairpersons', 'icon' => 'clock', 'count' => $past->count()],
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

            {{-- Spiritual --}}
            <div data-panel="spiritual" class="hidden mt-10">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($spiritual as $leader)
                        <x-leader-card :leader="$leader" />
                    @endforeach
                </div>
            </div>

            {{-- Executive --}}
            <div data-panel="executive" class="mt-10">
                <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($executive as $leader)
                        <x-leader-card :leader="$leader" />
                    @endforeach
                </div>
            </div>

            {{-- Past --}}
            <div data-panel="past" class="hidden mt-10">
                <div class="relative pl-6">
                    <span class="absolute top-0 left-2 h-full w-px bg-gradient-to-b from-brand-300 via-brand-200 to-transparent"></span>
                    <div class="space-y-4">
                        @foreach ($past as $leader)
                            <div class="relative card flex items-center gap-4 p-5">
                                <span class="absolute -left-[1.45rem] top-6 grid h-6 w-6 place-items-center rounded-full bg-brand-600 text-white ring-4 ring-white">
                                    <x-icon name="check" class="h-3 w-3" />
                                </span>
                                <x-avatar :name="$leader->name" :photo="$leader->photo" size="h-12 w-12" />
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-extrabold text-ink-900">{{ $leader->name }}</p>
                                    <p class="text-xs font-semibold text-brand-700">{{ $leader->role }} &middot; {{ $leader->tenure }}</p>
                                    @if ($leader->bio)
                                        <p class="mt-1 text-xs leading-relaxed text-ink-500">{{ $leader->bio }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Note on tabs --}}
    <section class="container-page pb-16">
        <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-6 text-center">
            <p class="text-sm text-ink-500">
                <span class="font-bold text-ink-900">SAMPLE DATA —</span>
                replace every name, role, tenure and photo with the real people in
                <code class="rounded bg-white px-1.5 py-0.5 text-xs">database/seeders/LeaderSeeder.php</code>,
                then run <code class="rounded bg-white px-1.5 py-0.5 text-xs">php artisan migrate:fresh --seed</code>.
            </p>
        </div>
    </section>
</x-layouts.app>
