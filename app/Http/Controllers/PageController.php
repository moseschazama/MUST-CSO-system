<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\GalleryPhoto;
use App\Models\Leader;
use App\Models\Report;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        return view('pages.home', [
            'activities' => Activity::ordered()->take(4)->get(),
            'events' => Event::upcoming()->take(3)->get(),
            'announcements' => Announcement::latestFirst()->take(2)->get(),
            'highlights' => GalleryPhoto::ordered()->inRandomOrder()->take(6)->get(),
            'members' => Leader::category('executive')->ordered()->take(4)->get(),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }

    public function leadership(): View
    {
        return view('pages.leadership', [
            'spiritual' => Leader::category('spiritual')->ordered()->get(),
            'executive' => Leader::category('executive')->ordered()->get(),
            'past' => Leader::category('past')->ordered()->get(),
        ]);
    }

    public function activities(): View
    {
        return view('pages.activities', [
            'activities' => Activity::ordered()->get(),
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

        return view('pages.gallery', [
            'photos' => $photos,
            'categories' => $photos->pluck('category')->unique()->values(),
            'albums' => config('cso.drive.albums'),
            'totalPhotos' => collect(config('cso.drive.albums'))->sum('total'),
        ]);
    }

    public function contact(): View
    {
        return view('pages.contact');
    }
}
