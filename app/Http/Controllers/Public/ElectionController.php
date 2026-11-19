<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\Member;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ElectionController extends Controller
{
    public function index(): View
    {
        return view('elections.index', [
            'elections' => Election::visible()->withCount('positions')->latest('id')->get(),
        ]);
    }

    public function show(Election $election): View
    {
        $user = auth()->user();
        $member = $user?->member;
        $canVote = false;
        $position = null;

        if ($election->isOpen() && $member && $member->status === 'approved' && ! $user?->is_admin) {
            $position = $election->positions()->get()->first(function (ElectionPosition $p) use ($member) {
                return ! $p->votes()->where('voter_hash', hash('sha256', $member->id.'-'.$p->id.'-'.config('app.key')))->exists();
            });
            $canVote = (bool) $position;
        }

        $results = null;
        if ($election->status === 'verified') {
            $results = $election->positions()->with(['candidates' => fn ($q) => $q->withCount('votes')])->get()
                ->map(fn (ElectionPosition $p) => [
                    'position' => $p,
                    'results' => $p->candidates()->withCount('votes')->get()
                        ->map(fn (Candidate $c) => ['candidate' => $c, 'votes' => $c->votes_count])
                        ->sortByDesc('votes')
                        ->values()
                        ->all(),
                ]);
        }

        return view('elections.show', [
            'election' => $election,
            'positions' => $election->positions,
            'canVote' => $canVote,
            'position' => $position,
            'results' => $results,
        ]);
    }

    public function vote(Request $request, Election $election, $positionId): RedirectResponse
    {
        $user = $request->user();
        $member = $user?->member;

        if (! $user || ! $member || $member->status !== 'approved' || $user->is_admin) {
            return redirect()->route('elections.index')->with('error', 'You must be an approved CSO member to vote.');
        }

        $electionPosition = $election->positions()->findOrFail($positionId);

        if (! $election->isOpen()) {
            return redirect()->back()->with('error', 'This election is not accepting votes right now.');
        }

        $voterHash = Election::voterHash($member->id, $electionPosition->id);

        if ($electionPosition->votes()->where('voter_hash', $voterHash)->exists()) {
            return redirect()->back()->with('error', 'You have already cast one vote for this position.');
        }

        $candidateId = $request->validate(['candidate_id' => 'required|exists:candidates,id'])['candidate_id'];

        if (! $electionPosition->candidates()->whereKey($candidateId)->exists()) {
            return back()->with('error', 'That candidate is not standing for this position.');
        }

        $vote = Vote::create([
            'election_id' => $election->id,
            'election_position_id' => $electionPosition->id,
            'candidate_id' => $candidateId,
            'voter_hash' => $voterHash,
        ]);

        AuditLog::record('cast_election_vote', $vote, $election->title.' - '.$electionPosition->title);

        return redirect()->route('elections.show', $election)->with('success', 'Your vote was recorded.');
    }
}
