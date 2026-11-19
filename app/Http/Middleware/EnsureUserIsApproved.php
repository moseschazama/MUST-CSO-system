<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        $member = $request->user()?->member;

        if (! $member || $member->status !== 'approved') {
            abort(403, 'Approved CSO membership required.');
        }

        return $next($request);
    }
}
