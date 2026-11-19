<x-admin-layout title="Site Settings" heading="Site Settings">
    <div class="card p-8">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="grid gap-6">
            @csrf
            @foreach ($settings as $key => $item)
                <div>
                    <label class="text-sm font-bold text-ink-900">{{ $item['label'] }}</label>
                    @if (str_contains($key, 'description') || str_contains($key, 'mission') || str_contains($key, 'intro'))
                        <textarea class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" rows="3" name="{{ $key }}">{{ old($key, $item['value']) }}</textarea>
                    @else
                        <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="{{ $key }}" value="{{ old($key, $item['value']) }}">
                    @endif
                </div>
            @endforeach
            <button class="btn-primary" type="submit">Save settings</button>
        </form>
    </div>
</x-admin-layout>
