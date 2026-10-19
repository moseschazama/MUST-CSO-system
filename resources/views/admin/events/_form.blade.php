@php
    $event = $event ?? null;
@endphp

<form method="POST" action="{{ $action }}" class="grid gap-8 lg:grid-cols-3">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="lg:col-span-2">
        <x-form.errors />

        <div class="card space-y-6 p-6 sm:p-8">
            <div>
                <x-form.label for="title">Title <span aria-hidden="true" class="text-burgundy-700">*</span></x-form.label>
                <x-form.input
                    name="title"
                    :value="$event?->title"
                    required
                    placeholder="e.g. Community welcome evening"
                />
            </div>

            <div>
                <x-form.label for="slug" optional>URL slug</x-form.label>
                <x-form.input
                    name="slug"
                    :value="$event?->slug"
                    placeholder="community-welcome-evening"
                />
                <p class="form-help">
                    Leave blank to generate a slug from the title. Changing an existing slug will
                    change the public event URL.
                </p>
            </div>

            <div>
                <x-form.label for="excerpt" optional>Short summary</x-form.label>
                <x-form.textarea
                    name="excerpt"
                    :value="$event?->excerpt"
                    rows="3"
                    maxlength="500"
                    placeholder="A short summary shown on event cards."
                />
            </div>

            <div>
                <x-form.label for="description">Full description <span aria-hidden="true" class="text-burgundy-700">*</span></x-form.label>
                <x-form.textarea
                    name="description"
                    :value="$event?->description"
                    rows="10"
                    required
                    placeholder="Describe the event, who it is for, and what attendees should expect."
                />
            </div>

            <div>
                <x-form.label for="location" optional>Venue or location</x-form.label>
                <x-form.input
                    name="location"
                    :value="$event?->location"
                    placeholder="e.g. MUST campus"
                />
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="card space-y-6 p-6">
            <h2 class="font-serif text-xl text-burgundy-950">Schedule</h2>

            <div>
                <x-form.label for="starts_at">Starts at <span aria-hidden="true" class="text-burgundy-700">*</span></x-form.label>
                <x-form.input
                    name="starts_at"
                    type="datetime-local"
                    :value="$event?->starts_at?->format('Y-m-d\TH:i')"
                    required
                />
            </div>

            <div>
                <x-form.label for="ends_at" optional>Ends at</x-form.label>
                <x-form.input
                    name="ends_at"
                    type="datetime-local"
                    :value="$event?->ends_at?->format('Y-m-d\TH:i')"
                />
            </div>
        </div>

        <div class="card space-y-6 p-6">
            <h2 class="font-serif text-xl text-burgundy-950">Visibility</h2>

            <x-form.checkbox name="is_published" :checked="$event?->is_published ?? false">
                Publish this event on the public website
            </x-form.checkbox>

            <p class="text-sm leading-relaxed text-charcoal-600">
                Draft events are visible to administrators only.
            </p>

            <button type="submit" class="btn btn-primary w-full">{{ $submitLabel }}</button>
        </div>
    </div>
</form>
