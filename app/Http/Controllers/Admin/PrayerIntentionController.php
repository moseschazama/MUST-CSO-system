<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerIntention;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PrayerIntentionController extends Controller
{
    public function index(): View
    {
        return view('admin.prayer-intentions.index', [
            'intentions' => PrayerIntention::latest()->paginate(20),
            'pending' => PrayerIntention::pending()->count(),
        ]);
    }

    public function markPrayed(PrayerIntention $intention): RedirectResponse
    {
        $intention->update(['status' => 'prayed']);

        return back()->with('success', 'Prayer intention marked as prayed.');
    }
}
