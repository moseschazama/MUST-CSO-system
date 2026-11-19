<x-admin-layout title="New Event" heading="New Event">
    <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="grid gap-6">
        @csrf

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <label class="field-label" for="title">Title</label>
                <input id="title" class="field-input" name="title" value="{{ old('title') }}" required>
                @error('title') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="event_type">Type</label>
                    <select id="event_type" class="field-select" name="event_type" required>
                        @foreach ($types as $key => $label)
                            <option value="{{ $key }}" @selected(old('event_type') === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="field-label" for="album">Album</label>
                    <input id="album" class="field-input" name="album" value="{{ old('album') }}">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="starts_at">Starts at</label>
                    <input id="starts_at" class="field-input" type="datetime-local" name="starts_at" value="{{ old('starts_at') }}" required>
                </div>
                <div>
                    <label class="field-label" for="ends_at">Ends at</label>
                    <input id="ends_at" class="field-input" type="datetime-local" name="ends_at" value="{{ old('ends_at') }}">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="time_label">Time label</label>
                    <input id="time_label" class="field-input" name="time_label" value="{{ old('time_label') }}">
                </div>
                <div>
                    <label class="field-label" for="capacity">Capacity</label>
                    <input id="capacity" class="field-input" type="number" min="1" name="capacity" value="{{ old('capacity') }}">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="venue">Venue</label>
                    <input id="venue" class="field-input" name="venue" value="{{ old('venue') }}">
                </div>
                <div>
                    <label class="field-label" for="map_query">Map query</label>
                    <input id="map_query" class="field-input" name="map_query" value="{{ old('map_query') }}">
                </div>
            </div>

            <div>
                <label class="field-label" for="description">Description</label>
                <textarea id="description" class="field-textarea" rows="4" name="description">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="field-label" for="rsvp_url">RSVP URL</label>
                <input id="rsvp_url" class="field-input" name="rsvp_url" value="{{ old('rsvp_url') }}" placeholder="https://">
            </div>
        </div>

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <p class="eyebrow">Media</p>
                <p class="field-hint mt-1">A video thumbnail doubles as the event preview image when no cover photograph is uploaded.</p>
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
                <p class="eyebrow">Election setup (if Election)</p>
                <div class="mt-4 grid gap-6 sm:grid-cols-2">
                    <div>
                        <label class="field-label" for="election_opens_at">Voting opens at</label>
                        <input id="election_opens_at" class="field-input" type="datetime-local" name="election_opens_at" value="{{ old('election_opens_at') }}">
                    </div>
                    <div>
                        <label class="field-label" for="election_closes_at">Voting closes at</label>
                        <input id="election_closes_at" class="field-input" type="datetime-local" name="election_closes_at" value="{{ old('election_closes_at') }}">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="field-label" for="election_description">Election description</label>
                    <textarea id="election_description" class="field-textarea" rows="3" name="election_description">{{ old('election_description') }}</textarea>
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
                <label class="choice-card sm:col-span-2">
                    <input type="checkbox" name="registration_enabled" value="1" @checked(old('registration_enabled')) class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600">
                    <span>
                        <span class="block text-sm font-bold text-ink-900">Enable registration</span>
                        <span class="mt-0.5 block text-xs text-ink-500">Shows a clear registration action on the event card.</span>
                    </span>
                </label>
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
            <button class="btn-primary" type="submit">Save event</button>
            <a href="{{ route('admin.events.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</x-admin-layout>
