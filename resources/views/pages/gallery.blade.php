@php
    $categoryCounts = $photos->countBy('category');
@endphp

<x-layouts.app title="Gallery" description="Photos from Holy Mass, devotions, meetings and other CSO activities, plus links to the full Google Drive albums.">

    <x-page-hero
        eyebrow="Gallery"
        title="Moments from our community."
        description="Browse photos from Mass, devotions, meetings and outreach. Click any photo to view it larger, or open the full Google Drive albums."
    />

    {{-- ===== Albums / Drive cards ===== --}}
    <section class="section container-page">
        <div class="flex flex-wrap items-end justify-between gap-6">
            <x-section-heading eyebrow="Google Drive media hub" title="Full albums & folders" />
        </div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($albums as $album)
                <a
                    href="https://drive.google.com/drive/folders/{{ $album['folder_id'] }}"
                    target="_blank"
                    rel="noopener"
                    class="card card-hover group flex flex-col p-6"
                >
                    <div class="flex items-center justify-between">
                        <span class="icon-badge">
                            <x-icon name="images" class="h-5 w-5" />
                        </span>
                        <x-icon name="arrow-up-right" class="h-4 w-4 text-ink-500 transition group-hover:text-brand-700" />
                    </div>
                    <h3 class="mt-4 text-base font-extrabold text-ink-900">{{ $album['label'] }}</h3>
                    <p class="mt-1 text-sm text-ink-500">{{ $album['category'] }}</p>
                    <div class="mt-4 flex items-center justify-between text-xs font-semibold">
                        <span class="chip">
                            <x-icon name="images" class="h-3 w-3" />
                            {{ number_format($album['total']) }} photos
                        </span>
                        <span class="text-brand-700">Open folder</span>
                    </div>
                </a>
            @endforeach

            @foreach (config('cso.drive.folders') as $folder)
                @if ($folder['url'] && ! in_array($folder['key'], ['gallery']))
                    <a
                        href="{{ $folder['url'] }}"
                        target="_blank"
                        rel="noopener"
                        class="card card-hover group flex flex-col p-6"
                    >
                        <div class="flex items-center justify-between">
                            <span class="icon-badge">
                                <x-icon :name="$folder['icon']" class="h-5 w-5" />
                            </span>
                            <x-icon name="arrow-up-right" class="h-4 w-4 text-ink-500 transition group-hover:text-brand-700" />
                        </div>
                        <h3 class="mt-4 text-base font-extrabold text-ink-900">{{ $folder['title'] }}</h3>
                        <p class="mt-1 text-sm text-ink-500">{{ $folder['description'] }}</p>
                        <span class="mt-4 text-xs font-bold text-brand-700">Open in Drive &rarr;</span>
                    </a>
                @elseif (! $folder['url'])
                    <div class="card flex flex-col p-6 opacity-60">
                        <div class="flex items-center justify-between">
                            <span class="icon-badge">
                                <x-icon :name="$folder['icon']" class="h-5 w-5" />
                            </span>
                            <span class="chip">Coming soon</span>
                        </div>
                        <h3 class="mt-4 text-base font-extrabold text-ink-900">{{ $folder['title'] }}</h3>
                        <p class="mt-1 text-sm text-ink-500">{{ $folder['description'] }}</p>
                        <p class="mt-4 text-xs text-ink-500">
                            Add the folder link in <code class="rounded bg-slate-100 px-1.5 py-0.5">config/cso.php</code>.
                        </p>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    {{-- ===== Filterable grid ===== --}}
    <section class="section container-page bg-slate-50/60 sm:rounded-[2.5rem]">
        <div data-filter-group>
            <div class="flex flex-wrap items-center gap-2">
                <button type="button" data-filter="all" class="is-active inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold transition">
                    All photos
                    <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-bold text-ink-500">{{ $photos->count() }}</span>
                </button>
                @foreach ($categories as $category)
                    <button type="button" data-filter="{{ $category }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold transition">
                        {{ $category }}
                        <span class="rounded-full bg-slate-100 px-2 py-0.5 text-[11px] font-bold text-ink-500">
                            {{ $categoryCounts->get($category, 0) }}
                        </span>
                    </button>
                @endforeach
            </div>

            <div class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                @foreach ($photos as $photo)
                    <button
                        type="button"
                        data-category="{{ $photo->category }}"
                        data-lightbox="{{ $photo->full_image }}"
                        data-title="{{ $photo->title }}"
                        data-alt="{{ $photo->alt }}"
                        data-drive="{{ $photo->drive_url }}"
                        class="group relative aspect-square overflow-hidden rounded-2xl bg-slate-100"
                    >
                        <img
                            src="{{ $photo->thumbnail }}"
                            alt="{{ $photo->alt }}"
                            loading="lazy"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-110"
                        >
                        <span class="absolute inset-0 bg-ink-900/0 transition group-hover:bg-ink-900/25"></span>
                        <span class="absolute bottom-2 left-2 rounded-full bg-ink-900/70 px-2 py-0.5 text-[10px] font-bold text-white opacity-0 backdrop-blur transition group-hover:opacity-100">
                            {{ \Illuminate\Support\Str::limit($photo->category, 18) }}
                        </span>
                    </button>
                @endforeach
            </div>

            <p data-filter-empty class="hidden mt-8 text-center text-sm text-ink-500">
                No photos in this category yet.
            </p>
        </div>
    </section>
</x-layouts.app>
