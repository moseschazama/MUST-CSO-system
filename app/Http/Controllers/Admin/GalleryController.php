<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\GalleryPhoto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('admin.gallery.index', [
            'photos' => GalleryPhoto::latest()->paginate(24),
            'albums' => GalleryPhoto::query()->select('album')->distinct()->orderBy('album')->pluck('album'),
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create', [
            'albums' => GalleryPhoto::query()->select('album')->distinct()->orderBy('album')->pluck('album'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'album' => 'required|string|max:255',
            'album_description' => 'nullable|string|max:500',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'required|image|max:8192',
            'caption' => 'nullable|string|max:255',
            'taken_on' => 'nullable|date',
            'sort_order' => 'nullable|integer|min:0',
            'featured_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        $photo = GalleryPhoto::create([
            'album' => $validated['album'],
            'album_description' => $validated['album_description'] ?? null,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'image_path' => $request->file('image')->store('uploads/gallery', 'public'),
            'caption' => $validated['caption'] ?? null,
            'alt' => $validated['caption'] ?? $validated['title'],
            'taken_on' => $validated['taken_on'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'featured_order' => $validated['featured_order'] ?? 0,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
        ]);

        AuditLog::record('created_gallery_photo', $photo, $photo->title);

        return redirect()->route('admin.gallery.index')->with('success', 'Photo uploaded.');
    }

    public function bulkStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'album' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'album_description' => 'nullable|string|max:500',
            'photos' => 'required|array|min:1',
            'photos.*' => 'image|max:8192',
        ]);

        $count = 0;

        foreach ($request->file('photos') as $index => $file) {
            GalleryPhoto::create([
                'album' => $validated['album'],
                'album_description' => $validated['album_description'] ?? null,
                'title' => $validated['album'].' — photo '.($index + 1),
                'category' => $validated['category'],
                'image_path' => $file->store('uploads/gallery', 'public'),
                'alt' => $validated['album'].' photo',
                'sort_order' => $index,
                'is_published' => true,
            ]);

            $count++;
        }

        AuditLog::record('bulk_uploaded_gallery', null, $count.' photos into '.$validated['album']);

        return redirect()->route('admin.gallery.index')->with('success', $count.' photos uploaded to '.$validated['album'].'.');
    }

    public function edit(GalleryPhoto $photo): View
    {
        return view('admin.gallery.edit', [
            'photo' => $photo,
            'albums' => GalleryPhoto::query()->select('album')->distinct()->orderBy('album')->pluck('album'),
        ]);
    }

    public function update(Request $request, GalleryPhoto $photo): RedirectResponse
    {
        $validated = $request->validate([
            'album' => 'required|string|max:255',
            'album_description' => 'nullable|string|max:500',
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'image' => 'nullable|image|max:8192',
            'caption' => 'nullable|string|max:255',
            'taken_on' => 'nullable|date',
            'sort_order' => 'nullable|integer|min:0',
            'featured_order' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'is_published' => 'nullable|boolean',
        ]);

        $photo->update([
            'album' => $validated['album'],
            'album_description' => $validated['album_description'] ?? null,
            'title' => $validated['title'],
            'category' => $validated['category'],
            'image_path' => $request->hasFile('image')
                ? $request->file('image')->store('uploads/gallery', 'public')
                : $photo->image_path,
            'caption' => $validated['caption'] ?? null,
            'alt' => $validated['caption'] ?? $validated['title'],
            'taken_on' => $validated['taken_on'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            'featured_order' => $validated['featured_order'] ?? $photo->featured_order,
            'is_featured' => $request->boolean('is_featured'),
            'is_published' => $request->boolean('is_published'),
        ]);

        AuditLog::record('updated_gallery_photo', $photo, $photo->title);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery photo updated.');
    }

    public function destroy(GalleryPhoto $photo): RedirectResponse
    {
        $title = $photo->title;
        $photo->delete();

        AuditLog::record('deleted_gallery_photo', $photo, $title);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery photo deleted.');
    }
}
