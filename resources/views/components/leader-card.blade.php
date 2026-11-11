@props(['leader'])

<article class="card card-hover flex h-full flex-col p-6">
    <div class="flex items-start gap-4">
        <x-avatar :name="$leader->name" :photo="$leader->photo" size="h-16 w-16" />

        <div class="min-w-0">
            <h3 class="truncate text-base font-extrabold text-ink-900">{{ $leader->name }}</h3>
            <p class="mt-1 text-sm font-semibold text-brand-700">{{ $leader->role }}</p>
            @if ($leader->tenure)
                <span class="chip mt-2">
                    <x-icon name="calendar-days" class="h-3 w-3" />
                    {{ $leader->tenure }}
                </span>
            @endif
        </div>
    </div>

    @if ($leader->bio)
        <p class="mt-4 text-sm leading-relaxed text-ink-500">{{ $leader->bio }}</p>
    @endif

    @if ($leader->email)
        <a href="mailto:{{ $leader->email }}" class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-brand-700 hover:text-brand-800">
            <x-icon name="mail" class="h-4 w-4" />
            {{ $leader->email }}
        </a>
    @endif
</article>
