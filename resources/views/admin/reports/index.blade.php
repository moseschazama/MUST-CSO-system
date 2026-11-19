<x-admin-layout title="Reports" heading="Reports">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Content</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Reports</h1>
        </div>
        <a href="{{ route('admin.reports.create') }}" class="btn-primary btn-sm">New report</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Title</th>
                    <th class="px-5 py-3">Date</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $report->title }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $report->activity_date->format('d M Y') }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ $report->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-5 py-3 text-right"><a href="{{ route('admin.reports.edit', $report) }}" class="text-sm font-bold text-brand-700">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">{{ $reports->links() }}</div>
    </div>
</x-admin-layout>
