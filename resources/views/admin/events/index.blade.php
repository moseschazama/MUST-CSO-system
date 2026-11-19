<x-admin-layout title="Events" heading="Events">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Content</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Events</h1>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn-primary btn-sm">New event</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Title</th>
                    <th class="px-5 py-3">Starts</th>
                    <th class="px-5 py-3">Venue</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($events as $event)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $event->title }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $event->starts_at->format('d M Y H:i') }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $event->venue }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ $event->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-5 py-3 text-right"><a href="{{ route('admin.events.edit', $event) }}" class="text-sm font-bold text-brand-700">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">{{ $events->links() }}</div>
    </div>
</x-admin-layout>
