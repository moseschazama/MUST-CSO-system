<x-layouts.public title="Access denied">
    <section class="py-24">
        <div class="container-page text-center">
            <p class="eyebrow text-gold-700">403</p>
            <h1 class="mt-4 font-serif text-4xl text-burgundy-950 sm:text-5xl">You do not have access to this area.</h1>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-relaxed text-charcoal-700">
                This part of the website is limited to CSO administrators. If you believe you should
                have access, please contact the site maintainers.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('home') }}" class="btn btn-primary">Return home</a>
                <a href="{{ route('admin.login') }}" class="btn btn-outline">Administrator sign in</a>
            </div>
        </div>
    </section>
</x-layouts.public>
