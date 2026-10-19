@if ($errors->any())
    <div role="alert" class="mb-8 border-l-4 border-red-700 bg-red-50 px-5 py-4">
        <p class="font-semibold text-red-900">Please correct the following:</p>

        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-800">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
