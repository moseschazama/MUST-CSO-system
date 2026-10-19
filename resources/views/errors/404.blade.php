<x-layouts.public title="Page not found">
    <section class="py-24">
        <div class="container-page text-center">
            <p class="eyebrow text-gold-700">404</p>
            <h1 class="mt-4 font-serif text-4xl text-burgundy-950 sm:text-5xl">We could not find that page.</h1>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-relaxed text-charcoal-700">
                The page may have moved, or the link may be out of date. You can return to the
                homepage or explore the events and contact pages.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-4">
                <a href="{{ route('home') }}" class="btn btn-primary">Return home</a>
                <a href="{{ route('contact') }}" class="btn btn-outline">Contact the CSO</a>
            </div>
        </div>
    </section>
</x-layouts.public>
