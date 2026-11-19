<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    protected $guarded = [];

    public const STATUSES = [
        'pending' => 'Pending review',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
        'needs_info' => 'More information needed',
    ];

    public const ALLOCATIONS = [
        'unallocated' => 'Not yet allocated',
        'requested' => 'Allocation requested',
        'allocated' => 'Allocated to a group',
    ];

    public const INTERESTS = [
        'liturgy' => 'Liturgy & Holy Mass',
        'choir' => 'Choir & music',
        'prayer' => 'Prayer & devotion',
        'scripture' => 'Bible study & scripture',
        'outreach' => 'Charity & outreach',
        'leadership' => 'Leadership & committees',
        'media' => 'Media & communications',
        'events' => 'Events & hospitality',
    ];

    public const REASONS = [
        'faith' => 'To grow in my Catholic faith',
        'community' => 'To belong to a community of Catholic students',
        'service' => 'To serve others through charity and outreach',
        'leadership' => 'To grow in leadership and service',
        'prayer' => 'To pray and worship with fellow students',
        'friendship' => 'To make faithful friends at MUST',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
        'interests' => 'array',
        'preferred_activities' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getAllocationLabelAttribute(): string
    {
        return self::ALLOCATIONS[$this->allocation_status] ?? ucfirst((string) $this->allocation_status);
    }

    public function getInterestLabelsAttribute(): array
    {
        return collect($this->interests ?? [])
            ->map(fn ($key) => self::INTERESTS[$key] ?? $key)
            ->all();
    }

    public function getActivityLabelsAttribute(): array
    {
        return collect($this->preferred_activities ?? [])
            ->map(fn ($key) => Activity::CATEGORIES[$key] ?? $key)
            ->all();
    }

    public function getCanResubmitAttribute(): bool
    {
        return in_array($this->status, ['rejected', 'needs_info'], true);
    }
}
