<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Activity extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public const CATEGORIES = [
        'mass' => 'Holy Mass & Liturgy',
        'devotion' => 'Devotions & Prayer',
        'meeting' => 'CSO Meetings & Fellowships',
        'outreach' => 'Charity & Outreach',
        'choir' => 'Choir & Music',
    ];

    public const CATEGORY_ICONS = [
        'mass' => 'church',
        'devotion' => 'sunrise',
        'meeting' => 'users',
        'outreach' => 'heart-handshake',
        'choir' => 'music',
    ];

    protected static function booted(): void
    {
        static::saving(function (Activity $activity) {
            if (blank($activity->slug)) {
                $activity->slug = Str::slug($activity->title);
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeFeaturedOrdered(Builder $query): Builder
    {
        return $query->featured()->orderBy('featured_order')->orderBy('sort_order');
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? 'CSO activity';
    }

    public function getCategoryIconAttribute(): string
    {
        return self::CATEGORY_ICONS[$this->category] ?? 'calendar-days';
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

    public function getVideoUrlAttribute(): ?string
    {
        if (! $this->video) {
            return null;
        }

        return str_starts_with($this->video, '/') || str_starts_with($this->video, 'http')
            ? $this->video
            : asset('storage/'.$this->video);
    }

    public function getVideoThumbnailUrlAttribute(): ?string
    {
        if (! $this->video_thumbnail) {
            return $this->image_url;
        }

        return str_starts_with($this->video_thumbnail, '/') || str_starts_with($this->video_thumbnail, 'http')
            ? $this->video_thumbnail
            : asset('storage/'.$this->video_thumbnail);
    }

    /**
     * Photos tagged with the same album, used on the activity detail page.
     */
    public function photos(): HasMany
    {
        return $this->hasMany(GalleryPhoto::class, 'album', 'album')
            ->where('is_published', true)
            ->orderBy('sort_order');
    }
}
