<x-layouts.app title="{{ $article->title }}" description="{{ $article->excerpt }}">

    <article>
        <section class="relative isolate flex min-h-[380px] items-end overflow-hidden bg-brand-950 sm:min-h-[430px] lg:min-h-[480px]">
            @if ($article->image)
                <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}" class="absolute inset-0 -z-20 h-full w-full object-cover" style="object-position: center 22%;">
            @endif
            <div class="absolute inset-0 -z-10 bg-gradient-to-r from-ink-950/92 via-brand-950/82 to-brand-900/55"></div>
            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-ink-950/75 via-ink-900/20 to-ink-950/30"></div>
            <div class="pointer-events-none absolute -right-20 -top-20 -z-10 h-72 w-72 rounded-full bg-brand-400/20 blur-3xl"></div>
            <div class="container-page relative w-full pt-28 pb-14 sm:pt-32 sm:pb-16 lg:pt-36 lg:pb-20">
                <div class="max-w-4xl">
                    <nav aria-label="Breadcrumb" class="mb-6">
                        <ol class="flex flex-wrap items-center gap-x-2 gap-y-1 text-[11px] font-bold tracking-[0.16em] text-white/65 uppercase">
                            <li><a href="{{ route('home') }}" class="transition hover:text-white">Home</a></li>
                            <li aria-hidden="true" class="text-white/30"><x-icon name="chevron-right" class="h-3.5 w-3.5" /></li>
                            <li><a href="{{ route('news') }}" class="transition hover:text-white">News</a></li>
                            <li aria-hidden="true" class="text-white/30"><x-icon name="chevron-right" class="h-3.5 w-3.5" /></li>
                            <li class="min-w-0 text-white/95" aria-current="page">{{ $article->title }}</li>
                        </ol>
                    </nav>
                    <span class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-1.5 text-[10px] font-bold tracking-[0.2em] text-white/90 uppercase backdrop-blur-sm">
                        <span class="h-1.5 w-1.5 rounded-full bg-gold-400"></span>
                        {{ $article->category_label }}
                    </span>
                    <h1 class="mt-5 max-w-3xl text-4xl leading-[1.05] font-extrabold text-balance text-white sm:text-5xl lg:text-[3.25rem]">{{ $article->title }}</h1>
                    <p class="mt-4 text-sm font-semibold tracking-wide text-white/75">{{ $article->published_at?->format('d F Y') }}</p>
                </div>
            </div>
        </section>

        <section class="section container-page">
            <div class="mx-auto max-w-3xl">
                <div class="prose max-w-none text-[15px] leading-relaxed text-ink-700">
                    {!! nl2br(e($article->body)) !!}
                </div>

                @if ($related->isNotEmpty())
                    <div class="mt-12 border-t border-slate-200 pt-8">
                        <p class="eyebrow">Related reading</p>
                        <ul class="mt-4 grid gap-4 sm:grid-cols-2">
                            @foreach ($related as $relatedArticle)
                                <li class="card p-4">
                                    <a href="{{ route('news.show', $relatedArticle) }}" class="block">
                                        <p class="font-bold text-ink-900">{{ $relatedArticle->title }}</p>
                                        <p class="mt-1 text-xs text-ink-500">{{ $relatedArticle->published_at?->format('d M Y') }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </section>
    </article>
</x-layouts.app>
