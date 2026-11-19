@php
    $event = $event;
    $election = $event->election;
@endphp
<x-admin-layout title="Edit Event" heading="Edit Event">
    <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data" class="grid gap-6">
        @csrf
        @method('PUT')

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <label class="field-label" for="title">Title</label>
                <input id="title" class="field-input" name="title" value="{{ old('title', $event->title) }}" required>
                @error('title') <p class="field-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="event_type">Type</label>
                    <select id="event_type" class="field-select" name="event_type" required>
                        @foreach ($types as $key => $label)
                            <option value="{{ $key }}" @selected(old('event_type', $event->event_type) === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="field-label" for="album">Album</label>
                    <input id="album" class="field-input" name="album" value="{{ old('album', $event->album) }}">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="starts_at">Starts at</label>
                    <input id="starts_at" class="field-input" type="datetime-local" name="starts_at" value="{{ old('starts_at', $event->starts_at->format('Y-m-d\TH:i')) }}" required>
                </div>
                <div>
                    <label class="field-label" for="ends_at">Ends at</label>
                    <input id="ends_at" class="field-input" type="datetime-local" name="ends_at" value="{{ old('ends_at', $event->ends_at?->format('Y-m-d\TH:i')) }}">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="time_label">Time label</label>
                    <input id="time_label" class="field-input" name="time_label" value="{{ old('time_label', $event->time_label) }}">
                </div>
                <div>
                    <label class="field-label" for="capacity">Capacity</label>
                    <input id="capacity" class="field-input" type="number" min="1" name="capacity" value="{{ old('capacity', $event->capacity) }}">
                </div>
            </div>

            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="field-label" for="venue">Venue</label>
                    <input id="venue" class="field-input" name="venue" value="{{ old('venue', $event->venue) }}">
                </div>
                <div>
                    <label class="field-label" for="map_query">Map query</label>
                    <input id="map_query" class="field-input" name="map_query" value="{{ old('map_query', $event->map_query) }}">
                </div>
            </div>

            <div>
                <label class="field-label" for="description">Description</label>
                <textarea id="description" class="field-textarea" rows="4" name="description">{{ old('description', $event->description) }}</textarea>
            </div>

            <div>
                <label class="field-label" for="rsvp_url">RSVP URL</label>
                <input id="rsvp_url" class="field-input" name="rsvp_url" value="{{ old('rsvp_url', $event->rsvp_url) }}">
            </div>
        </div>

        <div class="card grid gap-6 p-6 sm:p-8">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <p class="eyebrow">Media</p>
                    <p class="field-hint mt-1">Replace a photograph or video by choosing a new file.</p>
                </div>
                <a href="{{ route('events.show', $event) }}" target="_blank" rel="noopener" class="btn-ghost btn-sm">
                    Preview
                    <x-icon name="external-link" class="h-4 w-4" />
                </a>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <label class="field-label" for="image">Cover photograph</label>
                    @if ($event->image_url)
                        <img src="{{ $event->image_url }}" alt="" class="mb-3 aspect-[16/10] w-full rounded-2xl object-cover ring-1 ring-slate-200">
                    @endif
                    <input id="image" class="field-input" type="file" name="image" accept="image/*">
                </div>
                <div>
                    <label class="field-label" for="video">Video</label>
                    @if ($event->video_url)
                        <p class="mb-3 flex items-center gap-2 rounded-2xl bg-brand-50 px-3 py-2 text-xs font-semibold text-brand-800">
                            <x-icon name="video" class="h-4 w-4" />
                            {{ basename($event->video) }}
                        </p>
                    @endif
                    <input id="video" class="field-input" type="file" name="video" accept="video/mp4,video/webm,video/quicktime">
                </div>
                <div>
                    <label class="field-label" for="video_thumbnail">Video thumbnail</label>
                    @if ($event->video_thumbnail_url)
                        <img src="{{ $event->video_thumbnail_url }}" alt="" class="mb-3 aspect-[16/10] w-full rounded-2xl object-cover ring-1 ring-slate-200">
                    @endif
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
                        <input id="election_opens_at" class="field-input" type="datetime-local" name="election_opens_at" value="{{ old('election_opens_at', $election?->opens_at?->format('Y-m-d\TH:i')) }}">
                    </div>
                    <div>
                        <label class="field-label" for="election_closes_at">Voting closes at</label>
                        <input id="election_closes_at" class="field-input" type="datetime-local" name="election_closes_at" value="{{ old('election_closes_at', $election?->closes_at?->format('Y-m-d\TH:i')) }}">
                    </div>
                </div>
                <div class="mt-4">
                    <label class="field-label" for="election_description">Election description</label>
                    <textarea id="election_description" class="field-textarea" rows="3" name="election_description">{{ old('election_description', $election?->description) }}</textarea>
                </div>
                @if ($election)
                    <p class="mt-4 text-xs text-ink-500">
                        Manage positions and candidates in <a href="{{ route('admin.elections.edit', $election) }}" class="font-semibold text-brand-700">Elections admin</a>.
                    </p>
                @endif
            </div>
        </div>

        <div class="card grid gap-6 p-6 sm:p-8">
            <div>
                <p class="eyebrow">Visibility &amp; prominence</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div>
                    <label class="field-label" for="featured_order">Featured priority</label>
                    <input id="featured_order" class="field-input" type="number" min="0" name="featured_order" value="{{ old('featured_order', $event->featured_order) }}">
                </div>
                <label class="choice-card sm:col-span-2">
                    <input type="checkbox" name="registration_enabled" value="1" @checked(old('registration_enabled', $event->registration_enabled)) class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600">
                    <span>
                        <span class="block text-sm font-bold text-ink-900">Enable registration</span>
                        <span class="mt-0.5 block text-xs text-ink-500">Shows a clear registration action on the event card.</span>
                    </span>
                </label>
            </div>

            <div class="flex flex-wrap gap-6">
                <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $event->is_featured)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                    Mark as featured
                </label>
                <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                    <input type="checkbox" name="is_published" value="1" @checked(old('is_published', $event->is_published)) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                    Published
                </label>
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <button class="btn-primary" type="submit">Update event</button>
            <a href="{{ route('admin.events.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </form>
</x-admin-layout>
