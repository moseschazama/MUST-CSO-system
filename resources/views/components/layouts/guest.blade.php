@props(['title' => null])

@php
    $appName = config('app.name', 'MUST Catholic Students Organisation');
    $pageTitle = $title ? $title.' · Administrator access' : 'Administrator access · '.$appName;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex, nofollow">

        <title>{{ $pageTitle }}</title>
        <meta name="theme-color" content="#240811">

        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="theme-dark hero-texture flex min-h-screen flex-col items-center justify-center px-5 py-12">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-burgundy-900 focus:px-4 focus:py-2 focus:text-ivory-50">
            Skip to content
        </a>

        <div class="w-full max-w-md">
            <div class="mb-8 flex items-center justify-center gap-3 text-gold-300">
                <x-brand-mark class="h-12 w-12" />
                <div>
                    <p class="font-serif text-xl font-semibold text-ivory-50">MUST Catholic Students</p>
                    <p class="eyebrow text-gold-300">Organisation</p>
                </div>
            </div>

            <main id="main-content" class="border border-ivory-50/10 bg-ivory-50 p-8 shadow-soft">
                <x-flash-status class="mb-6" />

                {{ $slot }}
            </main>

            <p class="mt-8 text-center text-sm text-ivory-100/70">
                <a class="underline underline-offset-4 hover:text-gold-300" href="{{ route('home') }}">
                    Return to the public website
                </a>
            </p>
        </div>
    </body>
</html>
