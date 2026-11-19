<x-layouts.app title="Documents & PDFs" description="Download MUST CSO reports, project and activity summaries, and M'Phakati member lists as PDFs.">

    <x-page-hero
        eyebrow="Documents & downloads"
        title="Take the CSO with you."
        description="Reports, project summaries and M’Phakati member lists, ready to download and share as PDFs."
        image="/images/gallery/13ARXsk4YZ57neLGHEKsZ4lU03-reuBbz.jpg"
        breadcrumbs="Documents"
    />

    <section class="section container-page">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading
                eyebrow="Reports"
                title="Reports on past activities"
                description="Published reports from Mass, fellowship, charity visits and campus gatherings."
            />
            <a href="{{ route('news') }}" class="btn-ghost btn-sm">
                Read the news
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @forelse ($reports as $report)
                <article class="card flex flex-col gap-4 p-5 sm:flex-row sm:items-center">
                    @if ($report->cover_image_url)
                        <img
                            src="{{ $report->cover_image_url }}"
                            alt="{{ $report->title }}"
                            loading="lazy"
                            class="aspect-[4/3] h-auto w-full shrink-0 rounded-2xl object-cover sm:h-28 sm:w-44"
                            style="object-position: center 22%;"
                        >
                    @endif

                    <div class="min-w-0 flex-1">
                        <p class="text-[10px] font-bold tracking-[0.16em] text-brand-700 uppercase">{{ $report->activity_date->format('j F Y') }}</p>
                        <h3 class="mt-1 text-base font-extrabold text-ink-900">{{ $report->title }}</h3>
                        <p class="mt-1 line-clamp-2 text-sm leading-relaxed text-ink-500">{{ $report->summary }}</p>
                    </div>

                    <a href="{{ route('documents.report', $report) }}" class="btn-primary btn-sm shrink-0">
                        <x-icon name="download" class="h-4 w-4" />
                        PDF
                    </a>
                </article>
            @empty
                <p class="text-sm text-ink-500">No reports have been published yet.</p>
            @endforelse
        </div>
    </section>

    <section class="section container-page bg-slate-50/60 sm:rounded-[2.5rem]">
        <div class="grid gap-6 lg:grid-cols-[1.4fr_1fr] lg:items-center">
            <div>
                <x-section-heading
                    eyebrow="Projects & activities"
                    title="Our life, in one document"
                    description="A printable summary of the liturgical schedule, devotions, meetings, fellowship and outreach programmes."
                />
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="chip">Holy Mass &amp; liturgy</span>
                    <span class="chip">Devotions &amp; prayer</span>
                    <span class="chip">Meetings &amp; fellowship</span>
                    <span class="chip">Charity &amp; outreach</span>
                </div>
            </div>

            <div class="card p-6 sm:p-8">
                <span class="icon-badge h-12 w-12 rounded-2xl">
                    <x-icon name="file-text" class="h-5 w-5" />
                </span>
                <h3 class="mt-4 text-lg font-extrabold text-ink-900">Projects &amp; activities PDF</h3>
                <p class="mt-2 text-sm leading-relaxed text-ink-500">Download the full public schedule with days, times, venues and descriptions.</p>
                <a href="{{ route('documents.projects') }}" class="btn-primary mt-5 w-full">
                    <x-icon name="download" class="h-4 w-4" />
                    Download activities PDF
                </a>
            </div>
        </div>
    </section>

    <section class="section container-page">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading
                eyebrow="M’Phakati"
                title="Small Christian community lists"
                description="Approved members allocated to each M’Phakati. Contact details are omitted to protect privacy."
            />
            <a href="{{ route('leadership') }}" class="btn-ghost btn-sm">
                Meet the leadership
                <x-icon name="arrow-right" class="h-4 w-4" />
            </a>
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($groups as $group)
                <article class="card flex h-full flex-col p-6">
                    <div class="flex items-start justify-between gap-4">
                        <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gold-100 text-gold-700 ring-1 ring-gold-300/50">
                            <x-icon name="users" class="h-5 w-5" />
                        </span>
                        <span class="chip">{{ $group['count'] }} {{ \Illuminate\Support\Str::plural('member', $group['count']) }}</span>
                    </div>
                    <h3 class="mt-4 text-base font-extrabold text-ink-900">{{ $group['name'] }}</h3>
                    <p class="mt-1 text-sm text-ink-500">M’Phakati member list</p>
                    <a href="{{ route('documents.mphakati', ['group' => $group['name']]) }}" class="btn-ghost btn-sm mt-auto pt-5">
                        <x-icon name="download" class="h-4 w-4" />
                        Download PDF
                    </a>
                </article>
            @empty
                <div class="col-span-full rounded-2xl border border-slate-200/70 bg-slate-50/70 p-6">
                    <p class="text-sm font-bold text-ink-900">No M’Phakati member lists yet.</p>
                    <p class="mt-1 text-sm text-ink-500">Lists appear here once approved members are allocated to a M’Phakati by the CSO leadership.</p>
                </div>
            @endforelse
        </div>

        <p class="mt-8 text-xs leading-relaxed text-ink-500">
            PDFs are generated from the latest published content on this website. Member lists include approved members only and never include phone numbers or email addresses.
        </p>
    </section>
</x-layouts.app>
