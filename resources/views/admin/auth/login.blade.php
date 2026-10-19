<x-layouts.guest title="Administrator sign in">
    <h1 class="font-serif text-3xl text-burgundy-950">Administrator sign in</h1>
    <p class="mt-2 text-sm leading-relaxed text-charcoal-600">
        This area is for authorised CSO site administrators. Public registration is not available.
    </p>

    <x-form.errors class="mt-6" />

    <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-form.label for="email">Email address</x-form.label>
            <x-form.input
                name="email"
                type="email"
                autocomplete="username"
                required
                autofocus
                placeholder="you@example.com"
            />
        </div>

        <div>
            <x-form.label for="password">Password</x-form.label>
            <x-form.input
                name="password"
                type="password"
                autocomplete="current-password"
                required
                placeholder="Your password"
            />
        </div>

        <x-form.checkbox name="remember" :checked="old('remember')">
            Keep me signed in on this device
        </x-form.checkbox>

        <button type="submit" class="btn btn-primary w-full">Sign in</button>
    </form>

    <p class="mt-6 border-t border-charcoal-900/10 pt-5 text-sm leading-relaxed text-charcoal-600">
        Administrator accounts are created by the CSO technology team. If you need access, please
        contact the site maintainers.
    </p>
</x-layouts.guest>
