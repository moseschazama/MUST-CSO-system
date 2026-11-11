<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $guarded = [];

    protected $casts = [
        'activity_date' => 'date',
        'highlights' => 'array',
    ];

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('activity_date');
    }
}
