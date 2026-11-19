@php
    $event = $event;
    $state = $event->state;
@endphp

<x-layouts.app title="{{ $event->title }}" description="{{ $event->summary ?? $event->description }}">

    <section class="relative isolate flex min-h-[380px] items-end overflow-hidden bg-brand-950 sm:min-h-[430px] lg:min-h-[500px]">
        <img src="{{ $event->image_url ?: config('cso.media_fallbacks')[0] }}" alt="{{ $event->title }}" class="absolute inset-0 -z-20 h-full w-full object-cover" style="object-position: center 22%;">
        <div class="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950/92 via-brand-950/82 to-brand-900/55"></div>
        <div class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950/75 via-ink-900/20 to-ink-950/30"></div>
        <div class="pointer-events-none absolute -right-20 -top-20 -z-10 h-72 w-72 rounded-full bg-brand-400/20 blur-3xl"></div>
        <div class="container-page relative w-full pt-28 pb-14 sm:pt-32 sm:pb-16 lg:pt-36 lg:pb-20">
            <div class="max-w-4xl">
                <nav aria-label="Breadcrumb" class="mb-6">
                    <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-bold tracking-[0.16em] text-white/65 uppercase">
                        <li><a href="{{ route('home') }}" class="transition hover:text-white">Home</a></li>
                        <li aria-hidden="true" class="text-white/30"><x-icon name="chevron-right" class="h-3.5 w-3.5" /></li>
                        <li><a href="{{ route('events.index') }}" class="transition hover:text-white">Events</a></li>
                        <li aria-hidden="true" class="text-white/30"><x-icon name="chevron-right" class="h-3.5 w-3.5" /></li>
                        <li class="min-w-0 text-white/95" aria-current="page">{{ $event->title }}</li>
                    </ol>
                </nav>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-1.5 text-[10px] font-bold tracking-[0.2em] text-white/90 uppercase backdrop-blur-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                        {{ \App\Models\Event::TYPES[$event->event_type] ?? 'Event' }}
                    </span>
                    @if ($event->is_election)<span class="inline-flex items-center rounded-full border border-gold-400/40 bg-gold-500/20 px-4 py-1.5 text-[10px] font-bold tracking-[0.2em] text-gold-200 uppercase backdrop-blur-sm">Election</span>@endif
                </div>
                <h1 class="mt-5 max-w-3xl text-4xl leading-[1.05] font-extrabold text-balance text-white sm:text-5xl lg:text-[3.25rem]">{{ $event->title }}</h1>
                <p class="mt-5 max-w-2xl text-base leading-relaxed text-white/80 sm:text-lg">{{ $event->description }}</p>
                <div class="mt-6 flex flex-wrap gap-x-5 gap-y-2 text-sm text-white/85">
                    <span class="inline-flex items-center gap-2"><x-icon name="calendar" class="h-4 w-4 text-gold-300" /> {{ $event->starts_at->format('l, d F Y') }}@if($event->time_label) Â· {{ $event->time_label }}@endif</span>
                    @if ($event->venue)<span class="inline-flex items-center gap-2"><x-icon name="map-pin" class="h-4 w-4 text-gold-300" /> {{ $event->venue }}</span>@endif
                    <span class="inline-flex items-center gap-2"><x-icon name="users" class="h-4 w-4 text-gold-300" /> {{ $event->status_label }}</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section container-page">
        <div class="grid gap-10 lg:grid-cols-[1.5fr_1fr]">
            <div class="space-y-8">
                @if ($event->video_url)
                    <div class="overflow-hidden rounded-3xl border border-slate-200/70 bg-white shadow-sm">
                        <x-media-frame
                            :image="$event->image_url"
                            :video="$event->video_url"
                            :poster="$event->video_thumbnail_url"
                            :alt="$event->title"
                            :seed="$event->id"
                            ratio="aspect-video"
                            label="Watch event preview"
                        />
                    </div>
                @endif

                @if ($event->map_query)
                    <div class="overflow-hidden rounded-3xl border border-slate-200/70 bg-white shadow-sm">
                        <iframe
                            title="Event location"
                            src="{{ $event->map_embed_url }}"
                            class="h-72 w-full border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                @endif

                {{-- Election ballot / results --}}
                @if ($event->is_election && $election)
                    <div class="card p-6 sm:p-8">
                        <p class="eyebrow">Election</p>
                        <h2 class="mt-2 text-2xl font-extrabold text-ink-900">{{ $election->title }}</h2>
                        @if ($election->description)
                            <p class="mt-2 text-sm text-ink-500">{{ $election->description }}</p>
                        @endif

                        <div class="mt-4 flex flex-wrap gap-3 text-xs">
                            <span class="chip">Opens {{ $election->opens_at->format('d M Y, H:i') }}</span>
                            <span class="chip">Closes {{ $election->closes_at->format('d M Y, H:i') }}</span>
                            <span class="chip">{{ $election->status_label }}</span>
                        </div>

                        @if ($results)
                            <div class="mt-8 space-y-6">
                                <h3 class="text-lg font-extrabold text-ink-900">Declared results</h3>
                                @foreach ($results as $row)
                                    <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-5">
                                        <p class="font-bold text-ink-900">{{ $row['position']->title }}</p>
                                        <ul class="mt-3 space-y-2">
                                            @foreach ($row['rows'] as $candidateRow)
                                                <li class="flex items-center justify-between text-sm">
                                                    <span class="text-ink-700">{{ $candidateRow['candidate']->name }}</span>
                                                    <span class="font-bold text-brand-700">{{ $candidateRow['votes'] }} votes ({{ $candidateRow['percent'] }}%)</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        @if ($row['position']->winner)
                                            <p class="mt-3 text-xs font-bold text-emerald-700">Winner: {{ $row['position']->winner->name }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @elseif ($canVote)
                            <form method="POST" action="{{ route('events.vote', $event) }}" class="mt-8 space-y-6">
                                @csrf
                                @foreach ($ballot as $position)
                                    <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-5">
                                        <p class="font-bold text-ink-900">{{ $position->title }}</p>
                                        @if ($position->description)<p class="mt-1 text-xs text-ink-500">{{ $position->description }}</p>@endif
                                        <div class="mt-4 grid gap-3">
                                            @foreach ($position->candidates as $candidate)
                                                <label class="choice-card">
                                                    <input type="radio" name="candidate_id_for_{{ $position->id }}" value="{{ $candidate->id }}" class="mt-0.5 h-4 w-4 text-brand-600 focus:ring-brand-500" data-position="{{ $position->id }}">
                                                    @if ($candidate->photo)
                                                        <img src="{{ $candidate->photo_url }}" alt="{{ $candidate->name }}" class="h-10 w-10 rounded-full object-cover">
                                                    @endif
                                                    <div>
                                                        <span class="text-sm font-semibold text-ink-900">{{ $candidate->name }}</span>
                                                        @if ($candidate->bio)<p class="mt-0.5 text-xs text-ink-500">{{ \Illuminate\Support\Str::limit($candidate->bio, 120) }}</p>@endif
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                        {{-- hidden fields submitted per position via JS below --}}
                                    </div>
                                @endforeach

                                <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        const form = document.currentScript.closest('form');
                                        form.addEventListener('submit', (e) => {
                                            // convert per-position radios into position_id/candidate_id pairs
                                            const positions = new Set();
                                            form.querySelectorAll('[data-position]').forEach(i => positions.add(i.dataset.position));
                                            // remove any prior hidden
                                            form.querySelectorAll('input[name="position_id"], input[name="candidate_id"]').forEach(n => n.remove());
                                            let ok = true;
                                            positions.forEach(pos => {
                                                const checked = form.querySelector('input[data-position="' + pos + '"]:checked');
                                                if (!checked) { ok = false; return; }
                                                const p = document.createElement('input'); p.type='hidden'; p.name='position_id'; p.value=pos; form.appendChild(p);
                                                const c = document.createElement('input'); c.type='hidden'; c.name='candidate_id'; c.value=checked.value; form.appendChild(c);
                                            });
                                            if (!ok) { e.preventDefault(); alert('Please choose a candidate for every position.'); }
                                        });
                                    });
                                </script>

                                <p class="text-xs text-ink-500">Your vote is secret. One vote per position, recorded once.</p>
                                <button type="submit" class="btn-primary">Cast my votes</button>
                            </form>
                        @else
                            <p class="mt-6 text-sm text-ink-500">
                                @auth
                                    @if (auth()->user()->is_admin)
                                        Administrators cannot vote.
                                    @elseif (! auth()->user()->member || auth()->user()->member->status !== 'approved')
                                        Only approved CSO members can vote. <a href="{{ route('join') }}" class="font-semibold text-brand-700">Apply for membership</a>.
                                    @elseif (! $election->isOpen())
                                        Voting is not open right now.
                                    @else
                                        You have already voted in this election.
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="font-semibold text-brand-700">Sign in</a> to vote if you are an approved member.
                                @endauth
                            </p>
                        @endif
                    </div>
                @endif
            </div>

            <aside class="space-y-6">
                <div class="card p-6">
                    <p class="eyebrow">Details</p>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex items-start gap-3">
                            <x-icon name="calendar" class="mt-0.5 h-4 w-4 text-brand-600" />
                            <div>
                                <dt class="font-bold text-ink-900">Date</dt>
                                <dd class="text-ink-500">{{ $event->starts_at->format('l, d F Y') }}</dd>
                            </div>
                        </div>
                        @if ($event->time_label)
                            <div class="flex items-start gap-3">
                                <x-icon name="clock" class="mt-0.5 h-4 w-4 text-brand-600" />
                                <div>
                                    <dt class="font-bold text-ink-900">Time</dt>
                                    <dd class="text-ink-500">{{ $event->time_label }}</dd>
                                </div>
                            </div>
                        @endif
                        @if ($event->venue)
                            <div class="flex items-start gap-3">
                                <x-icon name="map-pin" class="mt-0.5 h-4 w-4 text-brand-600" />
                                <div>
                                    <dt class="font-bold text-ink-900">Venue</dt>
                                    <dd class="text-ink-500">{{ $event->venue }}</dd>
                                </div>
                            </div>
                        @endif
                        @if ($event->capacity)
                            <div class="flex items-start gap-3">
                                <x-icon name="users" class="mt-0.5 h-4 w-4 text-brand-600" />
                                <div>
                                    <dt class="font-bold text-ink-900">Capacity</dt>
                                    <dd class="text-ink-500">{{ $event->registrations_count ?? $event->registrations->count() }} / {{ $event->capacity }}</dd>
                                </div>
                            </div>
                        @endif
                    </dl>
                </div>

                @if ($event->registration_enabled)
                    <div id="register" class="card scroll-mt-28 p-6">
                        <p class="eyebrow">Registration</p>
                        @auth
                            @if ($registered)
                                <p class="mt-3 text-sm font-semibold text-emerald-700">You are registered for this event.</p>
                            @elseif ($event->is_full)
                                <p class="mt-3 text-sm text-ink-500">This event is full.</p>
                            @else
                                <form method="POST" action="{{ route('events.register', $event) }}" class="mt-4 grid gap-3">
                                    @csrf
                                    <input name="phone" value="{{ auth()->user()->phone }}" placeholder="Phone (optional)" class="field-input">
                                    <textarea name="notes" rows="2" placeholder="Notes (optional)" class="field-textarea"></textarea>
                                    <button type="submit" class="btn-primary">Register</button>
                                </form>
                            @endif
                        @else
                            <p class="mt-3 text-sm text-ink-500">
                                <a href="{{ route('login') }}" class="font-semibold text-brand-700">Sign in</a> to register.
                            </p>
                        @endauth
                    </div>
                @endif

                @if ($related->isNotEmpty())
                    <div class="card p-6">
                        <p class="eyebrow">Upcoming events</p>
                        <ul class="mt-4 space-y-3">
                            @foreach ($related as $relatedEvent)
                                <li>
                                    <a href="{{ route('events.show', $relatedEvent) }}" class="block rounded-xl p-2 transition hover:bg-slate-50">
                                        <p class="text-sm font-bold text-ink-900">{{ $relatedEvent->title }}</p>
                                        <p class="text-xs text-ink-500">{{ $relatedEvent->starts_at->format('d M Y') }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </aside>
        </div>
    </section>
</x-layouts.app>
