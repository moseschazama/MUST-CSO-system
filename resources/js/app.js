/**
 * MUST CSO — small, dependency-free interactions.
 */
document.addEventListener('DOMContentLoaded', () => {
    stickyHeader();
    mobileMenu();
    scrollReveal();
    tabGroups();
    filters();
    lightbox();
    copyButtons();
});

/* Sticky header gains depth once the page is scrolled. */
function stickyHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;

    const update = () => header.classList.toggle('is-scrolled', window.scrollY > 8);
    update();
    window.addEventListener('scroll', update, { passive: true });
}

/* Mobile navigation panel. */
function mobileMenu() {
    const toggle = document.getElementById('menu-toggle');
    const panel = document.getElementById('mobile-menu');
    if (!toggle || !panel) return;

    const openIcon = document.getElementById('menu-icon-open');
    const closeIcon = document.getElementById('menu-icon-close');

    const setOpen = (open) => {
        panel.classList.toggle('hidden', !open);
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
        openIcon?.classList.toggle('hidden', open);
        closeIcon?.classList.toggle('hidden', !open);
    };

    toggle.addEventListener('click', () => setOpen(panel.classList.contains('hidden')));
    panel.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setOpen(false)));
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') setOpen(false);
    });
}

/* Fade sections in as they enter the viewport. */
function scrollReveal() {
    const items = document.querySelectorAll('.reveal');
    if (!items.length) return;

    if (!('IntersectionObserver' in window)) {
        items.forEach((item) => item.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        },
        { rootMargin: '0px 0px -8% 0px', threshold: 0.05 },
    );

    items.forEach((item) => observer.observe(item));
}

/* Tabbed panels: [data-tab-group] > [data-tab="key"], [data-panel="key"] */
function tabGroups() {
    document.querySelectorAll('[data-tab-group]').forEach((group) => {
        const tabs = group.querySelectorAll('[data-tab]');
        const panels = group.querySelectorAll('[data-panel]');

        tabs.forEach((tab) => {
            tab.addEventListener('click', () => {
                const key = tab.dataset.tab;
                tabs.forEach((t) => {
                    const active = t === tab;
                    t.classList.toggle('is-active', active);
                    t.setAttribute('aria-selected', String(active));
                });
                panels.forEach((panel) => panel.classList.toggle('hidden', panel.dataset.panel !== key));
            });
        });
    });
}

/* Category filters: [data-filter-group] with [data-filter], [data-category] */
function filters() {
    document.querySelectorAll('[data-filter-group]').forEach((group) => {
        const buttons = group.querySelectorAll('[data-filter]');
        const items = group.querySelectorAll('[data-category]');
        const empty = group.querySelector('[data-filter-empty]');

        buttons.forEach((button) => {
            button.addEventListener('click', () => {
                const filter = button.dataset.filter;
                let visible = 0;

                buttons.forEach((b) => b.classList.toggle('is-active', b === button));

                items.forEach((item) => {
                    const match = filter === 'all' || item.dataset.category === filter;
                    item.classList.toggle('hidden', !match);
                    if (match) visible += 1;
                });

                if (empty) empty.classList.toggle('hidden', visible > 0);
            });
        });
    });
}

