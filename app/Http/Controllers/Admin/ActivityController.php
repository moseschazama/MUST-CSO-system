<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ActivityController extends Controller
{
    public function choir(Request $request): View
    {
        $request->merge(['category' => 'choir']);

        return $this->index($request);
    }

    public function index(Request $request): View
    {
        $category = $request->query('category');
        $query = Activity::query();

        if ($category && array_key_exists($category, Activity::CATEGORIES)) {
            $query->where('category', $category);
        }

        return view('admin.activities.index', [
            'activities' => $query->ordered()->paginate(15)->withQueryString(),
            'categories' => Activity::CATEGORIES,
            'category' => $category,
        ]);
    }

    public function create(): View
    {
        return view('admin.activities.create', [
            'activity' => new Activity,
            'categories' => Activity::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateActivity($request);

        $activity = Activity::create($this->payload($request, $validated));

        AuditLog::record('created_activity', $activity, $activity->title);

        return redirect()->route('admin.activities.index')->with('success', 'Activity created.');
    }

    public function edit(Activity $activity): View
    {
        return view('admin.activities.edit', [
            'activity' => $activity,
            'categories' => Activity::CATEGORIES,
        ]);
    }

    public function update(Request $request, Activity $activity): RedirectResponse
    {
        $validated = $this->validateActivity($request);

        $activity->update($this->payload($request, $validated, $activity));

        AuditLog::record('updated_activity', $activity, $activity->title);

        return redirect()->route('admin.activities.index')->with('success', 'Activity updated.');
    }

    public function destroy(Activity $activity): RedirectResponse
    {
        $title = $activity->title;
        $activity->delete();

        AuditLog::record('deleted_activity', $activity, $title);

        return redirect()->route('admin.activities.index')->with('success', 'Activity deleted.');
    }

    protected function validateActivity(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:'.implode(',', array_keys(Activity::CATEGORIES)),
            'day' => 'nullable|string|max:255',
            'time' => 'nullable|string|max:255',
            'venue' => 'nullable|string|max:255',
            'summary' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'album' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:4096',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/quicktime|max:51200',
            'video_thumbnail' => 'nullable|image|max:4096',
            'sort_order' => 'nullable|integer|min:0',
            'featured_order' => 'nullable|integer|min:0',
        ]);
    }

    protected function payload(Request $request, array $validated, ?Activity $activity = null): array
    {
        $image = $request->hasFile('image')
            ? $request->file('image')->store('uploads/activities', 'public')
            : $activity?->image;

        $video = $request->hasFile('video')
            ? $request->file('video')->store('uploads/activities', 'public')
            : $activity?->video;

        $videoThumbnail = $request->hasFile('video_thumbnail')
            ? $request->file('video_thumbnail')->store('uploads/activities', 'public')
            : $activity?->video_thumbnail;

        return [
            'title' => $validated['title'],
            'slug' => $activity?->slug ?: $this->uniqueSlug($validated['title']),
            'category' => $validated['category'],
            'day' => $validated['day'] ?? null,
            'time' => $validated['time'] ?? null,
            'venue' => $validated['venue'] ?? null,
            'summary' => $validated['summary'] ?? null,
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? null,
            'album' => $validated['album'] ?? null,
            'image' => $image,
            'video' => $video,
            'video_thumbnail' => $videoThumbnail,
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'featured_order' => $validated['featured_order'] ?? 0,
            'is_published' => $request->boolean('is_published'),
        ];
    }

    protected function uniqueSlug(string $title): string
    {
        $slug = Str::slug($title);
        $candidate = $slug;
        $i = 1;

        while (Activity::where('slug', $candidate)->exists()) {
            $candidate = $slug.'-'.$i++;
        }

        return $candidate;
    }
}
