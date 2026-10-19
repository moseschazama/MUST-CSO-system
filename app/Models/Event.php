<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'created_by_id',
        'title',
        'slug',
        'excerpt',
        'description',
        'location',
        'starts_at',
        'ends_at',
        'is_published',
        'is_demo',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'is_published' => 'boolean',
            'is_demo' => 'boolean',
        ];
    }

    /**
     * The administrator who created the event.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    /**
     * Limit a query to published events.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    /**
     * Limit a query to events that have not started yet.
     */
    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now());
    }

    /**
     * Limit a query to events that have already started.
     */
    public function scopePast(Builder $query): Builder
    {
        return $query->where('starts_at', '<', now());
    }

    /**
     * A human-readable date/time summary for the event.
     */
    public function scheduleSummary(): string
    {
        $start = $this->starts_at->format('l, j F Y \a\t g:i A');

        if (! $this->ends_at) {
            return $start;
        }

        if ($this->ends_at->isSameDay($this->starts_at)) {
            return $start.' – '.$this->ends_at->format('g:i A');
        }

        return $this->starts_at->format('j M Y, g:i A')
            .' – '
            .$this->ends_at->format('j M Y, g:i A');
    }
}
