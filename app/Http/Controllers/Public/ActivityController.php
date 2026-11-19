<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Event;
use App\Models\GalleryPhoto;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function index(): View
    {
        return view('activities.index', [
            'activities' => Activity::published()
                ->orderByDesc('is_featured')
                ->orderBy('featured_order')
                ->orderBy('sort_order')
                ->get()
                ->unique('title')
                ->values(),
            'categories' => Activity::CATEGORIES,
        ]);
    }

    public function show(Activity $activity): View
    {
        abort_unless($activity->is_published || optional(auth()->user())->is_admin, 404);

        return view('activities.show', [
            'activity' => $activity,
            'photos' => $activity->album
                ? GalleryPhoto::published()->where('album', $activity->album)->take(6)->get()
                : collect(),
            'related' => Activity::published()->where('category', $activity->category)
                ->whereKeyNot($activity->id)->ordered()->take(3)->get(),
            'events' => Event::published()->where('starts_at', '>=', now()->startOfDay())
                ->orderBy('starts_at')->take(2)->get(),
        ]);
    }
}
