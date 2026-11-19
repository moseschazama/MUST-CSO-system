@props(['title' => null, 'heading' => null])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? $heading ?? 'Admin' }} - MUST CSO Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ivory-100 text-ink-700">
    <div class="container-page py-10">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow">Administration</p>
                <h1 class="mt-2 text-3xl font-extrabold text-ink-900">{{ $heading ?? 'Dashboard' }}</h1>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('home') }}" class="btn-ghost btn-sm">View site</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn-ghost btn-sm" type="submit">Sign out</button>
                </form>
            </div>
        </div>

        <nav class="mt-6 flex flex-wrap gap-2 rounded-2xl border border-slate-200/70 bg-white p-3" aria-label="Admin sections">
            @foreach ([
                'Dashboard' => 'admin.dashboard',
                'Members' => 'admin.members.index',
                'M’Phakati' => 'admin.mphakati.index',
                'Activities' => 'admin.activities.index',
                'Choir' => 'admin.choir.index',
                'News' => 'admin.announcements.index',
                'Events' => 'admin.events.index',
                'Gallery' => 'admin.gallery.index',
                'Leaders' => 'admin.leaders.index',
                'Elections' => 'admin.elections.index',
                'Settings' => 'admin.settings.index',
            ] as $label => $route)
                <a href="{{ route($route) }}" class="rounded-xl px-3 py-2 text-xs font-bold text-ink-600 transition hover:bg-brand-50 hover:text-brand-800">{{ $label }}</a>
            @endforeach
        </nav>

        @if (session('success'))
            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        {{ $slot }}
    </div>
</body>
</html>
