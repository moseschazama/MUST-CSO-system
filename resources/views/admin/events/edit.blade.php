<x-layouts.admin :title="'Edit: '.$event->title" heading="Update the event details, publish state, and schedule.">
    <x-slot:actions>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline">Back to events</a>
    </x-slot:actions>

    @if ($event->is_demo)
        <div role="note" class="mb-8 border-l-4 border-gold-500 bg-white px-5 py-4 text-sm text-charcoal-700 shadow-card">
            <strong class="font-semibold text-charcoal-900">Demonstration content:</strong>
            this event was created by the demo seeder for local preview. It is labelled as
            demonstration content everywhere it appears.
        </div>
    @endif

    @include('admin.events._form', [
        'action' => route('admin.events.update', $event),
        'method' => 'PUT',
        'event' => $event,
        'submitLabel' => 'Save changes',
    ])
</x-layouts.admin>
