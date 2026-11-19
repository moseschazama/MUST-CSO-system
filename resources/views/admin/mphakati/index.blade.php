<x-admin-layout title="M'Phakati" heading="M'Phakati">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Community</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">M'Phakati allocation</h1>
            <p class="mt-2 max-w-2xl text-sm text-ink-500">Review every submitted member, see the affiliations they requested, and assign them to a small Christian community.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-ghost btn-sm">Back to dashboard</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.mphakati.index') }}" class="card mt-6 grid gap-4 p-5 sm:grid-cols-4">
        <div>
            <label class="field-label" for="q">Search</label>
            <input id="q" name="q" value="{{ $search }}" placeholder="Name, email or group" class="field-input">
        </div>
        <div>
            <label class="field-label" for="status">Application status</label>
            <select id="status" name="status" class="field-select">
                <option value="">All statuses</option>
                @foreach ($statuses as $key => $label)
                    <option value="{{ $key }}" @selected($status === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="field-label" for="allocation">Allocation</label>
            <select id="allocation" name="allocation" class="field-select">
                <option value="">All allocations</option>
                @foreach ($allocations as $key => $label)
                    <option value="{{ $key }}" @selected($allocation === $key)>{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-ghost btn-sm w-full">Apply filters</button>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.mphakati.bulk') }}" class="card mt-6 overflow-hidden">
        @csrf
        <div class="flex flex-wrap items-end gap-4 border-b border-slate-100 p-5">
            <div class="min-w-56 flex-1">
                <label class="field-label" for="mphakati">Assign selected members to</label>
                <input id="mphakati" name="mphakati" class="field-input" list="mphakati-options" placeholder="e.g. M'Phakati St. Peter" required>
                <datalist id="mphakati-options">
                    @foreach ($groups as $group)
                        <option value="{{ $group }}"></option>
                    @endforeach
                </datalist>
                @error('mphakati')<p class="field-error">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="btn-primary btn-sm">Assign selected</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[64rem] text-left text-sm">
                <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                    <tr>
                        <th class="px-5 py-3"></th>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Status</th>
                        <th class="px-5 py-3">Requested affiliations</th>
                        <th class="px-5 py-3">Preferred group</th>
                        <th class="px-5 py-3">Current M'Phakati</th>
                        <th class="px-5 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($members as $member)
                        <tr class="border-t border-slate-100">
                            <td class="px-5 py-3">
                                <input type="checkbox" name="ids[]" value="{{ $member->id }}" class="h-4 w-4 rounded border-slate-300 text-brand-600">
                            </td>
                            <td class="px-5 py-3 font-semibold text-ink-900">{{ $member->full_name }}</td>
                            <td class="px-5 py-3"><span class="chip">{{ $member->status_label }}</span></td>
                            <td class="px-5 py-3">
                                <div class="flex max-w-xs flex-wrap gap-1">
                                    @forelse (array_unique(array_merge($member->interest_labels, $member->activity_labels)) as $label)
                                        <span class="chip">{{ $label }}</span>
                                    @empty
                                        <span class="text-ink-400">—</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-5 py-3 text-ink-500">{{ $member->requested_group ?: '—' }}</td>
                            <td class="px-5 py-3 text-ink-500">{{ $member->mphakati ?: 'Not allocated' }}</td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.members.show', $member) }}" class="text-sm font-bold text-brand-700">Review</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-8 text-center text-sm text-ink-500">No members match these filters.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-5">{{ $members->links() }}</div>
    </form>
</x-admin-layout>
