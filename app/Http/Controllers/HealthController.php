<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class HealthController extends Controller
{
    /**
     * Report whether the application can reach its database.
     */
    public function __invoke(): JsonResponse
    {
        try {
            DB::connection()->getPdo();
            DB::select('select 1');
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'status' => 'degraded',
            ], 503);
        }

        return response()->json([
            'status' => 'ok',
            'application' => config('app.name'),
        ]);
    }
}
