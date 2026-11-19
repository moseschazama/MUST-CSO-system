<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Member;
use App\Models\Report;
use App\Support\SimplePdf;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DocumentController extends Controller
{
    public function index(): View
    {
        $groups = Member::approved()
            ->whereNotNull('mphakati')
            ->where('mphakati', '<>', '')
            ->orderBy('mphakati')
            ->get()
            ->groupBy('mphakati')
            ->map(fn ($members, $name) => [
                'name' => $name,
                'count' => $members->count(),
            ])
            ->values();

        return view('documents.index', [
            'reports' => Report::latestFirst()->get(),
            'groups' => $groups,
        ]);
    }

    public function report(Report $report): Response
    {
        abort_unless($report->is_published, 404);

        $pdf = SimplePdf::make($report->title, 'MUST Catholic Students Organization - Activity report');
        $pdf->meta('Activity date: '.$report->activity_date->format('j F Y'));
        $pdf->heading('Summary');
        $pdf->text($report->summary);

        if (! empty($report->highlights)) {
            $pdf->heading('Highlights');

            foreach ($report->highlights as $highlight) {
                $pdf->bullet($highlight);
            }
        }

        $pdf->divider();
        $pdf->note('Downloaded from the MUST CSO website. For photos and further details, contact the CSO leadership.');

        return $this->download($pdf->output(), $report->title);
    }

    public function projects(): Response
    {
        $activities = Activity::published()
            ->ordered()
            ->get()
            ->unique('title')
            ->values();

        $pdf = SimplePdf::make('Projects & activities', 'MUST CSO - Liturgy, formation, fellowship and outreach');
        $pdf->meta('Published activities: '.$activities->count());
        $pdf->divider();

        foreach (Activity::CATEGORIES as $key => $label) {
            $group = $activities->where('category', $key);

            if ($group->isEmpty()) {
                continue;
            }

            $pdf->heading($label);

            foreach ($group as $activity) {
                $pdf->subheading($activity->title);

                $details = array_filter([$activity->day, $activity->time, $activity->venue]);

                if ($details) {
                    $pdf->meta(implode(' - ', $details));
                }

                if (filled($activity->description)) {
                    $pdf->text($activity->description);
                }

                $pdf->space(4);
            }
        }

        $pdf->divider();
        $pdf->note('This document lists the public activity schedule. Times and venues may change; confirm with the CSO leadership.');

        return $this->download($pdf->output(), 'MUST CSO projects and activities');
    }

    public function allMphakati(): Response
    {
        $members = Member::approved()
            ->whereNotNull('mphakati')
            ->where('mphakati', '<>', '')
            ->orderBy('mphakati')
            ->orderBy('full_name')
            ->get();

        abort_if($members->isEmpty(), 404);

        $pdf = SimplePdf::make("M'Phakati member lists", 'MUST Catholic Students Organization - Approved members by small Christian community');
        $pdf->meta('Approved members: '.$members->count());
        $pdf->meta('Generated: '.now()->format('j F Y'));
        $pdf->divider();

        foreach ($members->groupBy('mphakati') as $name => $group) {
            $pdf->heading($name.' ('.$group->count().' members)');

            foreach ($group as $index => $member) {
                $pdf->subheading(($index + 1).'. '.$member->full_name);

                $details = array_filter([
                    $member->programme,
                    filled($member->year_of_study) ? 'Year '.$member->year_of_study : null,
                    $member->department,
                ]);

                if ($details) {
                    $pdf->meta(implode(' - ', $details));
                }

                $pdf->space(2);
            }

            $pdf->space(6);
        }

        $pdf->divider();
        $pdf->note('This list includes approved members only. Contact details are intentionally omitted to protect privacy.');

        return $this->download($pdf->output(), 'MUST CSO MPhakati member lists');
    }

    public function mphakati(string $group): Response
    {
        $members = Member::approved()
            ->where('mphakati', $group)
            ->orderBy('full_name')
            ->get();

        abort_if($members->isEmpty(), 404);

        $pdf = SimplePdf::make("M'Phakati: ".$group, 'MUST Catholic Students Organization - Member list');
        $pdf->meta('Approved members: '.$members->count());
        $pdf->meta('Generated: '.now()->format('j F Y'));
        $pdf->divider();

        foreach ($members as $index => $member) {
            $pdf->subheading(($index + 1).'. '.$member->full_name);

            $details = array_filter([
                $member->programme,
                filled($member->year_of_study) ? 'Year '.$member->year_of_study : null,
                $member->department,
            ]);

            if ($details) {
                $pdf->meta(implode(' - ', $details));
            }

            $pdf->space(2);
        }

        $pdf->divider();
        $pdf->note('This list includes approved members only. Contact details are intentionally omitted to protect privacy.');

        return $this->download($pdf->output(), "M'Phakati ".$group.' member list');
    }

    private function download(string $pdf, string $name): Response
    {
        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.Str::slug($name).'.pdf"',
            'Cache-Control' => 'private, max-age=0, must-revalidate',
        ]);
    }
}
