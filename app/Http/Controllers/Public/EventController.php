<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Election;
use App\Models\ElectionPosition;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\Member;
use App\Models\Vote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type');
        $when = $request->query('when', 'upcoming');

        $query = Event::published()->withCount('registrations');

        if ($type && array_key_exists($type, Event::TYPES)) {
            $query->where('event_type', $type);
        }

        if ($when === 'past') {
            $query->where('starts_at', '<', now()->startOfDay())->orderByDesc('starts_at');
        } else {
            $query->where('starts_at', '>=', now()->startOfDay())->orderBy('starts_at');
        }

        return view('events.index', [
            'events' => $query->get(),
            'featured' => Event::published()->featuredOrdered()
                ->where('starts_at', '>=', now()->startOfDay())
                ->first(),
            'types' => Event::TYPES,
            'type' => $type,
            'when' => $when,
        ]);
    }

    public function show(Event $event): View
    {
        abort_unless($event->is_published || optional(auth()->user())->is_admin, 404);

        $event->load(['election.positions.candidates', 'registrations']);

        $user = auth()->user();
        $member = $user?->member;
        $election = $event->election;

        $ballot = collect();
        $canVote = false;

        if ($election && $event->event_type === 'election' && $election->isOpen()) {
            if ($user && $member && $member->status === 'approved' && ! $user->is_admin) {
                $ballot = $election->positions()->with('candidates')->get()
                    ->reject(fn (ElectionPosition $position) => $position->votes()
                        ->where('voter_hash', Election::voterHash($member->id, $position->id))
                        ->exists())
                    ->values();
                $canVote = $ballot->isNotEmpty();
            }
        }

        $results = null;
        if ($election && $election->status === 'verified') {
            $results = $election->positions()->with('winner')->get()->map(fn (ElectionPosition $position) => [
                'position' => $position,
                'rows' => $position->results(),
            ]);
        }

        return view('events.show', [
            'event' => $event,
            'election' => $election,
            'ballot' => $ballot,
            'canVote' => $canVote,
            'results' => $results,
            'registered' => $user ? $event->userIsRegistered($user) : false,
            'related' => Event::published()
                ->whereKeyNot($event->id)
                ->where('starts_at', '>=', now()->startOfDay())
                ->orderBy('starts_at')
                ->take(3)
                ->get(),
        ]);
    }

    public function register(Request $request, Event $event): RedirectResponse
    {
        abort_unless($event->is_published, 404);

        if (! $event->registration_enabled) {
            return back()->with('error', 'This event is not taking registrations.');
        }

        if ($event->is_full) {
            return back()->with('error', 'This event is already full.');
        }

        $user = $request->user();

        if ($event->userIsRegistered($user)) {
            return back()->with('error', 'You are already registered for this event.');
        }

        $validated = $request->validate([
            'phone' => 'nullable|string|max:30',
            'notes' => 'nullable|string|max:500',
        ]);

        EventRegistration::create([
            'event_id' => $event->id,
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $validated['phone'] ?? $user->phone,
            'notes' => $validated['notes'] ?? null,
        ]);

        AuditLog::record('registered_for_event', $event, $event->title);

        return back()->with('success', 'You are registered. We will see you there!');
    }

    public function vote(Request $request, Event $event): RedirectResponse
    {
        $election = $event->election;

        abort_unless($event->event_type === 'election' && $election, 404);

        $user = $request->user();
        $member = $user?->member;

        if (! $user || ! $member || $member->status !== 'approved' || $user->is_admin) {
            return back()->with('error', 'Only approved CSO members can vote.');
        }

        if (! $election->isOpen()) {
            return back()->with('error', 'Voting is not open right now.');
        }

        $validated = $request->validate([
            'position_id' => 'required|integer',
            'candidate_id' => 'required|integer|exists:candidates,id',
        ]);

        $position = $election->positions()->findOrFail($validated['position_id']);

        $candidate = $position->candidates()->whereKey($validated['candidate_id'])->first();

        if (! $candidate) {
            return back()->with('error', 'That candidate is not standing for this position.');
        }

        $voterHash = Election::voterHash($member->id, $position->id);

        if ($position->votes()->where('voter_hash', $voterHash)->exists()) {
            return back()->with('error', 'You have already voted for '.$position->title.'.');
        }

        $vote = Vote::create([
            'election_id' => $election->id,
            'election_position_id' => $position->id,
            'candidate_id' => $candidate->id,
            'voter_hash' => $voterHash,
        ]);

        AuditLog::record('cast_election_vote', $vote, $election->title.' - '.$position->title);

        return back()->with('success', 'Your vote for '.$position->title.' was recorded.');
    }
}
