@php $announcement = $announcement; @endphp
<x-admin-layout title="Edit Announcement" heading="Edit Announcement">
    <form method="POST" action="{{ route('admin.announcements.update', $announcement) }}" enctype="multipart/form-data" class="grid gap-6">
        @csrf
        @method('PUT')

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <label class="field-label" for="title">Title</label>
                <input id="title" class="field-input" name="title" value="{{ old('title', $announcement->title) }}" required>
                @error('title') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="category">Category</label>
                    <select id="category" class="field-select" name="category" required>
                        @foreach ($categories as $key => $label)
                            <option value="{{ $key }}" @selected(old('category', $announcement->category) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="field-label" for="level">Level</label>
                    <select id="level" class="field-select" name="level" required>
                        @foreach (['info' => 'Info', 'notice' => 'Notice', 'urgent' => 'Urgent'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('level', $announcement->level) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="field-label" for="excerpt">Excerpt</label>
                <textarea id="excerpt" class="field-textarea" rows="2" name="excerpt" maxlength="500">{{ old('excerpt', $announcement->excerpt) }}</textarea>
            </div>

            <div>
                <label class="field-label" for="body">Body</label>
                <textarea id="body" class="field-textarea" rows="6" name="body" required>{{ old('body', $announcement->body) }}</textarea>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="image">Cover photograph</label>
                    @if ($announcement->image_url)
                        <img src="{{ $announcement->image_url }}" alt="" class="mb-3 aspect-[16/10] w-full rounded-2xl object-cover ring-1 ring-slate-200">
                    @endif
                    <input id="image" class="field-input" type="file" name="image" accept="image/*">
                </div>
                <div>
                    <label class="field-label" for="published_at">Published at</label>
                    <input id="published_at" class="field-input" type="datetime-local" name="published_at" value="{{ old('published_at', $announcement->published_at?->format('Y-m-d\TH:i')) }}" required>
                </div>
            </div>
        </div>

        <div class="card grid gap-6 p-6 sm:p-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="eyebrow">Visibility &amp; prominence</p>
                </div>
                <a href="{{ route('news.show', $announcement) }}" target="_blank" rel="noopener" class="btn-ghost btn-sm">
                    Preview
                    <x-icon name="external-link" class="h-4 w-4" />
                </a>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="featured_order">Featured priority</label>
                    <input id="featured_order" class="field-input" type="number" min="0" name="featured_order" value="{{ old('featured_order', $announcement->featured_order) }}">
                </div>
                <div class="flex flex-col justify-end gap-3">
                    <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $announcement->is_featured)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                        Mark as featured story
                    </label>
                    <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $announcement->is_published)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                        Published
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <button class="btn-primary" type="submit">Update</button>
            <a href="{{ route('admin.announcements.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</x-admin-layout>
