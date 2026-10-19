<x-layouts.admin title="Messages" heading="Messages submitted through the public contact form.">
    @if ($messages->isEmpty())
        <div class="card p-8">
            <h2 class="font-serif text-2xl text-burgundy-950">No messages yet</h2>
            <p class="prose-cso mt-3 max-w-2xl">
                When a visitor submits the contact form, their message will appear here for an
                administrator to review.
            </p>
            <a href="{{ route('contact') }}" class="btn btn-outline mt-6">View the public contact page</a>
        </div>
    @else
        <div class="space-y-5">
            @foreach ($messages as $message)
                <article class="card p-6 @unless ($message->read_at) border-l-4 border-gold-500 @endunless">
                    <div class="flex flex-wrap items-start justify-between gap-4">
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <h2 class="font-serif text-xl text-burgundy-950">{{ $message->displaySubject() }}</h2>

                                @if ($message->read_at)
                                    <span class="badge badge-draft">Read</span>
                                @else
                                    <span class="badge badge-demo">Unread</span>
                                @endif
                            </div>

                            <p class="mt-1 text-sm text-charcoal-600">
                                From <span class="font-semibold text-charcoal-800">{{ $message->name }}</span>
                                &lt;{{ $message->email }}&gt;
                            </p>
                        </div>

                        <time datetime="{{ $message->created_at->toIso8601String() }}" class="text-xs text-charcoal-500">
                            {{ $message->created_at->format('j M Y, g:i A') }}
                        </time>
                    </div>

                    <p class="mt-5 whitespace-pre-line text-sm leading-relaxed text-charcoal-700">{{ $message->message }}</p>

                    <div class="mt-5 border-t border-charcoal-900/10 pt-4">
                        <form method="POST" action="{{ route('admin.messages.toggle-read', $message) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-sm font-semibold text-burgundy-800 hover:text-burgundy-600">
                                {{ $message->read_at ? 'Mark as unread' : 'Mark as read' }}
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    @endif
</x-layouts.admin>
