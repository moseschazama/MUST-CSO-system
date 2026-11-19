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

    public function getCoverImageUrlAttribute(): ?string
    {
        if (blank($this->cover_image)) {
            return null;
        }

        if (str_starts_with($this->cover_image, '/') || str_starts_with($this->cover_image, 'http')) {
            return $this->cover_image;
        }

        $local = '/images/gallery/'.$this->cover_image.'.jpg';

        return file_exists(public_path(ltrim($local, '/'))) ? $local : null;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->published()->orderByDesc('activity_date');
    }
}
