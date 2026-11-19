<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - MUST CSO</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-ivory-100 text-ink-700">
    <div class="container-page py-10">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow">Administration</p>
                <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Dashboard</h1>
            </div>
            <a href="{{ route('home') }}" class="btn-ghost btn-sm">View site</a>
        </div>

        @if (session('success'))
            <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
</body>
</html>
