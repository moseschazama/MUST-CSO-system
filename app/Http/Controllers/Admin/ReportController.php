<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(): View
    {
        return view('admin.reports.index', [
            'reports' => Report::latestFirst()->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.reports.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'summary' => 'required|string',
            'highlights' => 'nullable',
            'cover_image' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        $report = Report::create([
            'title' => $validated['title'],
            'activity_date' => $validated['activity_date'],
            'summary' => $validated['summary'],
            'highlights' => $validated['highlights'] ?? [],
            'cover_image' => $validated['cover_image'] ?? null,
            'is_published' => $request->boolean('is_published', true),
        ]);

        \App\Models\AuditLog::record('created_report', $report, $report->title);

        return redirect()->route('admin.reports.index')->with('success', 'Report created.');
    }

    public function edit(Report $report): View
    {
        return view('admin.reports.edit', ['report' => $report]);
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'activity_date' => 'required|date',
            'summary' => 'required|string',
            'highlights' => 'nullable',
            'cover_image' => 'nullable|string|max:255',
            'is_published' => 'nullable|boolean',
        ]);

        $report->update($validated + ['is_published' => $request->boolean('is_published', true)]);

        \App\Models\AuditLog::record('updated_report', $report, $report->title);

        return redirect()->route('admin.reports.index')->with('success', 'Report updated.');
    }

    public function destroy(Report $report): RedirectResponse
    {
        $title = $report->title;
        $report->delete();

        \App\Models\AuditLog::record('deleted_report', $report, $title);

        return redirect()->route('admin.reports.index')->with('success', 'Report deleted.');
    }
}
