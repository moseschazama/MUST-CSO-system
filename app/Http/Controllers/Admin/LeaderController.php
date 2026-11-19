<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\Leader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeaderController extends Controller
{
    public function index(): View
    {
        return view('admin.leaders.index', [
            'leaders' => Leader::ordered()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.leaders.create', [
            'leader' => new Leader,
            'categories' => Leader::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'category' => 'required|in:spiritual,executive,past',
            'tenure' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);

        $leader = Leader::create($validated + ['is_published' => $request->boolean('is_published', true)]);

        \App\Models\AuditLog::record('created_leader', $leader, $leader->name);

        return redirect()->route('admin.leaders.index')->with('success', 'Leader created.');
    }

    public function edit(Leader $leader): View
    {
        return view('admin.leaders.edit', [
            'leader' => $leader,
            'categories' => Leader::CATEGORIES,
        ]);
    }

    public function update(Request $request, Leader $leader): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'category' => 'required|in:spiritual,executive,past',
            'tenure' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'photo' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);

        $leader->update($validated + ['is_published' => $request->boolean('is_published', true)]);

        \App\Models\AuditLog::record('updated_leader', $leader, $leader->name);

        return redirect()->route('admin.leaders.index')->with('success', 'Leader updated.');
    }

    /**
     * Publish the winners of a verified election as the current committee.
     */
    public function publishElection(Election $election): RedirectResponse
    {
        if ($election->status !== 'verified') {
            return back()->with('error', 'Verify and declare the election results first.');
        }

        $count = Leader::syncFromElection($election);

        \App\Models\AuditLog::record('published_leadership_from_election', $election, $election->title);

        return back()->with('success', $count.' leadership positions updated from the declared results.');
    }

    public function destroy(Leader $leader): RedirectResponse
    {
        $name = $leader->name;
        $leader->delete();

        \App\Models\AuditLog::record('deleted_leader', $leader, $name);

        return redirect()->route('admin.leaders.index')->with('success', 'Leader deleted.');
    }
}
