@if (session('status'))
    <div
        role="status"
        {{ $attributes->merge(['class' => 'border-l-4 border-gold-500 bg-white px-5 py-4 text-sm font-medium text-charcoal-800 shadow-card']) }}
    >
        {{ session('status') }}
    </div>
@endif
