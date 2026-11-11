@php
    $org = config('cso.org');
    $contact = config('cso.contact');
    $socials = collect(config('cso.socials'));
@endphp

<x-layouts.app title="Contact" description="How to reach the MUST Catholic Students Organization — email, location, meeting times and social platforms.">

    <x-page-hero
        eyebrow="Contact us"
        title="We would love to hear from you."
        description="Reach out to join a committee, request prayers, or ask about any CSO activity."
    />

    {{-- ===== Contact cards ===== --}}
    <section class="section container-page">
        <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
            {{-- Email (copy) --}}
            <div class="card flex flex-col p-6">
                <span class="icon-badge">
                    <x-icon name="mail" class="h-5 w-5" />
                </span>
                <p class="mt-4 text-[11px] font-bold tracking-[0.16em] text-ink-500 uppercase">Email</p>
                <p class="mt-1 break-all text-sm font-bold text-ink-900">{{ $contact['email'] }}</p>
                <button
                    type="button"
                    data-copy="{{ $contact['email'] }}"
                    class="btn-ghost btn-sm mt-4 w-full"
                >
                    <x-icon name="copy" class="h-4 w-4" data-copy-icon />
                    <span data-copy-label>Copy address</span>
                </button>
            </div>

            {{-- Phone --}}
            <div class="card flex flex-col p-6">
                <span class="icon-badge">
                    <x-icon name="phone" class="h-5 w-5" />
                </span>
                <p class="mt-4 text-[11px] font-bold tracking-[0.16em] text-ink-500 uppercase">Phone</p>
                <p class="mt-1 text-sm font-bold text-ink-900">{{ $contact['phone'] }}</p>
                <a href="tel:{{ preg_replace('/\s+/', '', $contact['phone']) }}" class="btn-ghost btn-sm mt-4 w-full">
                    <x-icon name="phone" class="h-4 w-4" />
                    Call
                </a>
            </div>

            {{-- Location --}}
            <div class="card flex flex-col p-6">
                <span class="icon-badge">
                    <x-icon name="map-pin" class="h-5 w-5" />
                </span>
                <p class="mt-4 text-[11px] font-bold tracking-[0.16em] text-ink-500 uppercase">Location</p>
                <p class="mt-1 text-sm font-bold text-ink-900">{{ $contact['location'] }}</p>
                <p class="mt-2 text-xs text-ink-500">{{ $contact['postal'] }}</p>
            </div>

            {{-- Meeting --}}
            <div class="card flex flex-col p-6">
                <span class="icon-badge">
                    <x-icon name="calendar-days" class="h-5 w-5" />
                </span>
                <p class="mt-4 text-[11px] font-bold tracking-[0.16em] text-ink-500 uppercase">Meetings</p>
                <p class="mt-1 text-sm font-bold text-ink-900">{{ $contact['meeting_time'] }}</p>
                <p class="mt-2 text-xs text-ink-500">{{ $contact['meeting_venue'] }}</p>
            </div>
        </div>
    </section>

    {{-- ===== Socials ===== --}}
    <section class="section container-page bg-slate-50/60 sm:rounded-[2.5rem]">
        <x-section-heading eyebrow="Social platforms" title="Follow us online" center />

        <div class="mt-10 grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($socials as $social)
                @if ($social['url'])
                    <a
                        href="{{ $social['url'] }}"
                        target="_blank"
                        rel="noopener"
                        class="card card-hover flex flex-col items-center gap-3 p-5 text-center"
                    >
                        <span class="icon-badge h-12 w-12 rounded-2xl">
                            <x-icon :name="$social['icon']" class="h-5 w-5" />
                        </span>
                        <div>
                            <p class="text-sm font-bold text-ink-900">{{ $social['label'] }}</p>
                            <p class="mt-0.5 text-[11px] text-ink-500">{{ $social['handle'] }}</p>
                        </div>
                    </a>
                @else
                    <div class="card flex flex-col items-center gap-3 p-5 text-center opacity-50">
                        <span class="icon-badge h-12 w-12 rounded-2xl">
                            <x-icon :name="$social['icon']" class="h-5 w-5" />
                        </span>
                        <div>
                            <p class="text-sm font-bold text-ink-900">{{ $social['label'] }}</p>
                            <p class="mt-0.5 text-[11px] text-ink-500">Link coming soon</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </section>

    {{-- ===== Join ===== --}}
    <section id="join" class="section container-page">
        <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
            <div>
                <p class="eyebrow">Join CSO</p>
                <h2 class="mt-3 text-3xl font-extrabold text-ink-900 sm:text-4xl">
                    Becoming a member is simple.
                </h2>
                <ol class="mt-6 space-y-4">
                    @foreach ([
                        'Come to any Friday general meeting at the Main Lecture Hall, 6:00 PM.',
                        'Introduce yourself to the secretary, who will add you to the register.',
                        'Join a small Christian community in your hostel and choose a committee to serve on.',
                        'Attend Holy Mass and morning devotion — participation is the heart of membership.',
                    ] as $step => $text)
                        <li class="flex items-start gap-3">
                            <span class="grid h-7 w-7 shrink-0 place-items-center rounded-full bg-brand-600 text-xs font-extrabold text-white">
                                {{ $step + 1 }}
                            </span>
                            <p class="pt-0.5 text-[15px] leading-relaxed text-ink-500">{{ $text }}</p>
                        </li>
                    @endforeach
                </ol>
            </div>

            <div class="card p-8">
                <p class="eyebrow">Quick contact</p>
                <h3 class="mt-2 text-xl font-extrabold text-ink-900">Write to us directly</h3>
                <p class="mt-2 text-sm leading-relaxed text-ink-500">
                    For committee enquiries, prayer requests or anything else, send us an email
                    and we will reply as soon as we can.
                </p>
                <a href="mailto:{{ $contact['email'] }}?subject=Hello%20from%20MUST%20CSO" class="btn-primary mt-6 w-full">
                    <x-icon name="mail" class="h-4 w-4" />
                    Email {{ $contact['email'] }}
                </a>
                <p class="mt-4 text-center text-xs text-ink-500">
                    Or use the WhatsApp channel link above for the fastest reply.
                </p>
            </div>
        </div>
    </section>
</x-layouts.app>
