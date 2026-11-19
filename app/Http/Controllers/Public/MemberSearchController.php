<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberSearchController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $search = trim((string) $request->query('q', ''));

        if (mb_strlen($search) < 2) {
            return response()->json(['members' => []]);
        }

        $members = Member::approved()
            ->whereNotNull('mphakati')
            ->where('mphakati', '<>', '')
            ->where('full_name', 'like', "%{$search}%")
            ->orderBy('full_name')
            ->limit(20)
            ->get()
            ->map(fn (Member $member) => [
                'name' => $member->full_name,
                'mphakati' => $member->mphakati,
                'programme' => $member->programme,
                'year_of_study' => $member->year_of_study,
                'affiliations' => array_values(array_unique(array_merge(
                    $member->interest_labels,
                    $member->activity_labels
                ))),
                'requested_group' => $member->requested_group,
            ])
            ->values();

        return response()->json(['members' => $members]);
    }
}
