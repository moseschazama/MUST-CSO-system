<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    protected $casts = [
        'starts_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('starts_at', '>=', now()->startOfDay())->orderBy('starts_at');
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

    /**
     * Google Calendar "add event" link for the RSVP / calendar button.
     */
    public function getCalendarUrlAttribute(): string
    {
        $end = $this->starts_at->copy()->addHours(2);

        return 'https://calendar.google.com/calendar/render?action=TEMPLATE'
            .'&text='.urlencode($this->title)
            .'&dates='.$this->starts_at->format('Ymd\THis').'/'.$end->format('Ymd\THis')
            .'&details='.urlencode((string) $this->description)
            .'&location='.urlencode((string) $this->venue);
    }
}
