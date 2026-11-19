<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $keys = [
            'hero_eyebrow' => 'Hero eyebrow',
            'hero_title_line_1' => 'Hero title line 1',
            'hero_title_line_2' => 'Hero title line 2',
            'hero_description' => 'Hero description',
            'community_eyebrow' => 'Community eyebrow',
            'community_description' => 'Community description',
            'motto' => 'Motto',
            'mission' => 'Mission',
            'glance_intro' => 'Glance intro',
            'contact_email' => 'Contact email',
            'contact_phone' => 'Contact phone',
            'contact_location' => 'Contact location',
            'contact_postal' => 'Contact postal',
            'contact_meeting_venue' => 'Meeting venue',
            'contact_meeting_time' => 'Meeting time',
        ];

        $items = collect($keys)->mapWithKeys(fn ($label, $key) => [
            $key => ['key' => $key, 'label' => $label, 'value' => SiteSetting::get($key, '')],
        ]);

        return view('admin.settings.index', ['settings' => $items]);
    }

    public function update(Request $request): void
    {
        $keys = [
            'hero_eyebrow' => 'Hero eyebrow',
            'hero_title_line_1' => 'Hero title line 1',
            'hero_title_line_2' => 'Hero title line 2',
            'hero_description' => 'Hero description',
            'community_eyebrow' => 'Community eyebrow',
            'community_description' => 'Community description',
            'motto' => 'Motto',
            'mission' => 'Mission',
            'glance_intro' => 'Glance intro',
            'contact_email' => 'Contact email',
            'contact_phone' => 'Contact phone',
            'contact_location' => 'Contact location',
            'contact_postal' => 'Contact postal',
            'contact_meeting_venue' => 'Meeting venue',
            'contact_meeting_time' => 'Meeting time',
        ];

        foreach ($keys as $key => $label) {
            SiteSetting::put($key, (string) ($request->input($key) ?? SiteSetting::get($key, '')), 'content');
        }
    }
}
