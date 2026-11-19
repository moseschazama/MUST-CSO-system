<x-admin-layout title="New Activity" heading="New Activity">
    <form method="POST" action="{{ route('admin.activities.store') }}" enctype="multipart/form-data" class="grid gap-6">
        @csrf

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <label class="field-label" for="title">Title</label>
                <input id="title" class="field-input" name="title" value="{{ old('title') }}" required>
                @error('title') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="category">Category</label>
                    <select id="category" class="field-select" name="category" required>
                        @foreach ($categories as $key => $label)
                            <option value="{{ $key }}" @selected(old('category') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="field-label" for="album">Album</label>
                    <input id="album" class="field-input" name="album" value="{{ old('album') }}">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <label class="field-label" for="day">Day</label>
                    <input id="day" class="field-input" name="day" value="{{ old('day') }}" placeholder="e.g. Sunday">
                </div>
                <div>
                    <label class="field-label" for="time">Time</label>
                    <input id="time" class="field-input" name="time" value="{{ old('time') }}" placeholder="e.g. 09:00 AM">
                </div>
                <div>
                    <label class="field-label" for="venue">Venue</label>
                    <input id="venue" class="field-input" name="venue" value="{{ old('venue') }}">
                </div>
            </div>

            <div>
                <label class="field-label" for="summary">Summary</label>
                <textarea id="summary" class="field-textarea" rows="2" name="summary" maxlength="500">{{ old('summary') }}</textarea>
            </div>

            <div>
                <label class="field-label" for="description">Description</label>
                <textarea id="description" class="field-textarea" rows="4" name="description">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <p class="eyebrow">Media</p>
                <p class="field-hint mt-1">Photographs and videos carry the activity on the site. Videos open in an elegant preview modal — they never autoplay.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <label class="field-label" for="image">Cover photograph</label>
                    <input id="image" class="field-input" type="file" name="image" accept="image/*">
                </div>
                <div>
                    <label class="field-label" for="video">Video (MP4/WebM)</label>
                    <input id="video" class="field-input" type="file" name="video" accept="video/mp4,video/webm,video/quicktime">
                </div>
                <div>
                    <label class="field-label" for="video_thumbnail">Video thumbnail</label>
                    <input id="video_thumbnail" class="field-input" type="file" name="video_thumbnail" accept="image/*">
                </div>
            </div>
        </div>

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <p class="eyebrow">Visibility &amp; prominence</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <label class="field-label" for="featured_order">Featured priority</label>
                    <input id="featured_order" class="field-input" type="number" min="0" name="featured_order" value="{{ old('featured_order', 0) }}">
                    <p class="field-hint">Lower numbers appear first.</p>
                </div>
                <div>
                    <label class="field-label" for="sort_order">Sort order</label>
                    <input id="sort_order" class="field-input" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">
                </div>
                <div>
                    <label class="field-label" for="icon">Icon</label>
                    <input id="icon" class="field-input" name="icon" value="{{ old('icon') }}" placeholder="e.g. church">
                </div>
            </div>

            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                    Mark as featured
                </label>
                <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', true)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                    Published
                </label>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <button class="btn-primary" type="submit">Save activity</button>
            <a href="{{ route('admin.activities.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</x-admin-layout>
