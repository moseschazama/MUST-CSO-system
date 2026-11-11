<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    protected $guarded = [];

    public const CATEGORIES = [
        'spiritual' => 'Spiritual & Advisory Leadership',
        'executive' => 'Current Executive Committee',
        'past' => 'Past Chairpersons Archive',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }
}
