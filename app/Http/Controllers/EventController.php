<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Contracts\View\View;

class EventController extends Controller
{
    /**
     * Display published events.
     */
    public function index(): View
    {
        return view('events.index', [
            'upcomingEvents' => Event::query()
                ->published()
                ->upcoming()
                ->orderBy('starts_at')
                ->get(),
            'pastEvents' => Event::query()
                ->published()
                ->past()
                ->orderByDesc('starts_at')
                ->limit(9)
                ->get(),
        ]);
    }

    /**
     * Display a published event.
     */
    public function show(Event $event): View
    {
        abort_unless($event->is_published, 404);

        return view('events.show', [
            'event' => $event,
        ]);
    }
}
