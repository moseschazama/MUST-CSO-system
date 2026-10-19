<x-layouts.admin title="Events" heading="Create, publish, and update the events shown on the public website.">
    <x-slot:actions>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Create event</a>
    </x-slot:actions>

    @if ($events->isEmpty())
        <div class="card p-8">
            <h2 class="font-serif text-2xl text-burgundy-950">No events yet</h2>
            <p class="prose-cso mt-3 max-w-2xl">
                Create the first event and publish it when the date, time, and venue have been
                confirmed. Draft events are never shown on the public website.
            </p>
            <a href="{{ route('admin.events.create') }}" class="btn btn-primary mt-6">Create an event</a>
        </div>
    @else
        <div class="overflow-x-auto border border-charcoal-900/10 bg-white shadow-card">
            <table class="min-w-full divide-y divide-charcoal-900/10 text-left text-sm">
                <caption class="sr-only">All events in the CSO website</caption>
                <thead class="bg-ivory-100">
                    <tr class="text-xs uppercase tracking-[0.16em] text-charcoal-600">
                        <th scope="col" class="px-5 py-3 font-semibold">Event</th>
                        <th scope="col" class="px-5 py-3 font-semibold">Schedule</th>
                        <th scope="col" class="px-5 py-3 font-semibold">Status</th>
                        <th scope="col" class="px-5 py-3 font-semibold"><span class="sr-only">Actions</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-charcoal-900/10">
                    @foreach ($events as $event)
                        <tr>
                            <th scope="row" class="px-5 py-4 align-top font-semibold text-charcoal-900">
                                <a href="{{ route('admin.events.edit', $event) }}" class="transition-colors hover:text-burgundy-700">
                                    {{ $event->title }}
                                </a>
                                @if ($event->is_demo)
                                    <span class="badge badge-demo mt-2 block w-fit">Demo</span>
                                @endif
                            </th>
                            <td class="px-5 py-4 align-top text-charcoal-700">
                                <p>{{ $event->scheduleSummary() }}</p>
                                @if ($event->location)
                                    <p class="mt-1 text-charcoal-500">{{ $event->location }}</p>
                                @endif
                            </td>
                            <td class="px-5 py-4 align-top">
                                @if ($event->is_published)
                                    <span class="badge badge-published">Published</span>
                                @else
                                    <span class="badge badge-draft">Draft</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 align-top text-right">
                                <div class="flex flex-wrap items-center justify-end gap-4">
                                    <a href="{{ route('admin.events.edit', $event) }}" class="font-semibold text-burgundy-800 hover:text-burgundy-600">
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('admin.events.destroy', $event) }}"
                                        data-confirm="Delete the event “{{ $event->title }}”? This cannot be undone."
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-800 hover:text-red-700">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $events->links() }}
        </div>
    @endif
</x-layouts.admin>
