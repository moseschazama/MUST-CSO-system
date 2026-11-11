<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    protected $guarded = [];

    /**
     * Thumbnail served from the locally downloaded copy of the Drive photo.
     */
    public function getThumbnailAttribute(): string
    {
        return '/images/gallery/'.$this->drive_file_id.'.jpg';
    }

    public function getFullImageAttribute(): string
    {
        return '/images/gallery/'.$this->drive_file_id.'.jpg';
    }

    public function getDriveUrlAttribute(): string
    {
        return 'https://drive.google.com/file/d/'.$this->drive_file_id.'/view';
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }
}
