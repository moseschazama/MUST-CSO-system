<x-layouts.app title="Sign in">
    <section class="container-page pt-28 pb-10 sm:pt-32 sm:pb-14 lg:pt-36 lg:pb-16">
        <div class="mx-auto max-w-xl">
            <div class="card p-6 sm:p-8">
                <h1 class="text-3xl font-extrabold text-ink-900">Member sign in</h1>
                <p class="mt-2 text-sm text-ink-500">Sign in to apply for membership, view elections and vote.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                        {{ $errors->first() }}
                    </div>
                @endif
                @if (session('success'))
                    <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.submit') }}" class="mt-6 grid gap-5">
                    @csrf
                    <div>
                        <label class="text-sm font-bold text-ink-900" for="email">Email</label>
                        <input id="email" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div>
                        <label class="text-sm font-bold text-ink-900" for="password">Password</label>
                        <input id="password" class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" type="password" name="password" required>
                    </div>
                    <button class="btn-primary" type="submit">Sign in</button>
                </form>

                <p class="mt-6 text-sm text-ink-500">
                    New here?
                    <a href="{{ route('join') }}" class="font-bold text-brand-700">Apply to join MUST CSO</a>.
                </p>
            </div>
        </div>
    </section>
</x-layouts.app>

