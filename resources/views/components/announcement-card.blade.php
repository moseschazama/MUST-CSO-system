@props(['announcement', 'seed' => 0, 'featured' => false])

<article @class(['media-card group', 'lg:flex-row' => $featured])>
    <x-media-frame
        :image="$announcement->image_url"
        :alt="$announcement->title"
        :seed="$seed + (int) $announcement->id"
        :ratio="$featured ? 'aspect-[16/10] lg:aspect-auto lg:h-full lg:min-h-[22rem] lg:w-1/2' : 'aspect-[16/10]'"
    >
        <div class="absolute inset-x-0 top-0 z-10 flex items-start justify-between gap-2 p-4">
            <span class="media-badge">{{ $announcement->category_label }}</span>
            @if ($announcement->is_featured)
                <span class="media-badge media-badge-gold">
                    <x-icon name="star" class="h-3 w-3" />
                    Featured
                </span>
            @endif
        </div>

        <div class="absolute inset-x-0 bottom-0 z-10 p-4">
            <p class="inline-flex items-center gap-1.5 text-[11px] font-bold text-white/85">
                <x-icon name="calendar-days" class="h-3 w-3" />
                {{ $announcement->published_at?->format('d M Y') }}
            </p>
        </div>
    </x-media-frame>

    <div @class(['flex flex-1 flex-col p-5 sm:p-6', 'lg:justify-center lg:p-8' => $featured])>
        @if ($featured)
            <p class="eyebrow">Featured story</p>
        @endif

        <h3 @class([
            'font-extrabold leading-snug text-ink-900',
            'mt-3 text-2xl sm:text-3xl' => $featured,
            'text-lg' => ! $featured,
        ])>
            <a href="{{ route('news.show', $announcement) }}" class="transition hover:text-brand-700">{{ $announcement->title }}</a>
        </h3>

        <p @class([
            'mt-2 leading-relaxed text-ink-500',
            'line-clamp-3 text-[15px]' => $featured,
            'line-clamp-2 text-sm' => ! $featured,
        ])>
            {{ $announcement->excerpt_text }}
        </p>

        <div class="mt-auto flex items-center justify-between gap-3 pt-5">
            <span class="text-[11px] font-semibold text-ink-500">
                {{ $announcement->published_at?->format('D d M Y') }}
            </span>
            <a href="{{ route('news.show', $announcement) }}"
               class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-700 transition hover:gap-2.5 hover:text-brand-800">
                Read story
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>
    </div>
</article>
