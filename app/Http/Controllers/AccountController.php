<?php

namespace App\Http\Controllers;

use App\Models\Election;
use App\Models\Member;
use App\Models\User;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function dashboard(): View
    {
        $user = auth()->user();
        $member = $user?->member;

        return view('account.dashboard', [
            'user' => $user,
            'member' => $member,
            'elections' => Election::visible()->withCount('positions')->latest('id')->take(5)->get(),
        ]);
    }
}
