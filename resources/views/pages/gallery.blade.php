@php
    $categoryCounts = $photos->countBy('category');
@endphp

<x-layouts.app title="Gallery" description="Photos from Holy Mass, devotions, meetings and other CSO activities.">

    <x-page-hero
        eyebrow="Gallery"
        title="Moments from our community."
        description="Browse photos from Mass, devotions, meetings and outreach. Click any photo to view it larger."
        image="/images/gallery/12usmszhcdLinTYwV3RjQD3rObfSgeLQL.jpg"
        breadcrumbs="Gallery"
    />

    {{-- ===== Featured moments ===== --}}
    @if ($featuredPhotos->isNotEmpty())
        <section class="section container-page pb-0">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-section-heading eyebrow="Featured moments" title="The CSO, alive and together." />
                <a href="#gallery-grid" class="btn-ghost btn-sm">
                    Browse all photos
                    <x-icon name="arrow-right" class="h-4 w-4" />
                </a>
            </div>

            <div class="mt-8 grid auto-rows-[8rem] grid-cols-2 gap-3 sm:auto-rows-[10rem] lg:grid-cols-4 lg:auto-rows-[12rem]">
                @foreach ($featuredPhotos as $photo)
                    <button
                        type="button"
                        data-lightbox="{{ $photo->full_image }}"
                        data-title="{{ $photo->title }}"
                        data-alt="{{ $photo->alt }}"
                        @class([
                            'group relative overflow-hidden rounded-3xl bg-slate-100',
                            'col-span-2 row-span-2' => $loop->first,
                        ])
                    >
                        <img
                            src="{{ $photo->thumbnail }}"
                            alt="{{ $photo->alt }}"
                            loading="lazy"
                            class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.02]"
                            style="object-position: center 20%;"
                        >
                        <span class="media-shade"></span>
                        <span class="absolute inset-x-0 bottom-0 p-4 text-left">
                            <span class="media-badge">{{ $photo->category }}</span>
                            <span class="mt-2 block text-sm font-extrabold text-white">{{ $photo->title }}</span>
                        </span>
                        <span class="absolute top-4 right-4 grid h-10 w-10 place-items-center rounded-full bg-white/90 text-brand-800 opacity-0 shadow-lg transition group-hover:opacity-100">
                            <x-icon name="images" class="h-4 w-4" />
                        </span>
                    </button>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== Album previews ===== --}}
    @if ($photoAlbums->isNotEmpty())
        <section class="section container-page pb-0">
            <div class="flex flex-wrap items-end justify-between gap-6">
                <x-section-heading eyebrow="Albums" title="Step inside a gathering." />
                <span class="chip"><x-icon name="images" class="h-3.5 w-3.5" /> {{ $photos->count() }} photos on the site</span>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($photoAlbums as $album)
                    <a href="#gallery-grid" class="media-card group">
                        <div class="album-mosaic aspect-[16/10] overflow-hidden">
                            @foreach ($album['photos'] as $albumPhoto)
                                <img
                                    src="{{ $albumPhoto->thumbnail }}"
                                    alt="{{ $albumPhoto->alt }}"
                                    loading="lazy"
                                    class="h-full w-full object-cover transition duration-700 group-hover:scale-[1.02]"
                                    style="object-position: center 20%;"
                                >
                            @endforeach
                        </div>
                        <div class="flex flex-1 flex-col p-5">
                            <span class="eyebrow">{{ $album['category'] }}</span>
                            <h3 class="mt-2 text-base font-extrabold text-ink-900">{{ $album['label'] }}</h3>
                            <div class="mt-4 flex items-center justify-between text-xs font-bold">
                                <span class="chip">{{ $album['count'] }} photos</span>
                                <span class="inline-flex items-center gap-1.5 text-brand-700 transition group-hover:gap-2.5">
                                    View album
                                    <x-icon name="arrow-right" class="h-4 w-4" />
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    {{-- ===== Filterable grid ===== --}}
    <section id="gallery-grid" class="section container-page scroll-mt-28">
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
                        class="group relative aspect-square overflow-hidden rounded-2xl bg-slate-100"
                    >
                        <img
                            src="{{ $photo->thumbnail }}"
                            alt="{{ $photo->alt }}"
                            loading="lazy"
                            class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.03]"
                            style="object-position: center 20%;"
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
