@props(['title' => null, 'description' => null, 'transparentHeader' => false])

@php
    $pageTitle = $title ? $title.' — '.config('cso.org.name') : config('cso.org.name').' — '.config('cso.org.tagline');
    $pageDescription = $description ?: config('cso.org.mission');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="theme-color" content="#2563eb">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('cso.org.name') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://drive.google.com">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:rounded-full focus:bg-brand-700 focus:px-5 focus:py-3 focus:text-sm focus:font-semibold focus:text-white">
        Skip to content
    </a>

    <x-site-header :transparent="$transparentHeader" />

    <main id="main">
        {{ $slot }}
    </main>

    <x-site-footer />
</body>
</html>
