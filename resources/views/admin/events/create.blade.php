<x-layouts.admin title="Create event" heading="Draft the event first, then publish it when the details are confirmed.">
    <x-slot:actions>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline">Back to events</a>
    </x-slot:actions>

    @include('admin.events._form', [
        'action' => route('admin.events.store'),
        'method' => 'POST',
        'event' => null,
        'submitLabel' => 'Create event',
    ])
</x-layouts.admin>
