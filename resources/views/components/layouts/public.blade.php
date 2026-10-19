@props(['title' => null, 'description' => null])

@php
    $appName = config('app.name', 'MUST Catholic Students Organisation');
    $pageTitle = $title ? $title.' · '.$appName : $appName.' · Faith. Fellowship. Service.';
    $metaDescription = $description ?? 'The MUST Catholic Students Organisation is a Catholic student community at MUST, shaped by faith, fellowship, and service.';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $metaDescription }}">
        <meta name="theme-color" content="#3a0e1c">

        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $metaDescription }}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="{{ $appName }}">

        <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="flex min-h-screen flex-col bg-ivory-50">
        <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:bg-burgundy-900 focus:px-4 focus:py-2 focus:text-ivory-50">
            Skip to content
        </a>

        <x-site-header />

        <main id="main-content" class="flex-1">
            <x-flash-status class="container-page mt-6" />

            {{ $slot }}
        </main>

        <x-site-footer />
    </body>
</html>
