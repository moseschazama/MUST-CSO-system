<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Election extends Model
{
    protected $guarded = [];

    public const STATUSES = [
        'draft' => 'Draft',
        'open' => 'Voting open',
        'closed' => 'Voting closed — awaiting verification',
        'verified' => 'Verified / results declared',
    ];

    protected $casts = [
        'opens_at' => 'datetime',
        'closes_at' => 'datetime',
        'verified_at' => 'datetime',
        'results_published' => 'boolean',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function positions(): HasMany
    {
        return $this->hasMany(ElectionPosition::class)->orderBy('sort_order')->orderBy('id');
    }

    public function votes(): HasMany
    {
        return $this->hasMany(Vote::class);
    }

    public function scopeVisible(Builder $query): Builder
    {
        return $query->whereIn('status', ['open', 'closed', 'verified']);
    }

    /**
     * Salted voter fingerprint: proves one vote per member per position
     * without storing who they voted for.
     */
    public static function voterHash(int $memberId, int $positionId): string
    {
        return hash('sha256', $memberId.'-'.$positionId.'-'.config('app.key'));
    }

    public function isOpen(): bool
    {
        return $this->status === 'open'
            && now()->betweenIncluded($this->opens_at, $this->closes_at);
    }

    public function hasEnded(): bool
    {
        return $this->status === 'closed'
            || $this->status === 'verified'
            || ($this->status === 'open' && now()->greaterThan($this->closes_at));
    }
}
