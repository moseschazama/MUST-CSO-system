<x-admin-layout title="Leadership" heading="Leadership">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Community</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Leadership</h1>
        </div>
        <a href="{{ route('admin.leaders.create') }}" class="btn-primary btn-sm">New leader</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Role</th>
                    <th class="px-5 py-3">Category</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leaders as $leader)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $leader->name }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $leader->role }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $leader->category }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ $leader->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-5 py-3 text-right"><a href="{{ route('admin.leaders.edit', $leader) }}" class="text-sm font-bold text-brand-700">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">{{ $leaders->links() }}</div>
    </div>
</x-admin-layout>
