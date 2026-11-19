<x-admin-layout title="Activities" heading="Activities">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Content</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Activities</h1>
        </div>
        <a href="{{ route('admin.activities.create') }}" class="btn-primary btn-sm">New activity</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.activities.index') }}" class="card mt-6 flex flex-wrap items-end gap-4 p-5">
        <div class="min-w-56 flex-1">
            <label class="field-label" for="category">Category</label>
            <select id="category" name="category" class="field-select">
                <option value="">All categories</option>
                @foreach ($categories as $key => $label)
                    <option value="{{ $key }}" @selected($category === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn-ghost btn-sm">Filter</button>
    </form>

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Title</th>
                    <th class="px-5 py-3">Category</th>
                    <th class="px-5 py-3">Schedule</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $activity)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $activity->title }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $activity->category }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $activity->day }} &middot; {{ $activity->time }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ $activity->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.activities.edit', $activity) }}" class="text-sm font-bold text-brand-700">Edit</a>
                                <form method="POST" action="{{ route('admin.activities.destroy', $activity) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-bold text-red-600" onclick="return confirm('Delete this activity?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">{{ $activities->links() }}</div>
    </div>
</x-admin-layout>
