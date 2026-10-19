@props(['title' => null, 'heading' => null])

@php
    $pageTitle = $title ? $title.' · CSO Admin' : 'CSO Admin';
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
    <body class="flex min-h-screen flex-col bg-ivory-100">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-burgundy-900 focus:px-4 focus:py-2 focus:text-ivory-50">
            Skip to content
        </a>

        <header class="theme-dark bg-burgundy-950 text-ivory-50">
            <div class="container-page flex flex-wrap items-center justify-between gap-4 py-3">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <x-brand-mark class="h-9 w-9 text-gold-300" />
                    <span class="font-serif text-lg font-semibold leading-tight">
                        MUST CSO
                        <span class="block text-xs font-sans font-semibold uppercase tracking-[0.2em] text-gold-300">Administration</span>
                    </span>
                </a>

                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="hidden px-3 py-2 text-sm font-semibold text-ivory-50/80 transition-colors hover:text-gold-300 sm:inline-flex">
                        View website
                    </a>
                    <span class="hidden text-sm text-ivory-50/70 md:inline">{{ auth()->user()->email }}</span>

                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="border border-ivory-50/30 px-4 py-2 text-sm font-semibold text-ivory-50 transition-colors hover:border-gold-300 hover:text-gold-300">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>

            <nav aria-label="Administration" class="border-t border-ivory-50/10">
                <div class="container-page flex flex-wrap gap-1 py-1">
                    <a
                        href="{{ route('admin.dashboard') }}"
                        class="admin-nav-link @if (request()->routeIs('admin.dashboard')) admin-nav-link-active @endif"
                        @if (request()->routeIs('admin.dashboard')) aria-current="page" @endif
                    >
                        Dashboard
                    </a>
                    <a
                        href="{{ route('admin.events.index') }}"
                        class="admin-nav-link @if (request()->routeIs('admin.events.*')) admin-nav-link-active @endif"
                        @if (request()->routeIs('admin.events.*')) aria-current="page" @endif
                    >
                        Events
                    </a>
                    <a
                        href="{{ route('admin.messages.index') }}"
                        class="admin-nav-link @if (request()->routeIs('admin.messages.*')) admin-nav-link-active @endif"
                        @if (request()->routeIs('admin.messages.*')) aria-current="page" @endif
                    >
                        Messages
                    </a>
                </div>
            </nav>
        </header>

        <main id="main-content" class="container-page w-full flex-1 py-10">
            <div class="mb-8 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h1 class="font-serif text-3xl text-burgundy-950 sm:text-4xl">{{ $title ?? 'Dashboard' }}</h1>
                    @if ($heading)
                        <p class="prose-cso mt-2">{{ $heading }}</p>
                    @endif
                </div>

                @isset($actions)
                    <div class="flex flex-wrap gap-3">
                        {{ $actions }}
                    </div>
                @endisset
            </div>

            <x-flash-status class="mb-6" />

            {{ $slot }}
        </main>

        <footer class="border-t border-charcoal-900/10 py-6">
            <div class="container-page text-sm text-charcoal-600">
                Signed in as an administrator of {{ config('app.name') }}.
            </div>
        </footer>
    </body>
</html>
