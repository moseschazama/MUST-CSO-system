<div id="reflection-modal" class="fixed inset-0 z-[70] hidden items-center justify-center bg-ink-950/90 p-4 backdrop-blur-sm sm:p-6" role="dialog" aria-modal="true" aria-label="Daily reflection" aria-hidden="true">
    <div class="flex max-h-[92vh] w-full max-w-4xl flex-col overflow-hidden rounded-3xl bg-white shadow-[0_40px_100px_-30px_rgba(0,0,0,.7)] ring-1 ring-white/20">
        <div class="flex items-start justify-between gap-4 border-b border-slate-200/70 bg-gradient-to-r from-brand-950 to-brand-900 px-5 py-4 text-white sm:px-6">
            <div class="min-w-0">
                <p class="text-[10px] font-bold tracking-[0.18em] text-gold-300 uppercase" data-reflection-modal-date>Daily reflection</p>
                <h3 class="mt-1 text-lg font-extrabold leading-snug text-white sm:text-xl" data-reflection-modal-title>Daily Reflection</h3>
                <p class="mt-1 text-xs font-medium text-white/75" data-reflection-modal-subtitle></p>
            </div>
            <div class="flex shrink-0 items-center gap-2">
                <a href="#" target="_blank" rel="noopener" class="hidden rounded-full border border-white/15 bg-white/10 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-white/15 sm:inline-flex" data-reflection-modal-source>View source</a>
                <button type="button" class="grid h-9 w-9 place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20" data-reflection-modal-close aria-label="Close reflection">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-4 w-4"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <div class="min-h-0 flex-1 overflow-y-auto px-5 py-5 sm:px-8 sm:py-7" data-reflection-modal-scroll>
            <div class="reflection-content prose prose-slate max-w-none prose-headings:font-extrabold prose-headings:text-ink-900 prose-p:leading-relaxed prose-a:text-brand-700 hover:prose-a:text-brand-800 prose-img:rounded-2xl" data-reflection-modal-body>
                <p class="text-sm text-ink-500">Loading reflection…</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200/70 bg-slate-50/80 px-5 py-3 sm:px-6">
            <p class="text-xs text-ink-500">Source: <a href="https://catholic-daily-reflections.com/" target="_blank" rel="noopener" class="font-semibold text-brand-700 hover:text-brand-800">Catholic Daily Reflections</a></p>
            <a href="#" target="_blank" rel="noopener" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-700 hover:text-brand-800 sm:hidden" data-reflection-modal-source-mobile>
                View source
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-3.5 w-3.5"><path d="M7 17 17 7"/><path d="M7 7h10v10"/></svg>
            </a>
        </div>
    </div>
</div>