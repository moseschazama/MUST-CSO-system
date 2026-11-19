@php
    $options = $options ?? [];
    $academic = $options['academic'] ?? config('cso.academic');
    $interests = $options['interests'] ?? \App\Models\Member::INTERESTS;
    $reasons = $options['reasons'] ?? \App\Models\Member::REASONS;
    $activities = $options['activities'] ?? \App\Models\Activity::CATEGORIES;
    $member = $member ?? null;
@endphp

<x-layouts.app title="Join MUST CSO" description="Apply for membership of the MUST Catholic Students Organization.">

    <x-page-hero
        eyebrow="Membership"
        title="Become part of MUST CSO."
        description="A short, smart application. Our team reviews every submission before approving voting and committee access."
        image="/images/gallery/184Ma38wispWoO70dWh1b6Y0tqEEQbdM9.jpg"
        breadcrumbs="Join"
    />

    <section class="section container-page">
        <div class="mx-auto max-w-4xl">
            <div class="card p-6 sm:p-10">
                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <p class="font-bold">Please fix the highlighted fields.</p>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('join.submit') }}" class="grid gap-8">
                    @csrf

                    <script type="application/json" id="academic-data">@json($academic['schools'])</script>

                    <div>
                        <p class="eyebrow">Personal details</p>
                        <div class="mt-4 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="field-label" for="full_name">Full name</label>
                                <input id="full_name" name="full_name" value="{{ old('full_name', $member?->full_name) }}" required class="field-input">
                                @error('full_name')<p class="field-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="field-label" for="email">Email</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $member?->email) }}" required class="field-input">
                                @error('email')<p class="field-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="field-label" for="phone">Phone number</label>
                                <input id="phone" name="phone" value="{{ old('phone', $member?->phone) }}" required class="field-input">
                                @error('phone')<p class="field-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <p class="mt-4 text-xs text-ink-500">No password needed — you will be signed in automatically when you apply.</p>
                    </div>

                    <div>
                        <p class="eyebrow">Academic profile</p>
                        <div class="mt-4 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="field-label" for="school">School</label>
                                <select id="school" name="school" data-school-select required class="field-select">
                                    <option value="" disabled selected>Choose school</option>
                                    @foreach ($academic['schools'] as $key => $school)
                                        <option value="{{ $key }}" @selected(old('school') === $key)>{{ $school['label'] }}</option>
                                    @endforeach
                                </select>
                                @error('school')<p class="field-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="field-label" for="department">Department</label>
                                <select id="department" name="department" data-department-select required class="field-select">
                                    <option value="" disabled selected>Choose a school first</option>
                                </select>
                                @error('department')<p class="field-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="field-label" for="programme">Programme</label>
                                <select id="programme" name="programme" data-programme-select required class="field-select">
                                    <option value="" disabled selected>Choose a school first</option>
                                </select>
                                @error('programme')<p class="field-error">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="field-label" for="year_of_study">Year of study</label>
                                <select id="year_of_study" name="year_of_study" required class="field-select">
                                    <option value="" disabled selected>Choose year</option>
                                    @foreach ($academic['years'] as $key => $label)
                                        <option value="{{ $key }}" @selected(old('year_of_study') === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('year_of_study')<p class="field-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="eyebrow">Affiliations & interests</p>
                        <div class="mt-4 grid gap-5">
                            <div>
                                <label class="field-label">What draws you to the community? (select all that apply)</label>
                                <div class="grid gap-2 sm:grid-cols-2">
                                    @foreach ($interests as $key => $label)
                                        <label class="choice-card">
                                            <input type="checkbox" name="interests[]" value="{{ $key }}" @checked(in_array($key, old('interests', []), true)) class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                            <span class="text-sm text-ink-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('interests')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="field-label">Activities you would like to join (optional)</label>
                                <div class="grid gap-2 sm:grid-cols-2">
                                    @foreach ($activities as $key => $label)
                                        <label class="choice-card">
                                            <input type="checkbox" name="preferred_activities[]" value="{{ $key }}" @checked(in_array($key, old('preferred_activities', []), true)) class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                                            <span class="text-sm text-ink-700">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div>
                                <label class="field-label" for="reason">Why do you want to join?</label>
                                <select id="reason" name="reason" required class="field-select">
                                    <option value="" disabled selected>Choose a reason</option>
                                    @foreach ($reasons as $key => $label)
                                        <option value="{{ $key }}" @selected(old('reason') === $key)>{{ $label }}</option>
                                    @endforeach
                                </select>
                                @error('reason')<p class="field-error">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="field-label" for="motivation">Anything else you would like the team to know? (optional)</label>
                                <textarea id="motivation" name="motivation" rows="3" class="field-textarea">{{ old('motivation') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div>
                        <p class="eyebrow">M'Phakati allocation</p>
                        <p class="mt-2 text-sm text-ink-500">M'Phakati are the small Christian communities within MUST CSO. Choose how you would like to be placed.</p>
                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            <label class="choice-card">
                                <input type="radio" name="allocation_choice" value="unallocated" @checked(old('allocation_choice', 'unallocated') === 'unallocated') class="mt-0.5 h-4 w-4 text-brand-600 focus:ring-brand-500">
                                <div>
                                    <span class="text-sm font-semibold text-ink-900">Not yet allocated</span>
                                    <p class="mt-0.5 text-xs text-ink-500">Let the team place me in a M'Phakati.</p>
                                </div>
                            </label>
                            <label class="choice-card">
                                <input type="radio" name="allocation_choice" value="requested" @checked(old('allocation_choice') === 'requested') class="mt-0.5 h-4 w-4 text-brand-600 focus:ring-brand-500">
                                <div>
                                    <span class="text-sm font-semibold text-ink-900">Request a specific group</span>
                                    <p class="mt-0.5 text-xs text-ink-500">I have a preferred M'Phakati in mind.</p>
                                </div>
                            </label>
                        </div>
                        <div class="mt-4 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label class="field-label" for="requested_group">Preferred M'Phakati (optional)</label>
                                <input id="requested_group" name="requested_group" value="{{ old('requested_group') }}" class="field-input" placeholder="e.g. M'Phakati name">
                            </div>
                            <div>
                                <label class="field-label" for="allocation_note">Notes for the allocation team (optional)</label>
                                <input id="allocation_note" name="allocation_note" value="{{ old('allocation_note') }}" class="field-input">
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-200/70 bg-slate-50/70 p-4">
                        <label class="flex items-start gap-3">
                            <input type="checkbox" name="consent" value="1" required class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                            <span class="text-sm text-ink-700">
                                I confirm the details above are accurate and that I am a student at the Malawi University of Science and Technology.
                            </span>
                        </label>
                        @error('consent')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <p class="text-xs text-ink-500">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-brand-700 hover:text-brand-800">Sign in</a></p>
                        <button type="submit" class="btn-primary">Submit application</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
