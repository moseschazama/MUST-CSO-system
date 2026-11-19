<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Event extends Model
{
    protected $guarded = [];

    public const TYPES = [
        'ordinary' => 'Ordinary event',
        'religious' => 'Religious event',
        'social' => 'Social event',
        'workshop' => 'Workshop',
        'election' => 'Election',
        'other' => 'Other',
    ];

    public const TYPE_ICONS = [
        'ordinary' => 'calendar-days',
        'religious' => 'church',
        'social' => 'party-popper',
        'workshop' => 'graduation-cap',
        'election' => 'vote',
        'other' => 'sparkles',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_featured' => 'boolean',
        'featured_order' => 'integer',
        'registration_enabled' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->published()->where('starts_at', '>=', now()->startOfDay())->orderBy('starts_at');
    }

    public function scopePast(Builder $query): Builder
    {
        return $query->published()->where('starts_at', '<', now()->startOfDay())->orderByDesc('starts_at');
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeFeaturedOrdered(Builder $query): Builder
    {
        return $query->featured()->orderBy('featured_order')->orderBy('starts_at');
    }

    public function election(): HasOne
    {
        return $this->hasOne(Election::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    public function getDayAttribute(): string
    {
        return $this->starts_at->format('d');
    }

    public function getMonthAttribute(): string
    {
        return strtoupper($this->starts_at->format('M'));
    }

    public function getTimeAttribute(): string
    {
        return $this->time_label ?: $this->starts_at->format('g:i A');
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->event_type] ?? 'Ordinary event';
    }

    public function getIsElectionAttribute(): bool
    {
        return $this->event_type === 'election';
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->state_label;
    }

    public function getSummaryAttribute(): ?string
    {
        return $this->description
            ? \Illuminate\Support\Str::limit(strip_tags($this->description), 180)
            : null;
    }

    public function getTypeIconAttribute(): string
    {
        return self::TYPE_ICONS[$this->event_type] ?? 'calendar-days';
    }

    /**
     * upcoming | ongoing | completed — drives the visual treatment of cards.
     */
    public function getStateAttribute(): string
    {
        $now = now();

        if ($this->starts_at->isFuture()) {
            return 'upcoming';
        }

        if ($this->ends_at && $now->lessThan($this->ends_at)) {
            return 'ongoing';
        }

        if (! $this->ends_at && $now->lessThan($this->starts_at->copy()->addHours(3))) {
            return 'ongoing';
        }

        return 'completed';
    }

    public function getStateLabelAttribute(): string
    {
        return match ($this->state) {
            'ongoing' => 'Happening now',
            'completed' => 'Completed',
            default => 'Upcoming',
        };
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

    public function getMapUrlAttribute(): ?string
    {
        $query = $this->map_query ?: $this->venue;

        return $query ? 'https://www.google.com/maps?q='.urlencode($query).'&output=embed' : null;
    }

    public function getMapEmbedUrlAttribute(): ?string
    {
        return $this->map_url;
    }

    public function getIsFullAttribute(): bool
    {
        return $this->capacity !== null
            && $this->registrations()->where('status', '!=', 'cancelled')->count() >= $this->capacity;
    }

    public function userIsRegistered(?User $user): bool
    {
        return $user && $this->registrations()->where('user_id', $user->id)->exists();
    }

    /**
     * Google Calendar "add event" link for the RSVP / calendar button.
     */
    public function getCalendarUrlAttribute(): string
    {
        $end = $this->ends_at ?: $this->starts_at->copy()->addHours(2);

        return 'https://calendar.google.com/calendar/render?action=TEMPLATE'
            .'&text='.urlencode($this->title)
            .'&dates='.$this->starts_at->copy()->utc()->format('Ymd\THis').'/'.$end->copy()->utc()->format('Ymd\THis')
            .'&details='.urlencode((string) $this->description)
            .'&location='.urlencode((string) $this->venue);
    }
}
