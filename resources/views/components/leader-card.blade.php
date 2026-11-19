@props(['leader'])

<article class="group card card-hover flex h-full flex-col overflow-hidden">
    <div class="relative aspect-[4/5] w-full overflow-hidden bg-ivory-200">
        @if ($leader->photo_url)
            <img
                src="{{ $leader->photo_url }}"
                alt="{{ $leader->name }}"
                loading="lazy"
                @class([
                    'h-full w-full object-cover object-[center_18%] transition duration-700',
                    'group-hover:scale-[1.03]' => request()->routeIs('home'),
                    'group-hover:scale-[1.01]' => ! request()->routeIs('home'),
                ])
            >
        @else
            <div class="absolute inset-0 flex flex-col items-center justify-center gap-4 bg-[radial-gradient(circle_at_50%_20%,#fff8e6_0%,#f3ece1_55%,#e9e0d1_100%)]">
                <span class="grid h-24 w-24 place-items-center rounded-full border border-gold-300/80 bg-gradient-to-br from-gold-300 via-gold-400 to-gold-600 text-3xl font-extrabold text-white shadow-[inset_0_1px_0_rgba(255,255,255,.55),0_16px_36px_-16px_rgba(166,124,26,.65)]">
                    {{ $leader->initials ?: 'CSO' }}
                </span>
                <span class="text-[10px] font-bold tracking-[0.2em] text-gold-700/70 uppercase">Portrait coming soon</span>
            </div>
        @endif

        @if ($leader->tenure)
            <span class="absolute bottom-3 left-3 inline-flex items-center gap-1.5 rounded-full border border-white/50 bg-white/90 px-3 py-1 text-[10px] font-bold tracking-wide text-ink-900 shadow-sm backdrop-blur">
                <x-icon name="calendar-days" class="h-3 w-3 text-gold-600" />
                {{ $leader->tenure }}
            </span>
        @endif
    </div>

    <div class="flex flex-1 flex-col p-5">
        <p class="text-[10px] font-bold tracking-[0.18em] text-gold-600 uppercase">{{ $leader->role }}</p>
        <h3 class="mt-1 text-lg leading-tight font-extrabold text-ink-900">{{ $leader->name }}</h3>

        @if ($leader->bio)
            <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-ink-500">{{ $leader->bio }}</p>
        @endif

        @if ($leader->email)
            <a href="mailto:{{ $leader->email }}" class="mt-auto inline-flex items-center gap-2 pt-4 text-xs font-semibold text-brand-700 hover:text-brand-800">
                <x-icon name="mail" class="h-3.5 w-3.5" />
                {{ $leader->email }}
            </a>
        @endif
    </div>
</article>
