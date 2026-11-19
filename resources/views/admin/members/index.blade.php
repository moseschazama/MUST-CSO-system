<x-admin-layout title="Members" heading="Members">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Community</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Members</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-ghost btn-sm">Back to dashboard</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $member->full_name }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $member->email }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ $member->status }}</span></td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('admin.members.show', $member) }}" class="text-sm font-bold text-brand-700">Review</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">{{ $members->links() }}</div>
    </div>
</x-admin-layout>
