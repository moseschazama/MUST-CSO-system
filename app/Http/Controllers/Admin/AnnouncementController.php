<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\AuditLog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnnouncementController extends Controller
{
    public function index(): View
    {
        return view('admin.announcements.index', [
            'announcements' => Announcement::latest('published_at')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.announcements.create', [
            'announcement' => new Announcement,
            'categories' => Announcement::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateAnnouncement($request);

        $announcement = Announcement::create($this->payload($request, $validated));

        AuditLog::record('created_announcement', $announcement, $announcement->title);

        return redirect()->route('admin.announcements.index')->with('success', 'Article published.');
    }

    public function edit(Announcement $announcement): View
    {
        return view('admin.announcements.edit', [
            'announcement' => $announcement,
            'categories' => Announcement::CATEGORIES,
        ]);
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $validated = $this->validateAnnouncement($request);

        $announcement->update($this->payload($request, $validated, $announcement));

        AuditLog::record('updated_announcement', $announcement, $announcement->title);

        return redirect()->route('admin.announcements.index')->with('success', 'Article updated.');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $title = $announcement->title;
        $announcement->delete();

        AuditLog::record('deleted_announcement', $announcement, $title);

        return redirect()->route('admin.announcements.index')->with('success', 'Article deleted.');
    }

    protected function validateAnnouncement(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:'.implode(',', array_keys(Announcement::CATEGORIES)),
            'level' => 'required|in:info,notice,urgent',
            'excerpt' => 'nullable|string|max:500',
            'body' => 'required|string',
            'image' => 'nullable|image|max:4096',
            'published_at' => 'required|date',
            'is_featured' => 'nullable|boolean',
            'featured_order' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);
    }

    protected function payload(Request $request, array $validated, ?Announcement $announcement = null): array
    {
        $image = $request->hasFile('image')
            ? $request->file('image')->store('uploads/news', 'public')
            : $announcement?->image;

        return [
            'title' => $validated['title'],
            'slug' => $announcement?->slug,
            'category' => $validated['category'],
            'level' => $validated['level'],
            'excerpt' => $validated['excerpt'] ?? null,
            'body' => $validated['body'],
            'image' => $image,
            'published_at' => $validated['published_at'],
            'is_featured' => $request->boolean('is_featured'),
            'featured_order' => $validated['featured_order'] ?? $announcement?->featured_order ?? 0,
            'is_published' => $request->boolean('is_published'),
        ];
    }
}
