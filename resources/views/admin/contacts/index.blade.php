<x-admin-layout title="Contact Messages" heading="Contact Messages">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Community</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Contact messages</h1>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-ghost btn-sm">Back to dashboard</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Name</th>
                    <th class="px-5 py-3">Email</th>
                    <th class="px-5 py-3">Message</th>
                    <th class="px-5 py-3">Read</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $message->name }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $message->email }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ Str::limit($message->message, 80) }}</td>
                        <td class="px-5 py-3"><span class="chip">{{ $message->is_read ? 'Read' : 'New' }}</span></td>
                        <td class="px-5 py-3 text-right">
                            <form method="POST" action="{{ route('admin.contacts.read', $message) }}">
                                @csrf
                                <button class="text-sm font-bold text-brand-700" type="submit">Mark read</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">{{ $messages->links() }}</div>
    </div>
</x-admin-layout>
