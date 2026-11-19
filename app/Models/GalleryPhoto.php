<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    protected $guarded = [];

    protected $casts = [
        'taken_on' => 'date',
        'is_featured' => 'boolean',
        'featured_order' => 'integer',
    ];

    /**
     * Uploaded images take priority; the seeded Drive copies remain the fallback.
     */
    public function getThumbnailAttribute(): string
    {
        return $this->resolveImage();
    }

    public function getFullImageAttribute(): string
    {
        return $this->resolveImage();
    }

    public function getUrlAttribute(): string
    {
        return $this->resolveImage();
    }

    protected function resolveImage(): string
    {
        if ($this->image_path) {
            return str_starts_with($this->image_path, '/')
                ? $this->image_path
                : asset('storage/'.$this->image_path);
        }

        return '/images/gallery/'.$this->drive_file_id.'.jpg';
    }

    public function getCaptionTextAttribute(): string
    {
        return $this->caption ?: (string) $this->alt;
    }

    public function getDriveUrlAttribute(): ?string
    {
        return $this->drive_file_id
            ? 'https://drive.google.com/file/d/'.$this->drive_file_id.'/view'
            : null;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeFeaturedOrdered(Builder $query): Builder
    {
        return $query->featured()->orderBy('featured_order')->orderBy('sort_order');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->published()->orderBy('sort_order')->orderBy('id');
    }
}
