@php $member = $member; @endphp
<x-admin-layout title="Member Review" heading="Member Review">
    <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr]">
        <div class="card p-8">
            <h1 class="text-3xl font-extrabold text-ink-900">{{ $member->full_name }}</h1>
            <p class="mt-2 text-ink-500">{{ $member->email }}</p>
            <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                <div><dt class="field-label">Phone</dt><dd class="text-sm text-ink-700">{{ $member->phone }}</dd></div>
                <div><dt class="field-label">School</dt><dd class="text-sm text-ink-700">{{ $member->school }}</dd></div>
                <div><dt class="field-label">Department</dt><dd class="text-sm text-ink-700">{{ $member->department }}</dd></div>
                <div><dt class="field-label">Programme</dt><dd class="text-sm text-ink-700">{{ $member->programme }}</dd></div>
                <div><dt class="field-label">Year</dt><dd class="text-sm text-ink-700">{{ $member->year_of_study }}</dd></div>
                <div><dt class="field-label">Status</dt><dd class="text-sm text-ink-700">{{ $member->status_label }}</dd></div>
                <div><dt class="field-label">Allocation</dt><dd class="text-sm text-ink-700">{{ $member->allocation_label }}</dd></div>
                <div><dt class="field-label">M’Phakati</dt><dd class="text-sm text-ink-700">{{ $member->mphakati ?: '—' }}</dd></div>
                <div><dt class="field-label">Requested group</dt><dd class="text-sm text-ink-700">{{ $member->requested_group ?: '—' }}</dd></div>
                <div><dt class="field-label">Allocation note</dt><dd class="text-sm text-ink-700">{{ $member->allocation_note ?: '—' }}</dd></div>
            </dl>
            <div class="mt-6">
                <p class="field-label">Interests</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($member->interest_labels as $label)
                        <span class="chip">{{ $label }}</span>
                    @endforeach
                </div>
            </div>
            <div class="mt-4">
                <p class="field-label">Preferred activities</p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($member->activity_labels as $label)
                        <span class="chip">{{ $label }}</span>
                    @endforeach
                </div>
            </div>
            @if ($member->motivation)
                <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="field-label">Motivation</p>
                    <p class="text-sm text-ink-700">{{ $member->motivation }}</p>
                </div>
            @endif
            @if ($member->additional_info)
                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="field-label">Additional info</p>
                    <p class="text-sm text-ink-700">{{ $member->additional_info }}</p>
                </div>
            @endif
            @if ($member->review_note)
                <div class="mt-4 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <p class="field-label">Review note</p>
                    <p class="text-sm text-ink-700">{{ $member->review_note }}</p>
                </div>
            @endif
        </div>
        <div class="space-y-6">
            <div class="card p-6">
                <p class="eyebrow">Review</p>
                <form method="POST" action="{{ route('admin.members.approve', $member) }}" class="mt-4 grid gap-3">
                    @csrf
                    <textarea name="review_note" rows="2" placeholder="Approval note (optional)" class="field-textarea"></textarea>
                    <button class="btn-primary" type="submit">Approve</button>
                </form>
                <form method="POST" action="{{ route('admin.members.info', $member) }}" class="mt-3 grid gap-3">
                    @csrf
                    <textarea name="review_note" rows="2" placeholder="Information requested" required class="field-textarea"></textarea>
                    <button class="btn-ghost" type="submit">Request more info</button>
                </form>
                <form method="POST" action="{{ route('admin.members.reject', $member) }}" class="mt-3 grid gap-3">
                    @csrf
                    <textarea name="review_note" rows="2" placeholder="Rejection reason (required)" required class="field-textarea"></textarea>
                    <button class="btn-ghost" type="submit">Reject</button>
                </form>
            </div>
            <div class="card p-6">
                <p class="eyebrow">Allocation</p>
                <form method="POST" action="{{ route('admin.members.allocate', $member) }}" class="mt-4 grid gap-3">
                    @csrf
                    <select name="allocation_status" class="field-select">
                        @foreach (\App\Models\Member::ALLOCATIONS as $key => $label)
                            <option value="{{ $key }}" @selected($member->allocation_status === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <input name="mphakati" value="{{ $member->mphakati }}" placeholder="Assigned M’Phakati" class="field-input">
                    <input name="requested_group" value="{{ $member->requested_group }}" placeholder="Requested group" class="field-input">
                    <textarea name="allocation_note" rows="2" placeholder="Allocation note" class="field-textarea">{{ $member->allocation_note }}</textarea>
                    <button class="btn-primary" type="submit">Save allocation</button>
                </form>
            </div>
            <form method="POST" action="{{ route('admin.members.destroy', $member) }}">
                @csrf
                @method('DELETE')
                <button class="btn-ghost w-full" type="submit">Remove member</button>
            </form>
        </div>
    </div>
</x-admin-layout>