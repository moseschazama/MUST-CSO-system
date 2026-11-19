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

    protected $casts = [
        'term_start' => 'date',
        'term_end' => 'date',
    ];

    public function getPhotoUrlAttribute(): ?string
    {
        if (blank($this->photo)) {
            return null;
        }

        return str_starts_with($this->photo, '/') || str_starts_with($this->photo, 'http')
            ? $this->photo
            : asset('storage/'.$this->photo);
    }

    public function getInitialsAttribute(): string
    {
        return collect(preg_split('/\s+/', trim($this->name)))
            ->reject(fn ($part) => in_array(mb_strtolower($part), ['rev.', 'fr.', 'mr.', 'mrs.', 'ms.', 'dr.'], true))
            ->take(2)
            ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
            ->implode('');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->published()->orderBy('sort_order')->orderBy('name');
    }

    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    /**
     * Turn officially declared election winners into published leadership
     * records. Previous executives are archived, never deleted.
     */
    public static function syncFromElection(Election $election): int
    {
        $election->loadMissing('positions.winner');

        $created = 0;
        $termStart = $election->verified_at?->toDateString() ?? now()->toDateString();

        // Retire the outgoing committee but keep its record for the archive.
        static::where('category', 'executive')
            ->whereNull('term_end')
            ->update(['term_end' => $termStart, 'is_published' => false]);

        foreach ($election->positions as $position) {
            if (! $position->winner) {
                continue;
            }

            static::updateOrCreate(
                ['election_position_id' => $position->id],
                [
                    'name' => $position->winner->name,
                    'role' => $position->title,
                    'category' => 'executive',
                    'tenure' => $election->title,
                    'bio' => $position->winner->bio,
                    'photo' => $position->winner->photo,
                    'term_start' => $termStart,
                    'term_end' => null,
                    'sort_order' => $position->sort_order,
                    'is_published' => true,
                ],
            );

            $created++;
        }

        return $created;
    }
}
