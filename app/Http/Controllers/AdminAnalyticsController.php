<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Article;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        // Fetch articles with view counts
        $articles = Article::orderBy('view_count', 'desc')->paginate(15);

        // Aggregate view counts by year and month
        $monthlyViews = DB::table('articles')
            ->select(DB::raw('YEAR(updated_at) as year, MONTH(updated_at) as month, SUM(view_count) as total_views'))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Aggregate view counts by year
        $yearlyViews = DB::table('articles')
            ->select(DB::raw('YEAR(updated_at) as year, SUM(view_count) as total_views'))
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        return view('admin.analytics.index', compact('articles', 'monthlyViews', 'yearlyViews'));
    }
}
