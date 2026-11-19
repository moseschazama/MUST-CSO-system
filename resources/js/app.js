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
    videoPreviews();
    reflectionModal();
    memberSearch();
    heroBackgroundRotator();
    cinematicVideos();
    copyButtons();
    schoolProgrammes();
});

/* Membership form: school → department → programme cascading selects. */
function schoolProgrammes() {
    const data = document.getElementById('academic-data');
    const school = document.querySelector('[data-school-select]');
    const department = document.querySelector('[data-department-select]');
    const programme = document.querySelector('[data-programme-select]');

    if (!data || !school || !department || !programme) return;

    const schools = JSON.parse(data.textContent);

    const fill = (select, values, placeholder) => {
        const previous = select.value;
        select.innerHTML = '';
        select.append(new Option(placeholder, '', true, true));
        select.options[0].disabled = true;

        values.forEach((value) => select.append(new Option(value, value)));

        if (values.includes(previous)) select.value = previous;
        select.disabled = values.length === 0;
    };

    const sync = () => {
        const entry = schools[school.value];
        fill(department, entry ? entry.departments : [], entry ? 'Select department' : 'Choose a school first');
        fill(programme, entry ? entry.programmes : [], entry ? 'Select programme' : 'Choose a school first');
    };

    school.addEventListener('change', sync);

    if (school.value) {
        const entry = schools[school.value];
        if (entry) {
            fill(department, entry.departments, 'Select department');
            fill(programme, entry.programmes, 'Select programme');
        }
    }
}

