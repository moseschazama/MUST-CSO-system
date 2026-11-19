<x-layouts.app title="Prayer Intentions" description="Send an anonymous prayer request to the MUST Catholic Students Organization.">

    <x-page-hero
        eyebrow="Prayer intentions"
        title="Let us pray with you."
        description="Share a prayer request for Mass, for a friend, for your studies or for a need close to your heart. You may remain completely anonymous."
        image="/images/gallery/1HwaaaeG7vkZBJTMW4tLkPRgazSqq5A3g.jpg"
        breadcrumbs="Prayer intentions"
    />

    <section class="section container-page">
        <div class="mx-auto grid max-w-5xl gap-6 lg:grid-cols-[1fr_.8fr] lg:items-start">
            <div class="card p-6 sm:p-8">
                @if (session('success'))
                    <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        <p class="font-bold">Please check the form.</p>
                        <ul class="mt-2 list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <p class="eyebrow">Your request</p>
                <h2 class="mt-2 text-2xl font-extrabold text-ink-900">Place it in God’s hands.</h2>
                <p class="mt-2 text-sm leading-relaxed text-ink-500">
                    Your intention is shared only with the chaplaincy team and is remembered in prayer.
                </p>

                <form method="POST" action="{{ route('prayer-intentions.store') }}" class="mt-6 grid gap-5">
                    @csrf

                    <div>
                        <label class="field-label" for="intention">Prayer intention</label>
                        <textarea id="intention" name="intention" rows="6" required class="field-textarea" placeholder="Lord, please...">{{ old('intention') }}</textarea>
                        @error('intention')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="field-label" for="name">Your name (optional)</label>
                            <input id="name" name="name" value="{{ old('name') }}" class="field-input" placeholder="Leave blank to stay anonymous">
                            @error('name')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="field-label" for="mass_date">Remember at Mass on (optional)</label>
                            <input id="mass_date" name="mass_date" type="date" value="{{ old('mass_date') }}" class="field-input">
                            @error('mass_date')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <label class="choice-card">
                        <input type="hidden" name="is_anonymous" value="0">
                        <input type="checkbox" name="is_anonymous" value="1" @checked(old('is_anonymous', true)) class="mt-0.5 h-4 w-4 rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        <span>
                            <span class="block text-sm font-bold text-ink-900">Keep my request anonymous</span>
                            <span class="mt-0.5 block text-xs text-ink-500">Your name will not be stored with the intention.</span>
                        </span>
                    </label>

                    <button type="submit" class="btn-primary w-full sm:w-auto">
                        <x-icon name="heart" class="h-4 w-4" />
                        Send prayer intention
                    </button>
                </form>
            </div>

            <aside class="space-y-4">
                <div class="rounded-2xl border border-gold-300/50 bg-gradient-to-br from-ink-900 to-brand-950 p-6 text-white">
                    <x-icon name="quote" class="h-6 w-6 text-gold-300" />
                    <p class="mt-4 text-lg leading-snug font-extrabold">
                        “Do not be anxious about anything, but in every situation, by prayer and petition, with thanksgiving, present your requests to God.”
                    </p>
                    <p class="mt-3 text-xs font-bold tracking-wide text-gold-300 uppercase">Philippians 4:6</p>
                </div>

                <div class="card p-6">
                    <p class="eyebrow">Need to speak to someone?</p>
                    <p class="mt-3 text-sm leading-relaxed text-ink-500">
                        For pastoral care, confession or a conversation with the chaplain, contact the CSO leadership or the campus chaplaincy directly.
                    </p>
                    <a href="{{ route('contact') }}" class="btn-ghost btn-sm mt-4 w-full">
                        Contact the CSO
                        <x-icon name="arrow-right" class="h-4 w-4" />
                    </a>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.app>
