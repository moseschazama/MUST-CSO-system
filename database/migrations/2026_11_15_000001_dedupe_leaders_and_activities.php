<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('leaders')
            ->select('name', 'category', 'role', DB::raw('MIN(id) as keep_id'))
            ->groupBy('name', 'category', 'role')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->each(function ($leader) {
                DB::table('leaders')
                    ->where('name', $leader->name)
                    ->where('category', $leader->category)
                    ->where('role', $leader->role)
                    ->where('id', '<>', $leader->keep_id)
                    ->delete();
            });

        DB::table('activities')
            ->select('title', DB::raw('MIN(id) as keep_id'))
            ->groupBy('title')
            ->havingRaw('COUNT(*) > 1')
            ->get()
            ->each(function ($activity) {
                DB::table('activities')
                    ->where('title', $activity->title)
                    ->where('id', '<>', $activity->keep_id)
                    ->delete();
            });

        DB::table('activities')
            ->whereNull('slug')
            ->orderBy('id')
            ->get()
            ->each(function ($activity) {
                $slug = Str::slug($activity->title);

                if (DB::table('activities')->where('slug', $slug)->where('id', '<>', $activity->id)->exists()) {
                    $slug .= '-'.$activity->id;
                }

                DB::table('activities')->where('id', $activity->id)->update(['slug' => $slug]);
            });
    }

    public function down(): void
    {
        //
    }
};
