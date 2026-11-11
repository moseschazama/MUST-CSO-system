@props(['name', 'photo' => null, 'size' => 'h-16 w-16', 'class' => ''])

@php
    $initials = collect(preg_split('/\s+/', trim($name)))
        ->reject(fn ($part) => in_array(mb_strtolower($part), ['rev.', 'fr.', 'mr.', 'mrs.', 'ms.', 'dr.']))
        ->take(2)
        ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->implode('');

    $palettes = [
        'from-brand-400 to-brand-700',
        'from-emerald-400 to-teal-700',
        'from-gold-300 to-gold-600',
        'from-teal-400 to-brand-700',
        'from-brand-300 to-emerald-700',
    ];
    $palette = $palettes[crc32($name) % count($palettes)];
@endphp

@if ($photo)
    <img
        src="{{ $photo }}"
        alt="{{ $name }}"
        class="shrink-0 rounded-3xl object-cover ring-1 ring-slate-200 {{ $size }} {{ $class }}"
        loading="lazy"
    >
@else
    <div
        class="grid shrink-0 place-items-center rounded-3xl bg-gradient-to-br text-white ring-1 ring-white/20 {{ $palette }} {{ $size }} {{ $class }}"
        aria-hidden="true"
    >
        <span class="text-lg font-extrabold tracking-tight">{{ $initials ?: 'CSO' }}</span>
    </div>
@endif
