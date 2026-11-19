<x-admin-layout title="Dashboard" heading="Dashboard">
    <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => 'Members', 'value' => $counts['members']],
            ['label' => 'Pending members', 'value' => $counts['pending_members']],
            ['label' => 'Gallery photos', 'value' => $counts['gallery']],
            ['label' => 'Unread messages', 'value' => $counts['messages']],
        ] as $stat)
            <div class="card p-6">
                <p class="text-3xl font-extrabold text-ink-900">{{ $stat['value'] }}</p>
                <p class="mt-1 text-xs font-bold tracking-wide text-ink-500 uppercase">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-extrabold text-ink-900">Quick actions</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ([
                ['label' => "M'Phakati allocation", 'description' => 'Assign submitted members to small Christian communities', 'route' => 'admin.mphakati.index'],
                ['label' => 'Upload gallery photo', 'description' => 'Add photos that display in the public gallery', 'route' => 'admin.gallery.create'],
                ['label' => 'Publish news', 'description' => 'Post the latest news and announcements', 'route' => 'admin.announcements.create'],
                ['label' => 'Publish activity', 'description' => 'Add an activity to the public activities page', 'route' => 'admin.activities.create'],
                ['label' => 'Add choir activity', 'description' => 'Post choir and music ministry updates', 'route' => 'admin.choir.index'],
                ['label' => 'Review members', 'description' => 'Approve applications and see requested affiliations', 'route' => 'admin.members.index'],
            ] as $item)
                <a href="{{ route($item['route']) }}" class="card card-hover p-6">
                    <p class="text-lg font-extrabold text-ink-900">{{ $item['label'] }}</p>
                    <p class="mt-1 text-sm text-ink-500">{{ $item['description'] }}</p>
                </a>
            @endforeach
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-xl font-extrabold text-ink-900">Content overview</h2>
        <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['label' => 'Activities', 'value' => $counts['activities'], 'route' => 'admin.activities.index'],
                ['label' => 'Events', 'value' => $counts['events'], 'route' => 'admin.events.index'],
                ['label' => 'News & announcements', 'value' => $counts['announcements'], 'route' => 'admin.announcements.index'],
                ['label' => 'Gallery photos', 'value' => $counts['gallery'], 'route' => 'admin.gallery.index'],
                ['label' => 'Leaders', 'value' => $counts['leaders'], 'route' => 'admin.leaders.index'],
                ['label' => 'Reports', 'value' => $counts['reports'], 'route' => 'admin.reports.index'],
                ['label' => 'Open elections', 'value' => $counts['elections'], 'route' => 'admin.elections.index'],
                ['label' => 'Prayer intentions', 'value' => $counts['messages'], 'route' => 'admin.prayer-intentions.index'],
            ] as $item)
                <a href="{{ route($item['route']) }}" class="card card-hover p-6">
                    <p class="text-3xl font-extrabold text-ink-900">{{ $item['value'] }}</p>
                    <p class="mt-1 text-sm font-semibold text-ink-500">{{ $item['label'] }}</p>
                </a>
            @endforeach
        </div>
    </div>

    <div class="mt-10">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <h2 class="text-xl font-extrabold text-ink-900">Latest member applications</h2>
            <a href="{{ route('admin.members.index') }}" class="btn-ghost btn-sm">View all members</a>
        </div>
        <div class="card mt-4 overflow-hidden">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                    <tr>
                        <th class="px-5 py-3">Name</th>
                        <th class="px-5 py-3">Email</th>
                        <th class="px-5 py-3">Requested group</th>
                        <th class="px-5 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recent_members as $member)
                        <tr class="border-t border-slate-100">
                            <td class="px-5 py-3 font-semibold text-ink-900">{{ $member->full_name }}</td>
                            <td class="px-5 py-3 text-ink-500">{{ $member->email }}</td>
                            <td class="px-5 py-3 text-ink-500">{{ $member->requested_group ?: '—' }}</td>
                            <td class="px-5 py-3"><span class="chip">{{ $member->status_label }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-5 py-8 text-center text-sm text-ink-500">No applications yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
