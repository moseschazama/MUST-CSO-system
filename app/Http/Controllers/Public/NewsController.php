<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('category');

        $query = Announcement::published()->latestFirst();

        if ($category && array_key_exists($category, Announcement::CATEGORIES)) {
            $query->where('category', $category);
        }

        return view('news.index', [
            'featured' => Announcement::published()->featuredOrdered()->first(),
            'articles' => $query->paginate(9)->withQueryString(),
            'categories' => Announcement::CATEGORIES,
            'category' => $category,
            'events' => Event::upcoming()->take(3)->get(),
            'reports' => Report::latestFirst()->take(3)->get(),
        ]);
    }

    public function show(Announcement $announcement): View
    {
        abort_unless($announcement->is_published || optional(auth()->user())->is_admin, 404);

        return view('news.show', [
            'article' => $announcement,
            'related' => Announcement::published()
                ->whereKeyNot($announcement->id)
                ->where('category', $announcement->category)
                ->latestFirst()
                ->take(3)
                ->get(),
        ]);
    }
}