/* Accessible image lightbox for the gallery grid. */
function lightbox() {
    const triggers = Array.from(document.querySelectorAll('[data-lightbox]'));
    if (!triggers.length) return;

    const overlay = document.createElement('div');
    overlay.className =
        'fixed inset-0 z-50 hidden items-center justify-center bg-ink-900/95 p-4 backdrop-blur-sm';
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');
    overlay.setAttribute('aria-label', 'Photo viewer');
    overlay.innerHTML = `
        <button type="button" data-lb-close class="absolute top-4 right-4 grid h-11 w-11 place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20" aria-label="Close viewer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-5 w-5"><path d="M18 6 6 18M6 6l12 12"/></svg>
        </button>
        <button type="button" data-lb-prev class="absolute left-3 top-1/2 grid h-12 w-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20" aria-label="Previous photo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-5 w-5"><path d="m15 18-6-6 6-6"/></svg>
        </button>
        <button type="button" data-lb-next class="absolute right-3 top-1/2 grid h-12 w-12 -translate-y-1/2 place-items-center rounded-full bg-white/10 text-white transition hover:bg-white/20" aria-label="Next photo">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-5 w-5"><path d="m9 18 6-6-6-6"/></svg>
        </button>
        <figure class="flex max-h-full w-full max-w-5xl flex-col items-center gap-3">
            <img data-lb-image src="" alt="" class="max-h-[78vh] w-auto max-w-full rounded-2xl object-contain shadow-2xl">
            <figcaption class="flex flex-wrap items-center justify-center gap-3 text-center text-sm text-white/80">
                <span data-lb-title></span>
                <a data-lb-link href="#" target="_blank" rel="noopener" class="inline-flex items-center gap-1 rounded-full border border-white/25 px-3 py-1 text-xs font-semibold text-white transition hover:bg-white/10">
                    Open in Google Drive
                </a>
            </figcaption>
        </figure>`;

    document.body.appendChild(overlay);

    const image = overlay.querySelector('[data-lb-image]');
    const caption = overlay.querySelector('[data-lb-title]');
    const link = overlay.querySelector('[data-lb-link]');
    let index = 0;

    const visibleTriggers = () => triggers.filter((t) => !t.closest('.hidden'));

    const show = (position) => {
        const list = visibleTriggers();
        if (!list.length) return;
        index = (position + list.length) % list.length;
        const trigger = list[index];
        image.src = trigger.dataset.lightbox;
        image.alt = trigger.dataset.alt || '';
        caption.textContent = trigger.dataset.title || '';
        link.href = trigger.dataset.drive || trigger.dataset.lightbox;
    };

    const open = (trigger) => {
        index = Math.max(0, visibleTriggers().indexOf(trigger));
        show(index);
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');
        document.body.style.overflow = 'hidden';
        overlay.querySelector('[data-lb-close]').focus();
    };

    const close = () => {
        overlay.classList.add('hidden');
        overlay.classList.remove('flex');
        document.body.style.overflow = '';
    };

    triggers.forEach((trigger) => trigger.addEventListener('click', () => open(trigger)));
    overlay.querySelector('[data-lb-close]').addEventListener('click', close);
    overlay.querySelector('[data-lb-prev]').addEventListener('click', () => show(index - 1));
    overlay.querySelector('[data-lb-next]').addEventListener('click', () => show(index + 1));
    overlay.addEventListener('click', (event) => {
        if (event.target === overlay) close();
    });
    window.addEventListener('keydown', (event) => {
        if (overlay.classList.contains('hidden')) return;
        if (event.key === 'Escape') close();
        if (event.key === 'ArrowLeft') show(index - 1);
        if (event.key === 'ArrowRight') show(index + 1);
    });
}

/* One-click copy (email address, etc.). */
function copyButtons() {
    document.querySelectorAll('[data-copy]').forEach((button) => {
        button.addEventListener('click', async () => {
            const value = button.dataset.copy;
            const label = button.querySelector('[data-copy-label]');
            const icon = button.querySelector('[data-copy-icon]');
            const original = label?.textContent;

            try {
                await navigator.clipboard.writeText(value);
            } catch {
                const field = document.createElement('textarea');
                field.value = value;
                document.body.appendChild(field);
                field.select();
                document.execCommand('copy');
                field.remove();
            }

            if (label) label.textContent = 'Copied!';
            icon?.classList.add('hidden');
            button.classList.add('is-copied');

            setTimeout(() => {
                if (label && original) label.textContent = original;
                icon?.classList.remove('hidden');
                button.classList.remove('is-copied');
            }, 1800);
        });
    });
}
