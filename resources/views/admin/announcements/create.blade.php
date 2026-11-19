<x-admin-layout title="New Announcement" heading="New Announcement">
    <form method="POST" action="{{ route('admin.announcements.store') }}" enctype="multipart/form-data" class="grid gap-6">
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
                    <label class="field-label" for="level">Level</label>
                    <select id="level" class="field-select" name="level" required>
                        @foreach (['info' => 'Info', 'notice' => 'Notice', 'urgent' => 'Urgent'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('level') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="field-label" for="excerpt">Excerpt</label>
                <textarea id="excerpt" class="field-textarea" rows="2" name="excerpt" maxlength="500">{{ old('excerpt') }}</textarea>
            </div>

            <div>
                <label class="field-label" for="body">Body</label>
                <textarea id="body" class="field-textarea" rows="6" name="body" required>{{ old('body') }}</textarea>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="image">Cover photograph</label>
                    <input id="image" class="field-input" type="file" name="image" accept="image/*">
                    <p class="field-hint">A strong horizontal photograph makes the story stand out.</p>
                </div>
                <div>
                    <label class="field-label" for="published_at">Published at</label>
                    <input id="published_at" class="field-input" type="datetime-local" name="published_at" value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" required>
                </div>
            </div>
        </div>

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <p class="eyebrow">Visibility &amp; prominence</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="featured_order">Featured priority</label>
                    <input id="featured_order" class="field-input" type="number" min="0" name="featured_order" value="{{ old('featured_order', 0) }}">
                    <p class="field-hint">Lower numbers appear first.</p>
                </div>
                <div class="flex flex-col justify-end gap-3">
                    <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                        Mark as featured story
                    </label>
                    <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', true)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                        Published
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <button class="btn-primary" type="submit">Publish</button>
            <a href="{{ route('admin.announcements.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</x-admin-layout>
