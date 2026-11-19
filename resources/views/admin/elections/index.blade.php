<x-admin-layout title="Elections" heading="Elections">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Community</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Elections</h1>
        </div>
        <a href="{{ route('admin.elections.create') }}" class="btn-primary btn-sm">New election</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Title</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Event</th>
                    <th class="px-5 py-3">Votes</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($elections as $election)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $election->title }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ $election->status }}</span></td>
                        <td class="px-5 py-3 text-ink-500">{{ $election->event_id }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $election->votes_count }}</td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.elections.edit', $election) }}" class="text-sm font-bold text-brand-700">Manage</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">{{ $elections->links() }}</div>
    </div>
</x-admin-layout>
