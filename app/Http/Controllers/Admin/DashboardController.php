<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Event;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Display the administrator dashboard.
     */
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'upcomingCount' => Event::query()->published()->upcoming()->count(),
            'publishedCount' => Event::query()->published()->count(),
            'unreadCount' => ContactMessage::query()->unread()->count(),
            'recentEvents' => Event::query()
                ->orderByDesc('starts_at')
                ->limit(5)
                ->get(),
            'recentMessages' => ContactMessage::query()
                ->latest()
                ->limit(3)
                ->get(),
        ]);
    }
}
