@props(['eyebrow' => null, 'title' => null, 'description' => null])

<section class="relative overflow-hidden border-b border-slate-100">
    <div class="glow top-[-10rem] right-[-6rem] h-96 w-96 bg-brand-400/20"></div>
    <div class="glow top-[-6rem] left-[-8rem] h-80 w-80 bg-gold-300/20"></div>

    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.07),_transparent_55%)]"></div>

    <div class="container-page py-14 sm:py-20">
        <div class="max-w-3xl">
            @if ($eyebrow)
                <span class="pill">
                    <span class="h-1.5 w-1.5 rounded-full bg-brand-500"></span>
                    {{ $eyebrow }}
                </span>
            @endif

            <h1 class="mt-5 text-4xl leading-[1.05] font-extrabold text-balance text-ink-900 sm:text-5xl lg:text-[3.4rem]">
                {{ $title }}
            </h1>

            @if ($description)
                <p class="lead mt-5 max-w-2xl">{{ $description }}</p>
            @endif

            @isset($actions)
                <div class="mt-8 flex flex-wrap gap-3">{{ $actions }}</div>
            @endisset
        </div>

        {{ $slot }}
    </div>
</section>
