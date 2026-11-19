@php $photo = $photo; @endphp
<x-admin-layout title="Edit Photo" heading="Edit Photo">
    <form method="POST" action="{{ route('admin.gallery.update', $photo) }}" enctype="multipart/form-data" class="grid gap-6">
        @csrf
        @method('PUT')

        <div class="card grid gap-6 p-6 sm:p-8">
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="album">Album</label>
                    <input id="album" class="field-input" name="album" value="{{ old('album', $photo->album) }}" required list="album-options">
                    <datalist id="album-options">
                        @foreach ($albums as $album)
                            <option value="{{ $album }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div>
                    <label class="field-label" for="title">Title</label>
                    <input id="title" class="field-input" name="title" value="{{ old('title', $photo->title) }}" required>
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="category">Category</label>
                    <input id="category" class="field-input" name="category" value="{{ old('category', $photo->category) }}" required>
                </div>
                <div>
                    <label class="field-label" for="taken_on">Taken on</label>
                    <input id="taken_on" class="field-input" type="date" name="taken_on" value="{{ old('taken_on', $photo->taken_on?->format('Y-m-d')) }}">
                </div>
            </div>

            <div>
                <label class="field-label" for="album_description">Album description</label>
                <textarea id="album_description" class="field-textarea" rows="2" name="album_description">{{ old('album_description', $photo->album_description) }}</textarea>
            </div>

            <div>
                <label class="field-label" for="caption">Caption</label>
                <input id="caption" class="field-input" name="caption" value="{{ old('caption', $photo->caption) }}">
            </div>

            <div>
                <label class="field-label" for="image">Photograph</label>
                <img src="{{ $photo->thumbnail }}" alt="" class="mb-3 aspect-[16/10] w-full max-w-sm rounded-2xl object-cover ring-1 ring-slate-200">
                <input id="image" class="field-input" type="file" name="image" accept="image/*">
            </div>
        </div>

        <div class="card grid gap-6 p-6 sm:p-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <p class="eyebrow">Visibility &amp; prominence</p>
                <a href="{{ route('gallery') }}" target="_blank" rel="noopener" class="btn-ghost btn-sm">
                    Preview gallery
                    <x-icon name="external-link" class="h-4 w-4" />
                </a>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="field-label" for="featured_order">Featured priority</label>
                        <input id="featured_order" class="field-input" type="number" min="0" name="featured_order" value="{{ old('featured_order', $photo->featured_order) }}">
                    </div>
                    <div>
                        <label class="field-label" for="sort_order">Sort order</label>
                        <input id="sort_order" class="field-input" type="number" min="0" name="sort_order" value="{{ old('sort_order', $photo->sort_order) }}">
                    </div>
                </div>
                <div class="flex flex-col justify-end gap-3">
                    <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                        <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $photo->is_featured)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                        Feature this photograph
                    </label>
                    <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                        <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $photo->is_published)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                        Published
                    </label>
                </div>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <button class="btn-primary" type="submit">Update photo</button>
            <a href="{{ route('admin.gallery.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</x-admin-layout>
