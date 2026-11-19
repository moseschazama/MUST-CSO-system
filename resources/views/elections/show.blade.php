<x-layouts.app title="{{ $election->title }}">
    <x-page-hero eyebrow="Election" title="{{ $election->title }}" description="{{ $election->description }}" />

    <section class="section container-page">
        <div class="card p-8">
            <div class="flex flex-wrap items-center justify-between gap-6">
                <div>
                    <p class="eyebrow">Timeline</p>
                    <p class="mt-2 text-sm text-ink-500">Opens: {{ $election->opens_at->format('d M Y H:i') }}</p>
                    <p class="mt-1 text-sm text-ink-500">Closes: {{ $election->closes_at->format('d M Y H:i') }}</p>
                    <p class="mt-1 text-sm text-ink-500">Status: <span class="chip">{{ $election->status }}</span></p>
                </div>
                @if ($election->event_id)
                    <p class="text-sm text-ink-500">Linked event ID: {{ $election->event_id }}</p>
                @endif
            </div>

            @if ($election->status === 'verified')
                <div class="mt-8">
                    <h2 class="text-2xl font-extrabold text-ink-900">Declared results</h2>
                    @forelse ($results as $group)
                        <div class="mt-6">
                            <h3 class="text-lg font-extrabold text-ink-900">{{ $group['position']->title }}</h3>
                            <ol class="mt-3 space-y-2">
                                @foreach ($group['results'] as $index => $row)
                                    <li class="flex items-center justify-between rounded-2xl border border-slate-200 bg-white p-4">
                                        <span class="font-bold text-ink-900">{{ $index + 1 }}. {{ $row['candidate']->name }}</span>
                                        <span class="chip">{{ $row['votes'] }} votes</span>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    @empty
                        <p class="mt-4 text-sm text-ink-500">No results declared yet.</p>
                    @endforelse
                </div>
            @endif

            @if ($canVote && $position)
                <form method="POST" action="{{ route('elections.vote', $election) }}" class="mt-8 rounded-2xl border border-brand-200 bg-brand-50 p-6">
                    @csrf
                    <input type="hidden" name="position_id" value="{{ $position->id }}">
                    <h2 class="text-xl font-extrabold text-ink-900">Cast your vote</h2>
                    <p class="mt-2 text-sm text-ink-500">One vote per position during this election.</p>
                    <div class="mt-6 grid gap-4">
                        @foreach ($position->candidates as $candidate)
                            <label class="card card-hover flex items-center gap-4 p-4">
                                <input type="radio" name="candidate_id" value="{{ $candidate->id }}" required class="h-4 w-4">
                                <span class="font-bold text-ink-900">{{ $candidate->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    <button class="btn-primary mt-6" type="submit">Submit secret ballot</button>
                </form>
            @elseif (! $canVote && $election->status === 'open')
                <p class="mt-8 text-sm text-ink-500">Membership approval and an active election are required to vote.</p>
            @endif
        </div>
    </section>
</x-layouts.app>
