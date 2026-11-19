<x-admin-layout title="Prayer Intentions" heading="Prayer Intentions">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Pastoral care</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Prayer intentions</h1>
            <p class="mt-2 text-sm text-ink-500">{{ $pending }} awaiting prayer.</p>
        </div>
    </div>

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Received</th>
                    <th class="px-5 py-3">From</th>
                    <th class="px-5 py-3">Intention</th>
                    <th class="px-5 py-3">Mass date</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($intentions as $intention)
                    <tr class="border-t border-slate-100 align-top">
                        <td class="px-5 py-3 text-ink-500">{{ $intention->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $intention->is_anonymous ? 'Anonymous' : ($intention->name ?: 'Anonymous') }}</td>
                        <td class="max-w-md px-5 py-3 text-ink-700">{{ $intention->intention }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $intention->mass_date?->format('d M Y') ?: '—' }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ ucfirst($intention->status) }}</span></td>
                        <td class="px-5 py-3 text-right">
                            @if ($intention->status !== 'prayed')
                                <form method="POST" action="{{ route('admin.prayer-intentions.prayed', $intention) }}">
                                    @csrf
                                    <button type="submit" class="text-sm font-bold text-brand-700">Mark prayed</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr class="border-t border-slate-100">
                        <td colspan="6" class="px-5 py-8 text-center text-sm text-ink-500">No prayer intentions have been submitted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-5">{{ $intentions->links() }}</div>
    </div>
</x-admin-layout>
