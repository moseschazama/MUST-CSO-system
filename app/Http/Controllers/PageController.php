<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\GalleryPhoto;
use App\Models\Leader;
use App\Models\Member;
use App\Models\Report;
use App\Services\CatholicDailyReflectionService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function home(CatholicDailyReflectionService $dailyReflections): View
    {
        $featuredActivities = Activity::published()->featuredOrdered()->get()->unique('title')->take(4);
        $fallbackActivities = Activity::published()->ordered()->get()->unique('title')->take(4);
        $featuredEvents = Event::upcoming()->featured()->orderBy('featured_order')->take(3)->get();
        $featuredNews = Announcement::published()->featuredOrdered()->take(2)->get();

        return view('pages.home', [
            'activities' => $featuredActivities->isNotEmpty() ? $featuredActivities : $fallbackActivities,
            'events' => $featuredEvents->isNotEmpty() ? $featuredEvents : Event::upcoming()->take(3)->get(),
            'announcements' => $featuredNews->isNotEmpty() ? $featuredNews : Announcement::latestFirst()->take(2)->get(),
            'members' => $this->uniqueLeaders(Leader::category('executive')->ordered()->get())->take(4),
            'reflectionToday' => $dailyReflections->today(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function leadership(): View
    {
        $groups = Member::approved()
            ->whereNotNull('mphakati')
            ->where('mphakati', '<>', '')
            ->orderBy('mphakati')
            ->get()
            ->groupBy('mphakati')
            ->map(fn ($members, $name) => [
                'name' => $name,
                'count' => $members->count(),
            ])
            ->values();

        return view('pages.leadership', [
            'spiritual' => $this->uniqueLeaders(Leader::category('spiritual')->ordered()->get()),
            'executive' => $this->uniqueLeaders(Leader::category('executive')->ordered()->get()),
            'past' => $this->uniqueLeaders(Leader::category('past')->ordered()->get()),
            'groups' => $groups,
        ]);
    }

    public function activities(): View
    {
        return view('pages.activities', [
            'activities' => Activity::published()->ordered()->get()->unique('title')->values(),
            'categories' => Activity::CATEGORIES,
        ]);
    }

    public function news(): View
    {
        return view('pages.news', [
            'events' => Event::upcoming()->get(),
            'announcements' => Announcement::latestFirst()->get(),
            'reports' => Report::latestFirst()->get(),
        ]);
    }

    public function gallery(): View
    {
        $photos = GalleryPhoto::ordered()->get();

        $photoAlbums = $photos->groupBy('album')->map(function ($group, $album) {
            return [
                'name' => $album,
                'label' => $group->first()->album_description ?: $album,
                'category' => $group->first()->category,
                'photos' => $group->take(3)->values(),
                'count' => $group->count(),
                'anchor' => 'album-'.Str::slug($album),
            ];
        })->values();

        return view('pages.gallery', [
            'photos' => $photos,
            'categories' => $photos->pluck('category')->unique()->values(),
            'photoAlbums' => $photoAlbums,
            'featuredPhotos' => GalleryPhoto::published()->featuredOrdered()->take(6)->get(),
        ]);
    }

    public function dailyReadings(Request $request, CatholicDailyReflectionService $dailyReflections): View
    {
        $requested = $dailyReflections->normalizeDate($request->query('date'));
        $selectedDate = $requested ?? $dailyReflections->todayDateString();

        return view('pages.daily-readings', [
            'reflection' => $dailyReflections->get($selectedDate),
            'reflectionHistory' => $dailyReflections->recentHistory(10),
            'todayDate' => $dailyReflections->todayDateString(),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    protected function uniqueLeaders($leaders)
    {
        return $leaders->unique(fn ($leader) => mb_strtolower($leader->name.'|'.$leader->role))->values();
    }
}
