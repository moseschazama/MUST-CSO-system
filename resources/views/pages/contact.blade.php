<x-layouts.public
    title="Contact"
    description="Contact the MUST Catholic Students Organisation using the online message form. Official contact channels will be published once confirmed."
>
    <section class="border-b border-charcoal-900/10 bg-ivory-100 py-14 sm:py-16">
        <div class="container-page">
            <p class="eyebrow text-gold-700">Contact</p>
            <h1 class="mt-4 max-w-3xl font-serif text-4xl leading-tight text-burgundy-950 sm:text-5xl">
                We would love to hear from you.
            </h1>
            <p class="mt-6 max-w-2xl text-lg leading-relaxed text-charcoal-700">
                Use the form below to send a message to the CSO. Whether you are a student, a parent,
                or a member of the wider MUST community, your message is welcome.
            </p>
        </div>
    </section>

    <section class="py-16">
        <div class="container-page grid gap-12 lg:grid-cols-12">
            <div class="lg:col-span-7">
                <div class="card p-6 sm:p-8">
                    <h2 class="font-serif text-2xl text-burgundy-950">Send a message</h2>
                    <p class="mt-2 text-sm text-charcoal-600">
                        Fields marked with an asterisk (*) are required.
                    </p>

                    <x-form.errors class="mt-6" />

                    <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-6">
                        @csrf

                        <div>
                            <x-form.label for="name">Name <span aria-hidden="true" class="text-burgundy-700">*</span></x-form.label>
                            <x-form.input
                                name="name"
                                :value="old('name')"
                                autocomplete="name"
                                required
                                placeholder="Your full name"
                            />
                        </div>

                        <div>
                            <x-form.label for="email">Email address <span aria-hidden="true" class="text-burgundy-700">*</span></x-form.label>
                            <x-form.input
                                name="email"
                                type="email"
                                :value="old('email')"
                                autocomplete="email"
                                required
                                placeholder="you@example.com"
                            />
                        </div>

                        <div>
                            <x-form.label for="subject" optional>Subject</x-form.label>
                            <x-form.input
                                name="subject"
                                :value="old('subject')"
                                placeholder="What is your message about?"
                            />
                        </div>

                        <div>
                            <x-form.label for="message">Message <span aria-hidden="true" class="text-burgundy-700">*</span></x-form.label>
                            <x-form.textarea
                                name="message"
                                :value="old('message')"
                                rows="7"
                                required
                                placeholder="Share your message with the CSO."
                            />
                        </div>

                        <button type="submit" class="btn btn-primary">Send message</button>

                        <p class="text-sm leading-relaxed text-charcoal-600">
                            Your message is stored securely in the CSO website and can only be read by
                            authorised CSO administrators.
                        </p>
                    </form>
                </div>
            </div>

            <aside class="space-y-6 lg:col-span-5">
                <div class="border-l-4 border-gold-500 bg-white p-6 shadow-card">
                    <h2 class="font-serif text-xl text-burgundy-950">Official contact channels</h2>
                    <p class="mt-3 text-sm leading-relaxed text-charcoal-700">
                        The official CSO email address, telephone number, and social media accounts are
                        being confirmed. They will be published on this page rather than guessed at.
                    </p>
                </div>

                <div class="border-l-4 border-gold-500 bg-white p-6 shadow-card">
                    <h2 class="font-serif text-xl text-burgundy-950">Mass times and chaplaincy</h2>
                    <p class="mt-3 text-sm leading-relaxed text-charcoal-700">
                        Mass times and chaplaincy contact details will be published only once they are
                        confirmed. For urgent pastoral care, please use the official MUST chaplaincy
                        channels available to students on campus.
                    </p>
                </div>

                <div class="border-l-4 border-gold-500 bg-white p-6 shadow-card">
                    <h2 class="font-serif text-xl text-burgundy-950">What happens next</h2>
                    <p class="mt-3 text-sm leading-relaxed text-charcoal-700">
                        Your message appears in the CSO administration area, where an administrator can
                        review it and follow up through the email address you provide.
                    </p>
                </div>
            </aside>
        </div>
    </section>
</x-layouts.public>
