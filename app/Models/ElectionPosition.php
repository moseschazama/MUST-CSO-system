<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ElectionPosition extends Model
{
    protected $guarded = [];

    public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }

    public function candidates(): HasMany
    {
        return $this->hasMany(Candidate::class)->orderBy('name');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(Candidate::class, 'winner_candidate_id');
    }

    public function results(): array
    {
        return $this->candidates()
            ->withCount('votes')
            ->get()
            ->map(fn (Candidate $candidate) => [
                'candidate' => $candidate,
                'votes' => $candidate->votes_count,
            ])
            ->sortByDesc('votes')
            ->values()
            ->all();
    }
}
