<x-admin-layout title="Gallery" heading="Gallery">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="eyebrow">Content</p>
            <h1 class="mt-2 text-3xl font-extrabold text-ink-900">Gallery photos</h1>
        </div>
        <a href="{{ route('admin.gallery.create') }}" class="btn-primary btn-sm">Add photo</a>
    </div>

    @if (session('success'))
        <div class="mt-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
    @endif

    <div class="card mt-8 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-xs font-bold tracking-wide text-ink-500 uppercase">
                <tr>
                    <th class="px-5 py-3">Title</th>
                    <th class="px-5 py-3">Album</th>
                    <th class="px-5 py-3">Category</th>
                    <th class="px-5 py-3">Photo file</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($photos as $photo)
                    <tr class="border-t border-slate-100">
                        <td class="px-5 py-3 font-semibold text-ink-900">{{ $photo->title }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $photo->album }}</td>
                        <td class="px-5 py-3 text-ink-500">{{ $photo->category }}</td>
                        <td class="px-5 py-3">
                            <img src="{{ $photo->thumbnail }}" alt="{{ $photo->title }}" class="h-12 w-16 rounded-lg object-cover ring-1 ring-slate-200">
                        </td>
                        <td class="px-5 py-3"><span class="chip">{{ $photo->is_published ? 'Published' : 'Draft' }}</span></td>
                        <td class="px-5 py-3 text-right">
                            <div class="flex items-center justify-end gap-4">
                                <a href="{{ route('admin.gallery.edit', $photo) }}" class="text-sm font-bold text-brand-700">Edit</a>
                                <form method="POST" action="{{ route('admin.gallery.destroy', $photo) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm font-bold text-red-600" onclick="return confirm('Delete this photo?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="p-5">{{ $photos->links() }}</div>
    </div>
</x-admin-layout>
