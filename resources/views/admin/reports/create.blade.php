<x-admin-layout title="New Report" heading="New Report">
    <div class="card p-8">
        <form method="POST" action="{{ route('admin.reports.store') }}" class="grid gap-6">
            @csrf
            <div>
                <label class="text-sm font-bold text-ink-900">Title</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="title" required>
            </div>
            <div>
                <label class="text-sm font-bold text-ink-900">Activity date</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" type="date" name="activity_date" required>
            </div>
            <div>
                <label class="text-sm font-bold text-ink-900">Summary</label>
                <textarea class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" rows="4" name="summary" required></textarea>
            </div>
            <div>
                <label class="text-sm font-bold text-ink-900">Highlights (JSON array)</label>
                <textarea class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" rows="3" name="highlights"></textarea>
            </div>
            <div>
                <label class="text-sm font-bold text-ink-900">Cover image path or photo ID</label>
                <input class="mt-2 w-full rounded-2xl border border-slate-200 bg-white px-4 py-3" name="cover_image" placeholder="/images/gallery/photo.jpg or photo ID">
                <p class="mt-2 text-xs text-ink-500">Use a local image path, or the ID of a gallery photo already on the site.</p>
            </div>
            <label class="flex items-center gap-3 text-sm font-semibold text-ink-900">
                <input type="checkbox" name="is_published" value="1" checked class="h-4 w-4 rounded border-slate-300 text-brand-600">
                Published
            </label>
            <div class="flex gap-3">
                <button class="btn-primary" type="submit">Save report</button>
                <a href="{{ route('admin.reports.index') }}" class="btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</x-admin-layout>
