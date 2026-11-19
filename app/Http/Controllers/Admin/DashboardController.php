<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\ContactMessage;
use App\Models\Election;
use App\Models\Event;
use App\Models\GalleryPhoto;
use App\Models\Leader;
use App\Models\Member;
use App\Models\Report;
use App\Models\User;
use App\Models\Vote;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return $this->__invoke();
    }

    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'counts' => [
                'members' => Member::count(),
                'pending_members' => Member::pending()->count(),
                'activities' => Activity::count(),
                'events' => Event::count(),
                'announcements' => Announcement::count(),
                'gallery' => GalleryPhoto::count(),
                'leaders' => Leader::count(),
                'reports' => Report::count(),
                'elections' => Election::count(),
                'votes' => Vote::count(),
                'messages' => ContactMessage::where('is_read', false)->count(),
            ],
            'recent_members' => Member::latest()->take(6)->get(),
            'open_elections' => Election::where('status', 'open')->withCount('positions')->latest('id')->take(5)->get(),
        ]);
    }
}

