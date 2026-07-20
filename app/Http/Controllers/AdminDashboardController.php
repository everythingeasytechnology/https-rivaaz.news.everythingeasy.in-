<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $totalArticles = Article::count();
        $totalViews = Article::sum('views');
        $totalCategories = Category::count();
        $totalUsers = User::count();

        // Format total views (e.g., 125300 to "125.3K")
        if ($totalViews >= 1000) {
            $formattedViews = number_format($totalViews / 1000, 1) . 'K';
        } else {
            $formattedViews = $totalViews;
        }

        $latestArticles = Article::with(['category', 'author'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalArticles',
            'formattedViews',
            'totalCategories',
            'totalUsers',
            'latestArticles'
        ));
    }
}
