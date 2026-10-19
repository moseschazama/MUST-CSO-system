@php
    $year = now()->year;
@endphp

<footer class="theme-dark bg-burgundy-950 text-ivory-100">
    <div class="container-page grid gap-12 py-16 md:grid-cols-2 lg:grid-cols-4">
        <div class="lg:col-span-2">
            <div class="flex items-center gap-3">
                <x-brand-mark class="h-12 w-12 text-gold-300" />
                <div>
                    <p class="font-serif text-xl font-semibold text-ivory-50">MUST Catholic Students Organisation</p>
                    <p class="eyebrow text-gold-300">Faith. Fellowship. Service.</p>
                </div>
            </div>

            <p class="mt-6 max-w-md text-sm leading-relaxed text-ivory-100/80">
                A Catholic student community at MUST, seeking to grow in faith, support one another,
                and serve the university and wider community.
            </p>
        </div>

        <nav aria-label="Footer">
            <h2 class="eyebrow text-gold-300">Explore</h2>
            <ul class="mt-4 space-y-3 text-sm">
                <li><a class="hover:text-gold-300" href="{{ route('about') }}">About the CSO</a></li>
                <li><a class="hover:text-gold-300" href="{{ route('events.index') }}">Events</a></li>
                <li><a class="hover:text-gold-300" href="{{ route('home') }}#faith-formation">Faith formation</a></li>
                <li><a class="hover:text-gold-300" href="{{ route('home') }}#community">Community life</a></li>
                <li><a class="hover:text-gold-300" href="{{ route('contact') }}">Contact</a></li>
            </ul>
        </nav>

        <div>
            <h2 class="eyebrow text-gold-300">Site information</h2>
            <p class="mt-4 text-sm leading-relaxed text-ivory-100/80">
                Official contact details, Mass times, chaplaincy information, and leadership will be
                published only after they have been confirmed by the CSO. This website is in active development.
            </p>
            <p class="mt-4 text-sm">
                <a class="underline underline-offset-4 hover:text-gold-300" href="{{ route('admin.login') }}">
                    Administrator sign in
                </a>
            </p>
        </div>
    </div>

    <div class="border-t border-ivory-50/10">
        <div class="container-page flex flex-wrap items-center justify-between gap-3 py-6 text-xs text-ivory-100/70">
            <p>&copy; {{ $year }} MUST Catholic Students Organisation. All rights reserved.</p>
            <p>Built for the Catholic student community at MUST.</p>
        </div>
    </div>
</footer>
