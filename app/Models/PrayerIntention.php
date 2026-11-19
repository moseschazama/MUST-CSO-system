<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PrayerIntention extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'mass_date' => 'date',
    ];

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }
}
