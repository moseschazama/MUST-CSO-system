<x-layouts.app title="News & Announcements" description="News, announcements and reports from the MUST Catholic Students Organization.">

    <x-page-hero
        eyebrow="News & announcements"
        title="Stories from our community."
        description="Announcements, formation notes and updates from the CSO executive."
        image="/images/gallery/1bdmVvE8P672fSMjPOwR9Uq08nZpL2B2b.jpg"
        breadcrumbs="News"
    />

    <section class="section container-page">
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('news') }}" @class(['chip', 'is-active' => ! $category])>All</a>
            @foreach ($categories as $key => $label)
                <a href="{{ route('news', ['category' => $key]) }}" @class(['chip', 'is-active' => $category === $key])>{{ $label }}</a>
            @endforeach
        </div>

        @if ($featured && ! $category)
            <div class="mt-10">
                <x-announcement-card :announcement="$featured" featured />
            </div>
        @endif

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($articles as $article)
                <x-announcement-card :announcement="$article" :seed="$loop->iteration" />
            @empty
                <p class="col-span-full text-center text-ink-500">No articles in this category yet.</p>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $articles->links() }}
        </div>

        <div class="mt-16 grid gap-8 lg:grid-cols-2">
            <div>
                <x-section-heading eyebrow="Upcoming" title="Events on the calendar" />
                <ul class="mt-6 space-y-3">
                    @foreach ($events as $upcomingEvent)
                        <li class="card p-4">
                            <a href="{{ route('events.show', $upcomingEvent) }}" class="flex items-center justify-between gap-4">
                                <span class="font-bold text-ink-900">{{ $upcomingEvent->title }}</span>
                                <span class="text-xs text-ink-500">{{ $upcomingEvent->starts_at->format('d M Y') }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div>
                <x-section-heading eyebrow="Resources" title="Latest reports" />
                <ul class="mt-6 space-y-3">
                    @forelse ($reports as $report)
                        <li class="card p-4">
                            <a href="{{ route('documents.report', $report) }}" class="flex items-center justify-between gap-4">
                                <span>
                                    <span class="block font-bold text-ink-900">{{ $report->title }}</span>
                                    <span class="mt-0.5 block text-xs text-ink-500">{{ $report->activity_date->format('d M Y') }}</span>
                                </span>
                                <span class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-brand-50 text-brand-700">
                                    <x-icon name="download" class="h-4 w-4" />
                                </span>
                            </a>
                        </li>
                    @empty
                        <li class="text-sm text-ink-500">No reports published yet.</li>
                    @endforelse
                </ul>
                <a href="{{ route('leadership') }}" class="mt-4 inline-flex items-center gap-1 text-sm font-bold text-brand-700 hover:text-brand-800">
                    M’Phakati lists
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>
        </div>
    </section>
</x-layouts.app>
