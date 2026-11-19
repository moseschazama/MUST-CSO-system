@php
    $member = $member ?? auth()->user()->member;
    $status = $member->status;
@endphp

<x-layouts.app title="Membership status">

    <x-page-hero
        eyebrow="Membership"
        title="Your application status."
        description="Track your membership review and respond if more information is requested."
        image="/images/gallery/1HwaaaeG7vkZBJTMW4tLkPRgazSqq5A3g.jpg"
        breadcrumbs="Membership status"
    />

    <section class="section container-page">
        <div class="mx-auto max-w-3xl">
            <div class="card p-6 sm:p-8">
                <div class="flex flex-wrap items-center gap-3">
                    <h2 class="text-2xl font-extrabold text-ink-900">{{ $member->full_name }}</h2>
                    <span class="chip">{{ \App\Models\Member::STATUSES[$status] ?? ucfirst($status) }}</span>
                </div>

                <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="field-label">Email</dt>
                        <dd class="text-sm text-ink-700">{{ $member->email }}</dd>
                    </div>
                    <div>
                        <dt class="field-label">Phone</dt>
                        <dd class="text-sm text-ink-700">{{ $member->phone }}</dd>
                    </div>
                    <div>
                        <dt class="field-label">School</dt>
                        <dd class="text-sm text-ink-700">{{ $member->school }}</dd>
                    </div>
                    <div>
                        <dt class="field-label">Programme</dt>
                        <dd class="text-sm text-ink-700">{{ $member->programme }} ({{ $member->department }})</dd>
                    </div>
                    <div>
                        <dt class="field-label">Year</dt>
                        <dd class="text-sm text-ink-700">{{ $member->year_of_study }}</dd>
                    </div>
                    <div>
                        <dt class="field-label">Allocation</dt>
                        <dd class="text-sm text-ink-700">{{ \App\Models\Member::ALLOCATIONS[$member->allocation_status] ?? $member->allocation_status }}</dd>
                    </div>
                    <div>
                        <dt class="field-label">M'Phakati</dt>
                        <dd class="text-sm text-ink-700">{{ $member->mphakati ?: 'Not yet assigned' }}</dd>
                    </div>
                </dl>

                @if ($member->review_note)
                    <div class="mt-6 rounded-2xl border border-slate-200 bg-slate-50 p-4">
                        <p class="field-label">Review note</p>
                        <p class="text-sm text-ink-700">{{ $member->review_note }}</p>
                    </div>
                @endif

                @if ($status === 'approved')
                    <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        Your membership is approved. You can now vote in CSO elections.
                    </div>
                @elseif ($status === 'rejected')
                    <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800">
                        Your application was not approved. Please review the note above and resubmit if appropriate.
                    </div>
                @elseif ($status === 'needs_info')
                    <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm font-semibold text-amber-800">
                        The team needs a little more information before deciding. Please update below.
                    </div>
                @else
                    <div class="mt-6 rounded-2xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-800">
                        Your application is in the review queue. We will contact you once a decision is made.
                    </div>
                @endif

                @if ($member->can_resubmit)
                    <form method="POST" action="{{ route('membership.resubmit') }}" class="mt-8 grid gap-5">
                        @csrf
                        <div>
                            <label class="field-label" for="phone">Phone number</label>
                            <input id="phone" name="phone" value="{{ old('phone', $member->phone) }}" required class="field-input">
                            @error('phone')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field-label">What draws you to the community?</label>
                            <div class="grid gap-2 sm:grid-cols-2">
                                @foreach (\App\Models\Member::INTERESTS as $key => $label)
                                    <label class="choice-card">
                                        <input type="checkbox" name="interests[]" value="{{ $key }}" @checked(in_array($key, old('interests', $member->interests ?? []), true)) class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                        <span class="text-sm text-ink-700">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('interests')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field-label">Activities you would like to join (optional)</label>
                            <div class="grid gap-2 sm:grid-cols-2">
                                @foreach (\App\Models\Activity::CATEGORIES as $key => $label)
                                    <label class="choice-card">
                                        <input type="checkbox" name="preferred_activities[]" value="{{ $key }}" @checked(in_array($key, old('preferred_activities', $member->preferred_activities ?? []), true)) class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                        <span class="text-sm text-ink-700">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <label class="field-label" for="requested_group">Preferred M'Phakati (optional)</label>
                            <input id="requested_group" name="requested_group" value="{{ old('requested_group', $member->requested_group) }}" class="field-input">
                        </div>
                        <div>
                            <label class="field-label" for="additional_info">Additional information requested</label>
                            <textarea id="additional_info" name="additional_info" rows="4" required class="field-textarea">{{ old('additional_info', $member->additional_info) }}</textarea>
                            @error('additional_info')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="btn-primary">Resubmit application</button>
                    </form>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
