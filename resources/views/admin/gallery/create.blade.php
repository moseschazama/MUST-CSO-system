<x-admin-layout title="Add Photo" heading="Add Photo">
    <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data" class="grid gap-6">
        @csrf

        <div class="card grid gap-6 p-6 sm:p-8">
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="album">Album</label>
                    <input id="album" class="field-input" name="album" value="{{ old('album') }}" required list="album-options">
                    <datalist id="album-options">
                        @foreach ($albums as $album)
                            <option value="{{ $album }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="field-label" for="title">Title</label>
                    <input id="title" class="field-input" name="title" value="{{ old('title') }}" required>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="category">Category</label>
                    <input id="category" class="field-input" name="category" value="{{ old('category') }}" required placeholder="e.g. Mass, Outreach">
                </div>
                <div>
                    <label class="field-label" for="taken_on">Taken on</label>
                    <input id="taken_on" class="field-input" type="date" name="taken_on" value="{{ old('taken_on') }}">
                </div>
            </div>

            <div>
                <label class="field-label" for="album_description">Album description</label>
                <textarea id="album_description" class="field-textarea" rows="2" name="album_description">{{ old('album_description') }}</textarea>
            </div>

            <div>
                <label class="field-label" for="caption">Caption</label>
                <input id="caption" class="field-input" name="caption" value="{{ old('caption') }}">
            </div>

            <div>
                <label class="field-label" for="image">Photograph</label>
                <input id="image" class="field-input" type="file" name="image" accept="image/*" required>
                @error('image') <p class="field-error">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <p class="eyebrow">Visibility &amp; prominence</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="field-label" for="featured_order">Featured priority</label>
                        <input id="featured_order" class="field-input" type="number" min="0" name="featured_order" value="{{ old('featured_order', 0) }}">
                    </div>
                    <div>
                        <label class="field-label" for="sort_order">Sort order</label>
                        <input id="sort_order" class="field-input" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}">
                    </div>
                </div>
                <div class="flex flex-col justify-end gap-3">
                    <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured')) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                        Feature this photograph
                    </label>
                    <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', true)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                        Published
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <button class="btn-primary" type="submit">Save photo</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.gallery.bulk') }}" enctype="multipart/form-data" class="card mt-8 grid gap-6 p-6 sm:p-8">
        @csrf
        <div>
            <p class="eyebrow">Bulk upload</p>
            <p class="mt-2 text-sm text-ink-500">Add several photos to one album at once. They publish immediately.</p>
        </div>
        <div class="grid gap-6 sm:grid-cols-2">
            <div>
                <label class="field-label" for="bulk_album">Album</label>
                <input id="bulk_album" class="field-input" name="album" value="{{ old('album') }}" required list="album-options-bulk">
                <datalist id="album-options-bulk">
                    @foreach ($albums as $album)
                        <option value="{{ $album }}"></option>
                    @endforeach
                </datalist>
            </div>
            <div>
                <label class="field-label" for="bulk_category">Category</label>
                <input id="bulk_category" class="field-input" name="category" value="{{ old('category') }}" required placeholder="e.g. Mass, Outreach, Choir">
            </div>
        </div>
        <div>
            <label class="field-label" for="bulk_photos">Photographs</label>
            <input id="bulk_photos" class="field-input" type="file" name="photos[]" accept="image/*" multiple required>
            @error('photos') <p class="field-error">{{ $message }}</p> @enderror
        </div>
        <button class="btn-primary" type="submit">Upload photos</button>
    </form>
</x-admin-layout>
