<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public const CATEGORIES = [
        'mass' => 'Holy Mass & Liturgy',
        'devotion' => 'Devotions & Prayer',
        'meeting' => 'CSO Meetings & Fellowships',
        'outreach' => 'Charity & Outreach',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
