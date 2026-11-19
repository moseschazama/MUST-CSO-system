<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $guarded = [];

    public static function defaults(): array
    {
        return [
            'hero_eyebrow' => 'MALAWI UNIVERSITY OF SCIENCE AND TECHNOLOGY &bull; CATHOLIC STUDENTS',
            'hero_title_line_1' => 'Faith, Fellowship & Service',
            'hero_title_line_2' => 'for MUST Catholic Students',
            'hero_description' => 'Welcome to the MUST Catholic Students Organization. Growing together in Christ through Holy Mass, morning devotion, leadership, and campus charity.',
            'community_eyebrow' => 'Every Student, One Community',
            'community_description' => 'No more searching for where to belong. MUST CSO unites Catholic students into one seamless family - worship, fellowship and service, all in one place, giving you the community and support you need to thrive on campus.',
            'motto' => config('cso.org.motto'),
            'mission' => config('cso.org.mission'),
            'glance_intro' => "MUST CSO unites Catholic students across campus through M'Phakatis (small Christian groups), affiliations like the choir and CCJI, and a growing family of students walking together in faith, fellowship and service.",
            'contact_email' => config('cso.contact.email'),
            'contact_phone' => config('cso.contact.phone'),
            'contact_location' => config('cso.contact.location'),
            'contact_postal' => config('cso.contact.postal'),
            'contact_meeting_venue' => config('cso.contact.meeting_venue'),
            'contact_meeting_time' => config('cso.contact.meeting_time'),
        ];
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $fallback = $default ?? (static::defaults()[$key] ?? null);

        return Cache::store('file')->rememberForever('site-setting:'.$key, function () use ($key, $fallback) {
            return static::query()->where('key', $key)->value('value') ?? $fallback;
        });
    }

    public static function put(string $key, ?string $value, string $group = 'general'): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        Cache::store('file')->forget('site-setting:'.$key);
    }
}
