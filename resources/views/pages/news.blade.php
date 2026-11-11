<x-layouts.app title="News & Events" description="Announcements, upcoming events and reports on past activities of MUST CSO.">

    <x-page-hero
        eyebrow="News & events"
        title="What is happening in the CSO."
        description="Announcements, the events calendar, and reports on the activities that have shaped our year."
    />

    {{-- ===== Announcements ===== --}}
    <section class="section container-page">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading eyebrow="Notice board" title="Announcements" />
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($announcements as $announcement)
                <x-announcement-card :announcement="$announcement" />
            @empty
                <p class="text-sm text-ink-500">No announcements at the moment.</p>
            @endforelse
        </div>
    </section>

    {{-- ===== Upcoming events ===== --}}
    <section class="section container-page bg-slate-50/60 sm:rounded-[2.5rem]">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading eyebrow="Calendar" title="Upcoming events" />
            <a href="https://calendar.google.com" target="_blank" rel="noopener" class="btn-ghost btn-sm">
                <x-icon name="calendar-days" class="h-4 w-4" />
                Google Calendar
            </a>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($events as $event)
                <x-event-card :event="$event" />
            @empty
                <p class="text-sm text-ink-500">No upcoming events have been announced.</p>
            @endforelse
        </div>
    </section>

    {{-- ===== Past reports ===== --}}
    <section class="section container-page">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading
                eyebrow="Reports on past activities"
                title="Where we have been"
                description="Highlights from recent retreats, charity visits and campus events."
            />
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($reports as $report)
                <x-report-card :report="$report" />
            @empty
                <p class="text-sm text-ink-500">No reports published yet.</p>
            @endforelse
        </div>
    </section>
</x-layouts.app>
