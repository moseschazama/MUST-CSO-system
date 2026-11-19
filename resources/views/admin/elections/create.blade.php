<x-admin-layout title="New Election" heading="New Election">
    <div class="card p-8">
        <form method="POST" action="{{ route('admin.elections.store') }}" class="grid gap-6">
            @csrf
            <div>
                <label class="text-sm font-bold text-ink-900">Title</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="title" required>
            </div>
            <div>
                <label class="text-sm font-bold text-ink-900">Description</label>
                <textarea class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" rows="4" name="description"></textarea>
            </div>
            <div>
                <label class="text-sm font-bold text-ink-900">Linked event</label>
                <select class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="event_id">
                    <option value="">None</option>
                    @foreach (\App\Models\Event::all() as $event)
                        <option value="{{ $event->id }}">{{ $event->title }} - {{ $event->starts_at->format('d M Y') }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-bold text-ink-900">Opens at</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" type="datetime-local" name="opens_at" required>
                </div>
                <div>
                    <label class="text-sm font-bold text-ink-900">Closes at</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" type="datetime-local" name="closes_at" required>
                </div>
            </div>
            <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                <input type="checkbox" name="status" value="draft" @checked(true) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                Draft
            </label>
            <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                <input type="checkbox" name="status" value="open" class="h-4 w-4 rounded border-slate-300 text-brand-600">
                Open for voting
            </label>
            <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                <input type="checkbox" name="results_published" value="1" class="h-4 w-4 rounded border-slate-300 text-brand-600">
                Results published
            </label>
            <div class="flex gap-3">
                <button class="btn-primary" type="submit">Create election</button>
                <a href="{{ route('admin.elections.index') }}" class="btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
