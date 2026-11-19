<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\AuditLog;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function create(): View
    {
        return view('membership.create', [
            'options' => $this->options(),
            'member' => Auth::user()?->member,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $academic = config('cso.academic');

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:30',
            'school' => ['required', Rule::in(array_keys($academic['schools']))],
            'department' => 'required|string|max:255',
            'programme' => 'required|string|max:255',
            'year_of_study' => ['required', Rule::in(array_keys($academic['years']))],
            'interests' => 'required|array|min:1',
            'interests.*' => Rule::in(array_keys(Member::INTERESTS)),
            'preferred_activities' => 'nullable|array',
            'preferred_activities.*' => Rule::in(array_keys(Activity::CATEGORIES)),
            'reason' => ['required', Rule::in(array_keys(Member::REASONS))],
            'motivation' => 'nullable|string|max:1000',
            'requested_group' => 'nullable|string|max:255',
            'allocation_choice' => ['nullable', Rule::in(['unallocated', 'requested'])],
            'allocation_note' => 'nullable|string|max:500',
            'consent' => 'accepted',
        ]);

        $school = $academic['schools'][$validated['school']];

        if (! in_array($validated['department'], $school['departments'], true)
            || ! in_array($validated['programme'], $school['programmes'], true)) {
            return back()->withInput()->withErrors([
                'programme' => 'Please choose a department and programme offered by the selected school.',
            ]);
        }

        $user = User::create([
            'name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => Str::password(32),
            'is_admin' => false,
        ]);

        $member = Member::create([
            'user_id' => $user->id,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'programme' => $validated['programme'],
            'department' => $validated['department'],
            'school' => $school['label'],
            'year_of_study' => $validated['year_of_study'],
            'interests' => $validated['interests'],
            'preferred_activities' => $validated['preferred_activities'] ?? [],
            'motivation' => trim(Member::REASONS[$validated['reason']].'. '.($validated['motivation'] ?? '')),
            'requested_group' => $validated['requested_group'] ?? null,
            'allocation_status' => $validated['allocation_choice'] ?? 'unallocated',
            'allocation_note' => $validated['allocation_note'] ?? null,
            'status' => 'pending',
        ]);

        AuditLog::record('created_member', $member, $member->full_name);

        Auth::login($user);

        return redirect()->route('membership.status')->with('success', 'Application received. Our team will review it soon.');
    }

    public function status(): View
    {
        $member = Auth::user()->member;

        abort_unless($member, 404);

        return view('membership.status', [
            'member' => $member,
            'options' => $this->options(),
        ]);
    }

    public function resubmit(Request $request): RedirectResponse
    {
        $member = $request->user()->member;

        abort_unless($member && $member->can_resubmit, 403);

        $validated = $request->validate([
            'phone' => 'required|string|max:30',
            'interests' => 'required|array|min:1',
            'interests.*' => Rule::in(array_keys(Member::INTERESTS)),
            'preferred_activities' => 'nullable|array',
            'preferred_activities.*' => Rule::in(array_keys(Activity::CATEGORIES)),
            'additional_info' => 'required|string|max:1500',
            'requested_group' => 'nullable|string|max:255',
        ]);

        $member->update([
            'phone' => $validated['phone'],
            'interests' => $validated['interests'],
            'preferred_activities' => $validated['preferred_activities'] ?? [],
            'additional_info' => $validated['additional_info'],
            'requested_group' => $validated['requested_group'] ?? $member->requested_group,
            'status' => 'pending',
            'reviewed_at' => null,
        ]);

        AuditLog::record('resubmitted_membership', $member, $member->full_name);

        return redirect()->route('membership.status')->with('success', 'Your updated application is back in the review queue.');
    }

    protected function options(): array
    {
        return [
            'academic' => config('cso.academic'),
            'interests' => Member::INTERESTS,
            'reasons' => Member::REASONS,
            'activities' => Activity::CATEGORIES,
        ];
    }
}
