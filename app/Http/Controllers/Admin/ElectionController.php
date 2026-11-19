<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\Leader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ElectionController extends Controller
{
    public function index(): View
    {
        return view('admin.elections.index', [
            'elections' => Election::withCount(['positions', 'votes'])->latest()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.elections.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_id' => 'nullable|exists:events,id',
            'opens_at' => 'required|date',
            'closes_at' => 'required|date|after:opens_at',
            'status' => 'required|in:draft,open',
            'results_published' => 'nullable|boolean',
        ]);

        $election = Election::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'event_id' => $validated['event_id'],
            'opens_at' => $validated['opens_at'],
            'closes_at' => $validated['closes_at'],
            'status' => $validated['status'],
            'results_published' => $validated['results_published'] ?? false,
        ]);

        AuditLog::record('created_election', $election, $election->title);

        return redirect()->route('admin.elections.edit', $election)->with('success', 'Election created.');
    }

    public function edit(Election $election): View
    {
        return view('admin.elections.edit', [
            'election' => $election,
            'positions' => $election->positions,
        ]);
    }

    public function update(Request $request, Election $election): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'event_id' => 'nullable|exists:events,id',
            'opens_at' => 'required|date',
            'closes_at' => 'required|date|after:opens_at',
            'status' => 'required|in:draft,open,closed,verified',
            'results_published' => 'nullable|boolean',
        ]);

        $election->update($validated + [
            'status' => $validated['status'],
            'results_published' => $validated['results_published'] ?? false,
        ]);

        AuditLog::record('updated_election', $election, $election->title);

        return redirect()->route('admin.elections.edit', $election)->with('success', 'Election updated.');
    }

    public function destroy(Election $election): RedirectResponse
    {
        $title = $election->title;
        $election->delete();

        AuditLog::record('deleted_election', $election, $title);

        return redirect()->route('admin.elections.index')->with('success', 'Election deleted.');
    }

    public function open(Election $election): RedirectResponse
    {
        $election->update([
            'status' => 'open',
            'opens_at' => $election->opens_at ?: now(),
            'closes_at' => $election->closes_at ?: now()->addDays(14),
        ]);

        AuditLog::record('opened_election', $election, $election->title);

        return redirect()->route('admin.elections.edit', $election)->with('success', 'Election opened for voting.');
    }

    public function close(Election $election): RedirectResponse
    {
        $election->update(['status' => 'closed']);

        AuditLog::record('closed_election', $election, $election->title);

        return redirect()->route('admin.elections.edit', $election)->with('success', 'Election closed.');
    }

    public function verify(Request $request, Election $election): RedirectResponse
    {
        $validated = $request->validate([
            'results' => 'required|array|min:1',
            'results.*' => 'required|integer|exists:candidates,id',
        ]);

        $candidateIds = array_map('intval', $validated['results']);
        $positions = $election->positions()->with('candidates')->get();

        foreach ($positions as $position) {
            if (array_key_exists((string) $position->id, $validated['results'])) {
                $candidateId = (int) $validated['results'][(string) $position->id];
                $position->winner_candidate_id = $candidateId;
                $position->save();
            }
        }

        $election->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => $request->user()->id,
            'results_published' => $request->boolean('results_published', true),
        ]);

        AuditLog::record('verified_election', $election, $election->title);

        if ($request->boolean('publish_leadership')) {
            $count = Leader::syncFromElection($election);
            AuditLog::record('published_leadership_from_election', $election, $election->title);

            return redirect()->route('admin.elections.edit', $election)
                ->with('success', 'Election verified and '.$count.' leadership positions published.');
        }

        return redirect()->route('admin.elections.edit', $election)->with('success', 'Election verified.');
    }

    public function storePosition(Request $request, Election $election): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $position = $election->positions()->create($validated);

        return redirect()->route('admin.elections.edit', $election)->with('success', 'Position added.');
    }

    public function destroyPosition(ElectionPosition $position): RedirectResponse
    {
        $electionId = $position->election_id;
        $position->delete();

        return redirect()->route('admin.elections.edit', $electionId)->with('success', 'Position deleted.');
    }

    public function storeCandidate(Request $request, ElectionPosition $position): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'member_id' => 'nullable|exists:members,id',
            'bio' => 'nullable|string',
        ]);

        $candidate = Candidate::create($validated);

        return redirect()->route('admin.elections.edit', $candidate->election_position->election_id)->with('success', 'Candidate added.');
    }

    public function destroyCandidate(Candidate $candidate): RedirectResponse
    {
        $positionId = $candidate->election_position_id;
        $candidate->delete();

        return redirect()->route('admin.elections.edit', $positionId)->with('success', 'Candidate removed.');
    }
}
