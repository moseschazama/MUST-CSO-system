<x-layouts.app title="My Account">
    <section class="container-page pt-28 pb-10 sm:pt-32 sm:pb-14 lg:pt-36 lg:pb-16">
        <div class="mx-auto max-w-4xl">
            <div class="card p-6 sm:p-8">
                <p class="eyebrow">Member area</p>
                <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Hello, {{ auth()->user()->name }}</h1>
                <p class="mt-2 text-sm text-ink-500">Email: {{ auth()->user()->email }}</p>

                <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-5">
                    <p class="text-sm font-bold text-ink-900">Membership status</p>
                    <p class="mt-2">
                        <span class="chip">{{ $member?->status ?? 'not_applied' }}</span>
                    </p>
                    @if ($member?->review_note)
                        <p class="mt-2 text-sm text-ink-500">{{ $member?->review_note }}</p>
                    @endif
                </div>

                <div class="mt-8">
                    <h2 class="text-xl font-extrabold text-ink-900">Elections</h2>
                    <div class="mt-4 grid gap-4">
                        @forelse ($elections as $election)
                            <div class="card card-hover flex flex-wrap items-center justify-between gap-4 p-5">
                                <div>
                                    <p class="font-bold text-ink-900">{{ $election->title }}</p>
                                    <p class="mt-1 text-sm text-ink-500">{{ $election->status }} &middot; {{ $election->positions_count }} positions</p>
                                </div>
                                <a href="{{ route('elections.show', $election) }}" class="btn-ghost btn-sm">View</a>
                            </div>
                        @empty
                            <p class="text-sm text-ink-500">No elections are currently open.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>

