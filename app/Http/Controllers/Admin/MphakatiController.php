<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MphakatiController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');
        $status = $request->query('status');
        $allocation = $request->query('allocation');

        $query = Member::latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('requested_group', 'like', "%{$search}%")
                    ->orWhere('mphakati', 'like', "%{$search}%");
            });
        }

        if ($status && array_key_exists($status, Member::STATUSES)) {
            $query->where('status', $status);
        }

        if ($allocation && array_key_exists($allocation, Member::ALLOCATIONS)) {
            $query->where('allocation_status', $allocation);
        }

        $groups = Member::approved()
            ->whereNotNull('mphakati')
            ->where('mphakati', '<>', '')
            ->orderBy('mphakati')
            ->pluck('mphakati')
            ->unique()
            ->values();

        return view('admin.mphakati.index', [
            'members' => $query->paginate(50)->withQueryString(),
            'groups' => $groups,
            'statuses' => Member::STATUSES,
            'allocations' => Member::ALLOCATIONS,
            'status' => $status,
            'allocation' => $allocation,
            'search' => $search,
        ]);
    }

    public function assign(Request $request, Member $member): RedirectResponse
    {
        $validated = $request->validate([
            'mphakati' => 'required|string|max:255',
            'allocation_status' => ['required', Rule::in(array_keys(Member::ALLOCATIONS))],
        ]);

        $member->update($validated);

        AuditLog::record('allocated_member', $member, $member->full_name);

        return back()->with('success', $member->full_name.' assigned to '.$validated['mphakati'].'.');
    }

    public function bulkAssign(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => ['integer', Rule::exists('members', 'id')],
            'mphakati' => 'required|string|max:255',
        ]);

        $count = Member::whereIn('id', $validated['ids'])->update([
            'mphakati' => $validated['mphakati'],
            'allocation_status' => 'allocated',
        ]);

        AuditLog::record('bulk_allocated_members', null, $count.' members assigned to '.$validated['mphakati']);

        return back()->with('success', $count.' members assigned to '.$validated['mphakati'].'.');
    }
}
