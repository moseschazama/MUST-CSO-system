<x-admin-layout title="Registrations" heading="Registrations — {{ $event->title }}">
    <div class="card p-8">
        <p class="text-sm text-ink-500">{{ $event->starts_at->format('d F Y') }} · {{ $event->venue }}</p>
        <div class="mt-6 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Notes</th>
                        <th class="px-4 py-3">Attended</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($registrations as $registration)
                        <tr class="border-t border-slate-100">
                            <td class="px-4 py-3 font-semibold text-ink-900">{{ $registration->name }}</td>
                            <td class="px-4 py-3 text-ink-500">{{ $registration->email }}</td>
                            <td class="px-4 py-3 text-ink-500">{{ $registration->phone }}</td>
                            <td class="px-4 py-3 text-ink-500">{{ $registration->notes }}</td>
                            <td class="px-4 py-3">{{ $registration->attended ? 'Yes' : 'No' }}</td>
                            <td class="px-4 py-3 text-right">
                                <form method="POST" action="{{ route('admin.events.registrations.attended', [$event, $registration]) }}">
                                    @csrf
                                    <button class="text-sm font-bold text-brand-700" type="submit">Toggle</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-4 py-6 text-center text-ink-500">No registrations yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $registrations->links() }}</div>
        <div class="mt-6">
            <a href="{{ route('admin.events.index') }}" class="btn-ghost">Back to events</a>
        </div>
    </div>
</x-admin-layout>
BLADE
echo done