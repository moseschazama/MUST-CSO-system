<?php

namespace App\Http\Controllers;

use App\Models\PrayerIntention;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PrayerIntentionController extends Controller
{
    public function create(): View
    {
        return view('prayer-intentions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'intention' => 'required|string|min:5|max:1000',
            'name' => 'nullable|required_unless:is_anonymous,1|string|max:255',
            'is_anonymous' => 'nullable|boolean',
            'mass_date' => 'nullable|date',
        ]);

        PrayerIntention::create([
            'name' => $request->boolean('is_anonymous') ? null : ($validated['name'] ?? null),
            'intention' => $validated['intention'],
            'is_anonymous' => $request->boolean('is_anonymous', true),
            'mass_date' => $validated['mass_date'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('prayer-intentions.create')
            ->with('success', 'Your prayer intention has been received. The chaplaincy team will remember it at Mass.');
    }
}
