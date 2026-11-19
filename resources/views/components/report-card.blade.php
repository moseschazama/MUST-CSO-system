@props(['report'])

<article class="card card-hover flex h-full flex-col overflow-hidden">
    @if ($report->cover_image_url)
        <div class="relative aspect-[16/9] overflow-hidden bg-slate-100">
            <img
                src="{{ $report->cover_image_url }}"
                alt="{{ $report->title }}"
                loading="lazy"
                @class([
                    'h-full w-full object-cover transition duration-500',
                    'hover:scale-105' => request()->routeIs('home'),
                    'hover:scale-[1.02]' => ! request()->routeIs('home'),
                ])
                style="object-position: center 22%;"
            >
            <span class="absolute top-3 left-3 rounded-full bg-ink-900/80 px-3 py-1 text-[11px] font-bold text-white backdrop-blur">
                {{ $report->activity_date->format('j M Y') }}
            </span>
        </div>
    @endif

    <div class="flex flex-1 flex-col p-6">
        <h3 class="text-base font-extrabold text-ink-900">{{ $report->title }}</h3>
        <p class="mt-2 text-sm leading-relaxed text-ink-500">{{ $report->summary }}</p>

        @if (! empty($report->highlights))
            <details class="group mt-4">
                <summary class="flex cursor-pointer list-none items-center gap-2 text-xs font-bold tracking-wide text-brand-700 uppercase">
                    <x-icon name="chevron-right" class="h-4 w-4 transition group-open:rotate-90" />
                    Activity highlights
                </summary>
                <ul class="mt-3 space-y-2">
                    @foreach ($report->highlights as $highlight)
                        <li class="flex items-start gap-2 text-sm text-ink-500">
                            <x-icon name="check" class="mt-0.5 h-4 w-4 shrink-0 text-brand-600" />
                            {{ $highlight }}
                        </li>
                    @endforeach
                </ul>
            </details>
        @endif

        <div class="mt-auto flex flex-wrap gap-2 pt-5">
            <a href="{{ route('documents.report', $report) }}" class="btn-primary btn-sm">
                <x-icon name="download" class="h-4 w-4" />
                Download PDF
            </a>
            <span class="chip self-center">{{ $report->activity_date->format('j M Y') }}</span>
        </div>
    </div>
</article>
