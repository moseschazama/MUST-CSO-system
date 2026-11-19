<x-admin-layout title="Edit Leader" heading="Edit Leader">
    <div class="card p-8">
        <form method="POST" action="{{ route('admin.leaders.update', $leader) }}">
            @method('PUT')
            @csrf
            <div class="grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-bold text-ink-900">Name</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="name" value="{{ $leader->name }}" required>
                </div>
                <div>
                    <label class="text-sm font-bold text-ink-900">Role</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="role" value="{{ $leader->role }}" required>
                </div>
            </div>
            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-bold text-ink-900">Category</label>
                    <select class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="category">
                        <option value="spiritual" @selected($leader->category === 'spiritual')>Spiritual &amp; advisory</option>
                        <option value="executive" @selected($leader->category === 'executive')>Current executive</option>
                        <option value="past" @selected($leader->category === 'past')>Past chairpersons</option>
                    </select>
                </div>
                <div>
                    <label class="text-sm font-bold text-ink-900">Tenure</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="tenure" value="{{ $leader->tenure }}">
                </div>
            </div>
            <div class="mt-6">
                <label class="text-sm font-bold text-ink-900">Bio</label>
                <textarea class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" rows="4" name="bio">{{ $leader->bio }}</textarea>
            </div>
            <div class="mt-6">
                <label class="text-sm font-bold text-ink-900">Portrait photo URL or path</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="photo" value="{{ $leader->photo }}" placeholder="/images/leaders/name.jpg">
                <p class="mt-2 text-xs text-ink-500">Use a sharp, well-lit portrait. Leave blank to show the gold initials fallback.</p>
            </div>
            <div class="mt-6 grid gap-6 sm:grid-cols-2">
                <div>
                    <label class="text-sm font-bold text-ink-900">Email</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" type="email" name="email" value="{{ $leader->email }}">
                </div>
                <div>
                    <label class="text-sm font-bold text-ink-900">Sort order</label>
                    <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" type="number" name="sort_order" value="{{ $leader->sort_order }}">
                </div>
            </div>
            <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                <input type="checkbox" name="is_published" value="1" @checked($leader->is_published) class="h-4 w-4 rounded border-slate-300 text-brand-600">
                Published
            </label>
            <div class="flex gap-3">
                <button class="btn-primary" type="submit">Save leader</button>
                <a href="{{ route('admin.leaders.index') }}" class="btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
