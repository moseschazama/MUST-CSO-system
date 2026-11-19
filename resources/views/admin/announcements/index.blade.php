<x-admin-layout title="Announcements" heading="Announcements">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Content</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Announcements</h1>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="btn-primary btn-sm">New announcement</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Title</th>
                    <th class="px-5 py-3">Level</th>
                    <th class="px-5 py-3">Published</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($announcements as $announcement)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $announcement->title }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $announcement->level }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $announcement->published_at->format('d M Y H:i') }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ $announcement->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-5 py-3 text-right"><a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-sm font-bold text-brand-700">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">{{ $announcements->links() }}</div>
    </div>
</x-admin-layout>
