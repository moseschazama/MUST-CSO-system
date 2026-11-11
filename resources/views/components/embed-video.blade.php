@props(['src' => null, 'poster' => null])

@if (filled($src))
    <div class="relative overflow-hidden rounded-full ring-1 ring-white/20 shadow-[0_30px_60px_-20px_rgba(0,0,0,.6)]">
        <video
            src="{{ $src }}"
            poster="{{ $poster }}"
            class="h-32 w-56 sm:h-40 sm:w-64 lg:h-48 lg:w-72 object-cover"
            autoplay
            muted
            loop
            playsinline
        >
            Your browser does not support the video element.
        </video>

        <button
            type="button"
            class="absolute inset-0 flex h-full w-full items-center justify-center gap-2 rounded-full bg-black/0 transition group-hover:bg-black/40 group-focus-within:bg-black/40"
            aria-label="Play video of MUST CSO Holy Mass community gathering"
        >
            <span class="grid h-10 w-10 place-items-center rounded-full bg-brand-500/80 text-white transition group-hover:bg-brand-500 group-focus-within:bg-brand-500">
                <x-icon name="play" class="h-4 w-4" />
            </span>
        </button>

        <span class="absolute bottom-3 left-1/2 -translate-x-1/2 text-[10px] font-bold tracking-[0.2em] text-white/80 uppercase drop-shadow">
            Holy Mass
        </span>
    </div>
@endif
