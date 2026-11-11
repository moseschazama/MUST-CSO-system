@props(['announcement'])

@php
    $levels = [
        'urgent' => [
            'wrap' => 'border-rose-200/80 bg-rose-50/70',
            'badge' => 'bg-rose-600 text-white',
            'icon' => 'flame',
            'label' => 'Urgent',
        ],
        'notice' => [
            'wrap' => 'border-gold-300/70 bg-gold-100/50',
            'badge' => 'bg-gold-500 text-white',
            'icon' => 'sparkles',
            'label' => 'Notice',
        ],
        'info' => [
            'wrap' => 'border-brand-200/70 bg-brand-50/60',
            'badge' => 'bg-brand-600 text-white',
            'icon' => 'message-circle',
            'label' => 'Info',
        ],
    ];
    $style = $levels[$announcement->level] ?? $levels['info'];
@endphp

<article class="rounded-3xl border p-6 {{ $style['wrap'] }}">
    <div class="flex flex-wrap items-center gap-2">
        <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[10px] font-bold tracking-wider uppercase {{ $style['badge'] }}">
            <x-icon :name="$style['icon']" class="h-3 w-3" />
            {{ $style['label'] }}
        </span>
        <span class="text-xs font-semibold text-ink-500">
            {{ $announcement->published_at->format('j M Y') }}
        </span>
    </div>

    <h3 class="mt-3 text-base font-extrabold text-ink-900">{{ $announcement->title }}</h3>
    <p class="mt-2 text-sm leading-relaxed text-ink-500">{{ $announcement->body }}</p>
</article>
