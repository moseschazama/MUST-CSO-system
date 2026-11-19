<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Announcement extends Model
{
    protected $guarded = [];

    public const CATEGORIES = [
        'news' => 'News',
        'announcement' => 'Announcement',
        'academic' => 'Academic',
        'spiritual' => 'Spiritual life',
        'community' => 'Community',
        'choir' => 'Choir & music',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'featured_order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Announcement $announcement) {
            if (blank($announcement->slug)) {
                $slug = Str::slug($announcement->title);
                $exists = static::where('slug', $slug)
                    ->when($announcement->exists, fn ($q) => $q->whereKeyNot($announcement->getKey()))
                    ->exists();

                $announcement->slug = $exists ? $slug.'-'.Str::lower(Str::random(5)) : $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where('published_at', '<=', now());
    }

    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->published()->orderByDesc('published_at');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeFeaturedOrdered(Builder $query): Builder
    {
        return $query->featured()->orderBy('featured_order')->orderByDesc('published_at');
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    public function getExcerptTextAttribute(): string
    {
        return $this->excerpt ?: Str::limit(strip_tags((string) $this->body), 160);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (! $this->image) {
            return null;
        }

        return str_starts_with($this->image, '/') || str_starts_with($this->image, 'http')
            ? $this->image
            : asset('storage/'.$this->image);
    }

    public function getIsAnnouncementAttribute(): bool
    {
        return $this->category === 'announcement' || $this->level !== 'info';
    }
}
