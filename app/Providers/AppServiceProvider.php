<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            try {
                if (Schema::hasTable('categories')) {
                    $navbarCategories = Category::with('subcategories')
                        ->whereNull('parent_id')
                        ->get();
                    View::share('navbarCategories', $navbarCategories);
                }
                
                if (Schema::hasTable('settings')) {
                    $siteSettings = \App\Models\Setting::first();
                    View::share('siteSettings', $siteSettings);
                }

                if (Schema::hasTable('articles')) {
                    $breakingNews = \App\Models\Article::where('is_breaking', true)
                        ->latest()
                        ->take(5)
                        ->get();
                    View::share('breakingNews', $breakingNews);
                }
            } catch (\Exception $e) {
                // Prevent crash during bootstrap
            }
        }
    }
}
