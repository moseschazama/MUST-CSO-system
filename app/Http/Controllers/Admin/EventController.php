<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Election;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        return view('admin.events.index', [
            'events' => Event::withCount('registrations')->latest('starts_at')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.events.create', [
            'event' => new Event,
            'types' => Event::TYPES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateEvent($request);

        $event = Event::create([
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'event_type' => $validated['event_type'],
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'] ?? null,
            'time_label' => $validated['time_label'] ?? null,
            'venue' => $validated['venue'] ?? null,
            'map_query' => $validated['map_query'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $this->storeImage($request) ?? null,
            'video' => $this->storeVideo($request) ?? null,
            'video_thumbnail' => $this->storeVideoThumbnail($request) ?? null,
            'rsvp_url' => $validated['rsvp_url'] ?? null,
            'registration_enabled' => $request->boolean('registration_enabled'),
            'capacity' => $validated['capacity'] ?? null,
            'album' => $validated['album'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'featured_order' => $validated['featured_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
        ]);

        $this->syncElection($request, $event);

        AuditLog::record('created_event', $event, $event->title);

        return redirect()->route('admin.events.index')->with('success', 'Event created.');
    }

    public function edit(Event $event): View
    {
        return view('admin.events.edit', [
            'event' => $event,
            'types' => Event::TYPES,
        ]);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $this->validateEvent($request);

        $event->update([
            'title' => $validated['title'],
            'event_type' => $validated['event_type'],
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'] ?? null,
            'time_label' => $validated['time_label'] ?? null,
            'venue' => $validated['venue'] ?? null,
            'map_query' => $validated['map_query'] ?? null,
            'description' => $validated['description'] ?? null,
            'image' => $this->storeImage($request) ?? $event->image,
            'video' => $this->storeVideo($request) ?? $event->video,
            'video_thumbnail' => $this->storeVideoThumbnail($request) ?? $event->video_thumbnail,
            'rsvp_url' => $validated['rsvp_url'] ?? null,
            'registration_enabled' => $request->boolean('registration_enabled'),
            'capacity' => $validated['capacity'] ?? null,
            'album' => $validated['album'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'featured_order' => $validated['featured_order'] ?? $event->featured_order,
            'is_published' => $request->boolean('is_published'),
        ]);

        $this->syncElection($request, $event);

        AuditLog::record('updated_event', $event, $event->title);

        return redirect()->route('admin.events.index')->with('success', 'Event updated.');
    }

    public function registrations(Event $event): View
    {
        return view('admin.events.registrations', [
            'event' => $event,
            'registrations' => $event->registrations()->latest()->paginate(30),
        ]);
    }

    public function toggleAttended(Event $event, EventRegistration $registration): RedirectResponse
    {
        abort_unless($registration->event_id === $event->id, 404);

        $registration->update(['attended' => ! $registration->attended]);

        return back()->with('success', 'Attendance updated.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $title = $event->title;
        $event->delete();

        AuditLog::record('deleted_event', $event, $title);

        return redirect()->route('admin.events.index')->with('success', 'Event deleted.');
    }

    protected function validateEvent(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'event_type' => 'required|in:'.implode(',', array_keys(Event::TYPES)),
            'starts_at' => 'required|date',
            'ends_at' => 'nullable|date|after:starts_at',
            'time_label' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'map_query' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:4096',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/quicktime|max:51200',
            'video_thumbnail' => 'nullable|image|max:4096',
            'rsvp_url' => 'nullable|url|max:255',
            'featured_order' => 'nullable|integer|min:0',
            'capacity' => 'nullable|integer|min:1',
            'album' => 'nullable|string|max:255',
            'election_opens_at' => 'required_if:event_type,election|nullable|date',
            'election_closes_at' => 'required_if:event_type,election|nullable|date|after:election_opens_at',
            'election_description' => 'nullable|string',
        ]);
    }

    protected function storeImage(Request $request): ?string
    {
        return $request->hasFile('image')
            ? $request->file('image')->store('uploads/events', 'public')
            : null;
    }

    protected function storeVideo(Request $request): ?string
    {
        return $request->hasFile('video')
            ? $request->file('video')->store('uploads/events', 'public')
            : null;
    }

    protected function storeVideoThumbnail(Request $request): ?string
    {
        return $request->hasFile('video_thumbnail')
            ? $request->file('video_thumbnail')->store('uploads/events', 'public')
            : null;
    }

    protected function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $candidate = $slug;
        $i = 1;

        while (Event::where('slug', $candidate)->exists()) {
            $candidate = $slug.'-'.$i++;
        }

        return $candidate;
    }

    protected function syncElection(Request $request, Event $event): void
    {
        if ($event->event_type !== 'election') {
            return;
        }

        Election::updateOrCreate(
            ['event_id' => $event->id],
            [
                'title' => $event->title,
                'description' => $request->input('election_description') ?: $event->description,
                'opens_at' => $request->input('election_opens_at') ?: $event->starts_at,
                'closes_at' => $request->input('election_closes_at') ?: $event->ends_at ?? $event->starts_at->copy()->endOfDay(),
            ],
        );
    }
}
