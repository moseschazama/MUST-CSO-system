<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the public homepage.
     */
    public function __invoke(): View
    {
        $upcomingEvents = Event::query()
            ->published()
            ->upcoming()
            ->orderBy('starts_at')
            ->limit(3)
            ->get();

        return view('pages.home', [
            'upcomingEvents' => $upcomingEvents,
        ]);
    }
}
