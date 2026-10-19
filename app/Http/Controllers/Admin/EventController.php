<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreEventRequest;
use App\Http\Requests\Admin\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display all events for administration.
     */
    public function index(): View
    {
        return view('admin.events.index', [
            'events' => Event::query()
                ->with('creator')
                ->orderByDesc('starts_at')
                ->paginate(12),
        ]);
    }

    /**
     * Show the form for creating an event.
     */
    public function create(): View
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event.
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $event = Event::create($this->eventAttributes(
            $request->validated(),
            $request->user()->id,
        ));

        return redirect()
            ->route('admin.events.index')
            ->with('status', "The event “{$event->title}” was created.");
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event): View
    {
        return view('admin.events.edit', [
            'event' => $event,
        ]);
    }

    /**
     * Update an existing event.
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
        $event->update($this->eventAttributes($request->validated(), null, $event));

        return redirect()
            ->route('admin.events.index')
            ->with('status', "The event “{$event->title}” was updated.");
    }

    /**
     * Delete an event.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $title = $event->title;
        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('status', "The event “{$title}” was deleted.");
    }

    /**
     * Build the attributes used to persist an event.
     *
     * @param  array<string, mixed>  $validated
     * @return array<string, mixed>
     */
    private function eventAttributes(array $validated, ?int $createdById = null, ?Event $event = null): array
    {
        $slugSource = filled($validated['slug'] ?? null)
            ? $validated['slug']
            : $validated['title'];

        $validated['slug'] = $this->uniqueSlug($slugSource, $event);
        $validated['is_published'] = (bool) $validated['is_published'];

        if ($createdById !== null) {
            $validated['created_by_id'] = $createdById;
        }

        return $validated;
    }

    /**
     * Build a unique slug for an event.
     */
    private function uniqueSlug(string $source, ?Event $event = null): string
    {
        $base = Str::slug($source);
        $base = $base !== '' ? $base : 'event';
        $slug = $base;
        $counter = 2;

        while (
            Event::query()
                ->where('slug', $slug)
                ->when($event, fn ($query) => $query->where('id', '!=', $event->id))
                ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