/* Sticky/floating header gains depth once the page is scrolled. */
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
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) setOpen(false);
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
            </figcaption>
        </figure>`;

    document.body.appendChild(overlay);

    const image = overlay.querySelector('[data-lb-image]');
    const caption = overlay.querySelector('[data-lb-title]');
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

/* Elegant video preview modal used by featured activity/event media. */
function videoPreviews() {
    const triggers = Array.from(document.querySelectorAll('[data-video-preview]'));
    if (!triggers.length) return;

    const overlay = document.createElement('div');
    overlay.className = 'video-modal';
    overlay.setAttribute('role', 'dialog');
    overlay.setAttribute('aria-modal', 'true');
    overlay.setAttribute('aria-label', 'Video preview');
    overlay.innerHTML = `
        <div class="video-modal-panel">
            <div class="flex items-center justify-between gap-4 bg-ink-900 px-4 py-3 text-white sm:px-5">
                <p data-video-title class="truncate text-sm font-bold"></p>
                <button type="button" data-video-close class="grid h-9 w-9 shrink-0 place-items-center rounded-full bg-white/10 transition hover:bg-white/20" aria-label="Close video preview">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="h-4 w-4"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="video-modal-stage">
                <video data-video-player controls playsinline preload="metadata"></video>
                <div data-video-loader class="video-loader">
                    <span class="video-spinner" aria-hidden="true"></span>
                    <span class="text-xs font-semibold tracking-wide text-white/80">Loading preview…</span>
                </div>
            </div>
        </div>`;

    document.body.appendChild(overlay);

    const player = overlay.querySelector('[data-video-player]');
    const title = overlay.querySelector('[data-video-title]');
    const loader = overlay.querySelector('[data-video-loader]');
    let lastTrigger = null;

    const reveal = () => loader.classList.add('is-hidden');

    player.addEventListener('loadeddata', reveal);
    player.addEventListener('canplay', reveal);
    player.addEventListener('error', reveal);

    const open = (trigger) => {
        lastTrigger = trigger;
        loader.classList.remove('is-hidden');
        player.poster = trigger.dataset.videoPoster || '';
        player.src = trigger.dataset.videoPreview;
        player.load();
        title.textContent = trigger.dataset.videoTitle || 'Video preview';
        overlay.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        overlay.querySelector('[data-video-close]').focus();
    };

    const close = () => {
        overlay.classList.remove('is-open');
        document.body.style.overflow = '';
        player.pause();
        player.removeAttribute('src');
        player.load();
        lastTrigger?.focus();
    };

    triggers.forEach((trigger) => trigger.addEventListener('click', () => open(trigger)));
    overlay.querySelector('[data-video-close]').addEventListener('click', close);
    overlay.addEventListener('click', (event) => {
        if (event.target === overlay) close();
    });
    window.addEventListener('keydown', (event) => {
        if (!overlay.classList.contains('is-open')) return;
        if (event.key === 'Escape') close();
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
function heroBackgroundRotator() {
    const slides = Array.from(document.querySelectorAll('[data-hero-slide]'));
    if (!slides.length) return;

    const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion || slides.length === 1) {
        slides.forEach((slide, index) => slide.classList.toggle('is-active', index === 0));
        return;
    }

    let active = Math.max(0, slides.findIndex((slide) => slide.classList.contains('is-active')));
    slides[active].classList.add('is-active');

    window.setInterval(() => {
        if (document.hidden) return;
        slides[active].classList.remove('is-active');
        active = (active + 1) % slides.length;
        slides[active].classList.add('is-active');
    }, 9000);
}

function cinematicVideos() {
    const videos = Array.from(document.querySelectorAll('[data-cinematic-video]'));
    if (!videos.length) return;

    const reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (reduceMotion) {
        videos.forEach((video) => {
            video.pause();
            video.removeAttribute('autoplay');
            video.classList.remove('is-playing');
        });
        return;
    }

    const play = (video) => {
        const attempt = video.play();
        if (attempt && typeof attempt.catch === 'function') attempt.catch(() => {});
    };

    const observer = 'IntersectionObserver' in window
        ? new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) play(entry.target);
                else entry.target.pause();
            });
        }, { threshold: 0.12 })
        : null;

    videos.forEach((video) => {
        if (!video.paused && video.currentTime > 0) video.classList.add('is-playing');
        video.addEventListener('playing', () => video.classList.add('is-playing'));
        if (observer) observer.observe(video);
        else play(video);
    });
}

/* Public M'Phakati lookup: searches approved members by name. */
function memberSearch() {
    const modal = document.querySelector('[data-member-search-modal]');
    if (!modal) return;

    const input = document.querySelector('[data-member-search-input]');
    const openButton = document.querySelector('[data-member-search-open]');
    const closeButton = modal.querySelector('[data-member-search-close]');
    const hint = modal.querySelector('[data-member-search-hint]');
    const results = modal.querySelector('[data-member-search-results]');
    const url = modal.dataset.memberSearchUrl;

    const render = (members) => {
        results.replaceChildren();

        if (!members.length) {
            hint.textContent = 'No approved member with an assigned M’Phakati matched that name.';
            return;
        }

        hint.textContent = members.length + ' matching member' + (members.length === 1 ? '' : 's') + '.';

        members.forEach((member) => {
            const card = document.createElement('article');
            card.className = 'rounded-2xl border border-slate-200/70 bg-white p-5';

            const name = document.createElement('h3');
            name.className = 'text-lg font-extrabold text-ink-900';
            name.textContent = member.name;
            card.appendChild(name);

            const group = document.createElement('p');
            group.className = 'mt-1 text-sm font-semibold text-brand-700';
            group.textContent = 'M’Phakati: ' + (member.mphakati || 'Not yet assigned');
            card.appendChild(group);

            const details = document.createElement('p');
            details.className = 'mt-2 text-sm text-ink-500';
            details.textContent = [member.programme, member.year_of_study ? 'Year ' + member.year_of_study : null]
                .filter(Boolean)
                .join(' · ');
            if (details.textContent) card.appendChild(details);

            if (member.affiliations && member.affiliations.length) {
                const affiliations = document.createElement('div');
                affiliations.className = 'mt-3 flex flex-wrap gap-2';
                member.affiliations.forEach((label) => {
                    const chip = document.createElement('span');
                    chip.className = 'chip';
                    chip.textContent = label;
                    affiliations.appendChild(chip);
                });
                card.appendChild(affiliations);
            }

            if (member.requested_group) {
                const requested = document.createElement('p');
                requested.className = 'mt-3 text-sm text-ink-500';
                requested.textContent = 'Preferred group: ' + member.requested_group;
                card.appendChild(requested);
            }

            results.appendChild(card);
        });
    };

    const search = async () => {
        const query = input.value.trim();

        if (query.length < 2) {
            hint.textContent = 'Type at least two letters of your name above, then open this dialog.';
            results.replaceChildren();
            return;
        }

        hint.textContent = 'Searching…';
        results.replaceChildren();

        try {
            const response = await fetch(url + '?q=' + encodeURIComponent(query), {
                headers: { Accept: 'application/json' },
            });
            if (!response.ok) throw new Error('Search failed');
            const data = await response.json();
            render(data.members || []);
        } catch {
            hint.textContent = 'Search is unavailable right now. Please try again.';
        }
    };

    const open = () => {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        closeButton.focus();
        search();
    };

    const close = () => {
        if (modal.classList.contains('hidden')) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        input.focus();
    };

    openButton.addEventListener('click', open);
    input.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            open();
        }
    });
    closeButton.addEventListener('click', close);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) close();
    });
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') close();
    });
}

/* Daily reflection modal: shows full reflection content on-site. */
function reflectionModal() {
    const modal = document.getElementById('reflection-modal');
    if (!modal) return;

    const titleEl = modal.querySelector('[data-reflection-modal-title]');
    const dateEl = modal.querySelector('[data-reflection-modal-date]');
    const subtitleEl = modal.querySelector('[data-reflection-modal-subtitle]');
    const bodyEl = modal.querySelector('[data-reflection-modal-body]');
    const scrollEl = modal.querySelector('[data-reflection-modal-scroll]');
    const closeBtn = modal.querySelector('[data-reflection-modal-close]');
    const sourceLinks = modal.querySelectorAll('[data-reflection-modal-source], [data-reflection-modal-source-mobile]');
    let lastTrigger = null;

    const open = (trigger) => {
        const raw = trigger.dataset.reflectionPayload;
        if (!raw) return;
        let payload;
        try {
            payload = JSON.parse(raw);
        } catch {
            return;
        }
        if (!payload || !payload.found || !payload.reflection) return;

        lastTrigger = trigger;
        const item = payload.reflection;
        if (titleEl) titleEl.textContent = item.title || 'Daily Reflection';
        if (dateEl) dateEl.textContent = payload.date_label || 'Daily reflection';
        if (subtitleEl) subtitleEl.textContent = item.liturgical_day || '';
        if (bodyEl) bodyEl.innerHTML = item.content_html || '<p>Reflection content is unavailable.</p>';

        const url = item.url || 'https://catholic-daily-reflections.com/';
        sourceLinks.forEach((link) => link.setAttribute('href', url));
        if (scrollEl) scrollEl.scrollTop = 0;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        (closeBtn || modal).focus();
    };

    const close = () => {
        if (modal.classList.contains('hidden')) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        if (lastTrigger && typeof lastTrigger.focus === 'function') {
            lastTrigger.focus();
        }
    };

    document.addEventListener('click', (event) => {
        const trigger = event.target.closest('[data-reflection-open]');
        if (trigger) {
            event.preventDefault();
            open(trigger);
        }
    });

    if (closeBtn) closeBtn.addEventListener('click', close);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) close();
    });
    window.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') close();
    });
}
