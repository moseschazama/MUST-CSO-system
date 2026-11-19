<x-layouts.app title="Elections">
    <x-page-hero eyebrow="Elections" title="Leadership elections" description="Vote for the CSO executive committee during an open election." />

    <section class="section container-page">
        <div class="grid gap-4">
            @forelse ($elections as $election)
                <div class="card card-hover flex flex-wrap items-center justify-between gap-4 p-6">
                    <div>
                        <h2 class="text-xl font-extrabold text-ink-900">{{ $election->title }}</h2>
                        <p class="mt-2 text-sm text-ink-500">{{ $election->status }} &middot; Opens {{ $election->opens_at->format('d M Y H:i') }} &middot; Closes {{ $election->closes_at->format('d M Y H:i') }}</p>
                        <p class="mt-1 text-sm text-ink-500">{{ $election->positions_count }} positions &middot; {{ $election->votes_count }} votes</p>
                    </div>
                    <a href="{{ route('elections.show', $election) }}" class="btn-primary btn-sm">Open election</a>
                </div>
            @empty
                <p class="text-sm text-ink-500">No elections are currently available.</p>
            @endforelse
        </div>
    </section>
</x-layouts.app>
