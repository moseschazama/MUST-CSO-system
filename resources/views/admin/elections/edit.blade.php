<x-admin-layout title="Edit Election" heading="Edit Election">
    <div class="card p-8">
        <form method="POST" action="{{ route('admin.elections.update', $election) }}">
            @method('PUT')
            @csrf
            <div>
                <label class="text-sm font-bold text-ink-900">Title</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="title" value="{{ $election->title }}" required>
            </div>
            <div class="mt-6">
                <label class="text-sm font-bold text-ink-900">Description</label>
                <textarea class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" rows="4" name="description">{{ $election->description }}</textarea>
            </div>
            <div class="mt-6">
                <label class="text-sm font-bold text-ink-900">Linked event</label>
                <select class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="event_id">
                    <option value="">None</option>
                    @foreach (\App\Models\Event::all() as $event)
                        <option value="{{ $event->id }}" @selected($election->event_id === $event->id)>{{ $event->title }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-bold text-ink-900">Opens at</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" type="datetime-local" name="opens_at" value="{{ $election->opens_at->format('Y-m-d\TH:i') }}" required>
                </div>
                <div>
                    <label class="text-sm font-bold text-ink-900">Closes at</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" type="datetime-local" name="closes_at" value="{{ $election->closes_at->format('Y-m-d\TH:i') }}" required>
                </div>
            </div>
            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                    <input type="checkbox" name="status" value="draft" @checked($election->status === 'draft') class="h-4 w-4 rounded border-slate-300 text-brand-600">
                    Draft
                </label>
                <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                    <input type="checkbox" name="status" value="open" @checked($election->status === 'open') class="h-4 w-4 rounded border-slate-300 text-brand-600">
                    Open for voting
                </label>
                <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                    <input type="checkbox" name="status" value="closed" @checked($election->status === 'closed') class="h-4 w-4 rounded border-slate-300 text-brand-600">
                    Closed
                </label>
                <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                    <input type="checkbox" name="status" value="verified" @checked($election->status === 'verified') class="h-4 w-4 rounded border-slate-300 text-brand-600">
                    Verified
                </label>
                <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                    <input type="checkbox" name="results_published" value="1" @checked($election->results_published) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                    Results published
                </label>
            </div>
            <div class="flex gap-3">
                <button class="btn-primary" type="submit">Save election</button>
                @if ($election->status !== 'open')
                    <form method="POST" action="{{ route('admin.elections.open', $election) }}">
                        @csrf
                        <button class="btn-ghost" type="submit">Open for voting</button>
                    </form>
                @endif
                @if ($election->status === 'verified')
                    <form method="POST" action="{{ route('admin.leaders.publish-election', $election) }}">
                        @csrf
                        <button class="btn-ghost" type="submit">Publish as committee</button>
                    </form>
                @endif
                @if ($election->status !== 'closed')
                    <form method="POST" action="{{ route('admin.elections.close', $election) }}">
                        @csrf
                        <button class="btn-ghost" type="submit">Close voting</button>
                    </form>
                @endif
                @if ($election->status !== 'verified')
                    <form method="POST" action="{{ route('admin.elections.verify', $election) }}" class="flex flex-wrap items-center gap-3">
                        @csrf
                        <label class="flex items-center gap-2 text-sm font-semibold text-ink-900">
                            <input type="checkbox" name="results_published" value="1" checked class="h-4 w-4 rounded border-slate-300 text-brand-600">
                            Publish results
                        </label>
                        <label class="flex items-center gap-2 text-sm font-semibold text-ink-900">
                            <input type="checkbox" name="publish_leadership" value="1" class="h-4 w-4 rounded border-slate-300 text-brand-600">
                            Publish winners as committee
                        </label>
                        <button class="btn-ghost" type="submit">Verify results</button>
                    </form>
                @endif
            </div>
        </form>
    </div>

    <div class="card mt-8 p-8">
        <h2 class="text-xl font-extrabold text-ink-900">Positions &amp; candidates</h2>
        <p class="mt-2 text-sm text-ink-500">Add committee positions for this election. Candidates can be added from each position after creating it.</p>
        <form method="POST" action="{{ route('admin.elections.positions.store', $election) }}" class="mt-6 grid max-w-xl gap-4">
            @csrf
            <div>
                <label class="text-sm font-bold text-ink-900">Position title</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="title" required>
            </div>
            <div>
                <label class="text-sm font-bold text-ink-900">Description</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="description">
            </div>
            <button class="btn-primary" type="submit">Add position</button>
        </form>
    </div>
</x-admin-layout>
