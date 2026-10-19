<x-layouts.admin title="Dashboard" heading="A live overview of events and messages for the CSO website.">
    <dl class="grid gap-4 sm:grid-cols-3">
        <div class="card p-6">
            <dt class="eyebrow text-gold-700">Upcoming published</dt>
            <dd class="mt-3 font-serif text-4xl text-burgundy-950">{{ $upcomingCount }}</dd>
            <dd class="mt-2 text-sm text-charcoal-600">
                <a href="{{ route('admin.events.index') }}" class="font-semibold text-burgundy-800 hover:text-burgundy-600">
                    Manage events <span aria-hidden="true">&rarr;</span>
                </a>
            </dd>
        </div>

        <div class="card p-6">
            <dt class="eyebrow text-gold-700">Published events</dt>
            <dd class="mt-3 font-serif text-4xl text-burgundy-950">{{ $publishedCount }}</dd>
            <dd class="mt-2 text-sm text-charcoal-600">Visible on the public website</dd>
        </div>

        <div class="card p-6">
            <dt class="eyebrow text-gold-700">Unread messages</dt>
            <dd class="mt-3 font-serif text-4xl text-burgundy-950">{{ $unreadCount }}</dd>
            <dd class="mt-2 text-sm text-charcoal-600">
                <a href="{{ route('admin.messages.index') }}" class="font-semibold text-burgundy-800 hover:text-burgundy-600">
                    Review messages <span aria-hidden="true">&rarr;</span>
                </a>
            </dd>
        </div>
    </dl>

    <div class="mt-10 grid gap-8 lg:grid-cols-3">
        <section class="lg:col-span-2" aria-labelledby="recent-events-heading">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 id="recent-events-heading" class="font-serif text-2xl text-burgundy-950">Recent events</h2>
                <a href="{{ route('admin.events.create') }}" class="btn btn-outline">Create event</a>
            </div>

            @if ($recentEvents->isEmpty())
                <div class="card mt-5 p-8">
                    <h3 class="font-serif text-xl text-burgundy-950">No events yet</h3>
                    <p class="mt-2 text-sm leading-relaxed text-charcoal-700">
                        Create the first event and publish it when the details are confirmed.
                    </p>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary mt-5">Create an event</a>
                </div>
            @else
                <ul class="mt-5 divide-y divide-charcoal-900/10 border border-charcoal-900/10 bg-white shadow-card">
                    @foreach ($recentEvents as $event)
                        <li class="flex flex-wrap items-center justify-between gap-4 p-5">
                            <div>
                                <div class="flex flex-wrap items-center gap-2">
                                    @if ($event->is_demo)
                                        <span class="badge badge-demo">Demo</span>
                                    @endif
                                    @if ($event->is_published)
                                        <span class="badge badge-published">Published</span>
                                    @else
                                        <span class="badge badge-draft">Draft</span>
                                    @endif
                                </div>

                                <h3 class="mt-2 font-serif text-lg text-burgundy-950">
                                    <a href="{{ route('admin.events.edit', $event) }}" class="hover:text-burgundy-700">
                                        {{ $event->title }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-charcoal-600">{{ $event->scheduleSummary() }}</p>
                            </div>

                            <a href="{{ route('admin.events.edit', $event) }}" class="text-sm font-semibold text-burgundy-800 hover:text-burgundy-600">
                                Edit
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section aria-labelledby="recent-messages-heading">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <h2 id="recent-messages-heading" class="font-serif text-2xl text-burgundy-950">Recent messages</h2>
                <a href="{{ route('admin.messages.index') }}" class="text-sm font-semibold text-burgundy-800 hover:text-burgundy-600">
                    View all
                </a>
            </div>

            @if ($recentMessages->isEmpty())
                <div class="card mt-5 p-8">
                    <h3 class="font-serif text-xl text-burgundy-950">No messages yet</h3>
                    <p class="mt-2 text-sm leading-relaxed text-charcoal-700">
                        Messages submitted through the public contact form will appear here.
                    </p>
                </div>
            @else
                <ul class="mt-5 space-y-4">
                    @foreach ($recentMessages as $message)
                        <li class="card p-5">
                            <div class="flex items-center justify-between gap-3">
                                <p class="text-sm font-semibold text-charcoal-900">{{ $message->name }}</p>
                                @unless ($message->read_at)
                                    <span class="badge badge-demo">Unread</span>
                                @endunless
                            </div>
                            <p class="mt-1 text-sm text-charcoal-600">{{ $message->displaySubject() }}</p>
                            <p class="mt-1 text-xs text-charcoal-500">{{ $message->created_at->diffForHumans() }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
</x-layouts.admin>
