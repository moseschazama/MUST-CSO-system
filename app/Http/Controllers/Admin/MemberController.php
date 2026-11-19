<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $search = $request->query('q');

        $query = Member::with('user')->latest();

        if ($status && array_key_exists($status, Member::STATUSES)) {
            $query->where('status', $status);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return view('admin.members.index', [
            'members' => $query->paginate(15)->withQueryString(),
            'pending' => Member::pending()->count(),
            'statuses' => Member::STATUSES,
            'status' => $status,
            'search' => $search,
        ]);
    }

    public function show(Member $member): View
    {
        return view('admin.members.show', [
            'member' => $member->load(['user']),
            'statuses' => Member::STATUSES,
            'allocations' => Member::ALLOCATIONS,
        ]);
    }

    public function approve(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate(['review_note' => 'nullable|string|max:500']);

        $member->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'review_note' => $validated['review_note'] ?? null,
        ]);

        AuditLog::record('approved_member', $member, $member->full_name);

        return back()->with('success', 'Member approved.');
    }

    public function reject(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'review_note' => 'required|string|max:500',
        ]);

        $member->update([
            'status' => 'rejected',
            'reviewed_at' => now(),
            'review_note' => $validated['review_note'],
        ]);

        AuditLog::record('rejected_member', $member, $member->full_name);

        return back()->with('success', 'Member rejected with a reason.');
    }

    public function requestInfo(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'review_note' => 'required|string|max:500',
        ]);

        $member->update([
            'status' => 'needs_info',
            'reviewed_at' => now(),
            'review_note' => $validated['review_note'],
        ]);

        AuditLog::record('requested_member_info', $member, $member->full_name);

        return back()->with('success', 'The applicant will be asked to provide more information.');
    }

    public function allocate(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'allocation_status' => 'required|in:'.implode(',', array_keys(Member::ALLOCATIONS)),
            'mphakati' => 'nullable|string|max:255',
            'requested_group' => 'nullable|string|max:255',
            'allocation_note' => 'nullable|string|max:500',
        ]);

        $member->update($validated);

        AuditLog::record('allocated_member', $member, $member->full_name);

        return back()->with('success', 'Membership allocation updated.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $name = $member->full_name;
        $member->delete();

        AuditLog::record('deleted_member', $member, $name);

        return redirect()->route('admin.members.index')->with('success', 'Member removed.');
    }
}
