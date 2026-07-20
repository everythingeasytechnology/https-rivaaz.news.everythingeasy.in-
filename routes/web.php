<?php

use Illuminate\Support\Facades\Route;
use App\Support\MockData;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Support\Str;

function formatArticleForView($articleModel) {
    if (!$articleModel) return null;
    
    $categorySlug = '';
    $categoryName = '';
    $subcategoryName = '';
    
    if ($articleModel->category) {
        if ($articleModel->category->parent) {
            $categorySlug = $articleModel->category->parent->slug;
            $categoryName = $articleModel->category->parent->name;
            $subcategoryName = $articleModel->category->name;
        } else {
            $categorySlug = $articleModel->category->slug;
            $categoryName = $articleModel->category->name;
            $subcategoryName = '';
        }
    }
    
    $mediaType = $articleModel->media_type ?? 'image_file';
    $isVideo = in_array($mediaType, ['video_file', 'video_link']);
    $videoUrl = '';
    $imageUrl = '';

    if ($mediaType === 'image_file') {
        $imageUrl = $articleModel->image_path ?: 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=800&q=80';
    } elseif ($mediaType === 'image_link') {
        $imageUrl = $articleModel->media_link ?: 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?auto=format&fit=crop&w=800&q=80';
    } elseif ($mediaType === 'video_file') {
        $videoUrl = $articleModel->video_path;
        $imageUrl = 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=800&q=80';
    } elseif ($mediaType === 'video_link') {
        $videoUrl = $articleModel->media_link;
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $videoUrl, $matches)) {
            $imageUrl = 'https://img.youtube.com/vi/' . $matches[1] . '/hqdefault.jpg';
            $videoUrl = 'https://www.youtube.com/embed/' . $matches[1];
        } elseif (preg_match('/vimeo\.com\/([0-9]+)/', $videoUrl, $matches)) {
            $videoUrl = 'https://player.vimeo.com/video/' . $matches[1];
            $imageUrl = 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=800&q=80';
        } else {
            $imageUrl = 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=800&q=80';
        }
    }
    
    return [
        'id' => $articleModel->id,
        'slug' => $articleModel->slug,
        'title' => $articleModel->title,
        'subtitle' => $articleModel->subtitle,
        'summary' => $articleModel->summary,
        'content' => $articleModel->content,
        'category' => $categorySlug,
        'category_name' => $categoryName,
        'subcategory' => $subcategoryName,
        'is_video' => $isVideo,
        'video_url' => $videoUrl,
        'media_type' => $mediaType,
        'author_key' => $articleModel->author ? Str::slug($articleModel->author->name) : 'staff-writer',
        'author' => [
            'name' => $articleModel->author->name ?? 'Staff Writer',
            'title' => ($articleModel->author && $articleModel->author->role === 'super_admin') ? 'Editor-in-Chief' : 'Staff Reporter',
            'avatar' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
            'bio' => 'Professional reporter covering breaking news.',
            'twitter' => '@rivaaznews',
        ],
        'image' => $imageUrl,
        'read_time' => '4 मिनट पढ़ने का समय',
        'views' => $articleModel->views >= 1000 ? number_format($articleModel->views / 1000, 1) . 'K' : $articleModel->views,
        'published_at' => $articleModel->published_at ? $articleModel->published_at->format('M d, Y h:i A') : '',
        'updated_at' => $articleModel->updated_at ? $articleModel->updated_at->format('M d, Y h:i A') : '',
        'tags' => $articleModel->tags_array,
        'is_featured' => $articleModel->is_featured,
        'is_breaking' => $articleModel->is_breaking,
    ];
}

// 1. Home Page Route
Route::get('/', function () {
    $dbArticles = Article::with(['category.parent', 'author'])->get();
    $articles = $dbArticles->map(fn($a) => formatArticleForView($a))->toArray();

    $dbCategories = \App\Models\Category::whereNull('parent_id')->get();
    if ($dbCategories->count() > 0) {
        $categoriesList = $dbCategories->map(fn($c) => [
            'name' => $c->name,
            'slug' => $c->slug,
        ])->toArray();
    } else {
        $mockCats = MockData::getCategories();
        $categoriesList = [];
        foreach ($mockCats as $slug => $data) {
            $categoriesList[] = [
                'name' => $data['name'],
                'slug' => $slug,
            ];
        }
    }

    $webStories = MockData::getWebStories();
    $videos = MockData::getVideos();
    $tags = MockData::getTrendingTags();
    
    // Split articles into featured, trending, category list
    $featured = collect($articles)->firstWhere('is_featured', true) ?? reset($articles);
    $others = collect($articles)->reject(fn($a) => $a['id'] === $featured['id'])->values()->all();
    
    return view('pages.home', compact('featured', 'others', 'articles', 'webStories', 'videos', 'tags', 'categoriesList'));
})->name('home');

// 2. Category Page
Route::get('/category/{slug}', function ($slug) {
    // Try DB first
    $dbCategory = Category::with('subcategories')->where('slug', $slug)->first();
    
    if ($dbCategory) {
        $category = [
            'name' => $dbCategory->name,
            'slug' => $dbCategory->slug,
            'subcategories' => $dbCategory->subcategories->pluck('name')->toArray(),
            'meta_title' => $dbCategory->meta_title,
            'meta_description' => $dbCategory->meta_description,
            'meta_keywords' => $dbCategory->meta_keywords,
        ];
        
        $categoryIds = $dbCategory->subcategories->pluck('id')->push($dbCategory->id)->toArray();
        $dbArticles = Article::with(['category.parent', 'author'])
            ->whereIn('category_id', $categoryIds)
            ->get();
            
        $articles = $dbArticles->map(fn($a) => formatArticleForView($a))->toArray();
    } else {
        $categories = MockData::getCategories();
        if (!array_key_exists($slug, $categories)) {
            abort(404);
        }
        $category = $categories[$slug];
        $category['slug'] = $slug;
        
        $allArticles = MockData::getArticles();
        $articles = collect($allArticles)
            ->filter(fn($a) => strtolower($a['category']) === strtolower($slug))
            ->values()
            ->all();
    }
    
    return view('pages.category', compact('category', 'articles'));
})->name('category');

// 3. Subcategory Page
Route::get('/category/{category_slug}/{subcategory_slug}', function ($category_slug, $subcategory_slug) {
    // Try DB first
    $dbCategory = Category::where('slug', $category_slug)->first();
    $dbSubcategory = null;
    
    if ($dbCategory) {
        $dbSubcategory = Category::where('slug', $subcategory_slug)
            ->where('parent_id', $dbCategory->id)
            ->first();
    }
    
    if ($dbCategory && $dbSubcategory) {
        $category = [
            'name' => $dbCategory->name,
            'slug' => $dbCategory->slug,
            'subcategories' => $dbCategory->subcategories->pluck('name')->toArray(),
        ];
        $subcategory_name = $dbSubcategory->name;
        $seo = [
            'meta_title' => $dbSubcategory->meta_title,
            'meta_description' => $dbSubcategory->meta_description,
            'meta_keywords' => $dbSubcategory->meta_keywords,
        ];
        
        $dbArticles = Article::with(['category.parent', 'author'])
            ->where('category_id', $dbSubcategory->id)
            ->get();
            
        $articles = $dbArticles->map(fn($a) => formatArticleForView($a))->toArray();
    } else {
        $categories = MockData::getCategories();
        if (!array_key_exists($category_slug, $categories)) {
            abort(404);
        }
        $category = $categories[$category_slug];
        $category['slug'] = $category_slug;
        
        $subMatched = false;
        foreach ($category['subcategories'] as $sub) {
            if (strtolower(Str::slug($sub)) === strtolower($subcategory_slug)) {
                $subcategory_slug = $sub;
                $subMatched = true;
                break;
            }
        }
        if (!$subMatched) {
            abort(404);
        }
        $subcategory_name = $subcategory_slug;
        $seo = null;
        
        $allArticles = MockData::getArticles();
        $articles = collect($allArticles)
            ->filter(fn($a) => strtolower($a['category']) === strtolower($category_slug) && strtolower(Str::slug($a['subcategory'])) === strtolower(Str::slug($subcategory_name)))
            ->values()
            ->all();
    }
    
    return view('pages.subcategory', [
        'category' => $category,
        'subcategory_slug' => $subcategory_name,
        'articles' => $articles,
        'seo' => $seo
    ]);
})->name('subcategory');

// 4. Single News Article Route
Route::get('/news/{slug}', function ($slug) {
    $dbArticle = Article::with(['category.parent', 'author'])->where('slug', $slug)->first();
    
    if ($dbArticle) {
        // Increment views
        $dbArticle->increment('views');
        
        $article = formatArticleForView($dbArticle);
        
        $dbRelated = Article::with(['category.parent', 'author'])
            ->where('category_id', $dbArticle->category_id)
            ->where('id', '!=', $dbArticle->id)
            ->take(3)
            ->get();
            
        $related = $dbRelated->map(fn($r) => formatArticleForView($r))->toArray();
    } else {
        $articles = MockData::getArticles();
        $article = collect($articles)->firstWhere('slug', $slug);
        
        if (!$article) {
            abort(404);
        }
        
        $related = collect($articles)
            ->reject(fn($a) => $a['id'] === $article['id'])
            ->filter(fn($a) => $a['category'] === $article['category'])
            ->take(3)
            ->values()
            ->all();
    }
    
    $comments = MockData::getComments();
    
    return view('pages.single', compact('article', 'comments', 'related'));
})->name('news.single');

// 5. Author Page Route
Route::get('/author/{slug}', function ($slug) {
    // Rajesh Sharma -> rajesh-sharma
    $dbUser = \App\Models\User::all()->first(fn($u) => Str::slug($u->name) === $slug);
    
    if ($dbUser) {
        $author = [
            'name' => $dbUser->name,
            'slug' => $slug,
            'title' => $dbUser->role === 'super_admin' ? 'Editor-in-Chief' : 'Staff Reporter',
            'avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
            'bio' => 'Professional journalist covering national affairs.',
            'twitter' => '@rivaaznews',
            'articles_count' => Article::where('user_id', $dbUser->id)->count(),
        ];
        
        $dbArticles = Article::with(['category.parent', 'author'])
            ->where('user_id', $dbUser->id)
            ->get();
            
        $articles = $dbArticles->map(fn($a) => formatArticleForView($a))->toArray();
    } else {
        $authors = MockData::getAuthors();
        if (!array_key_exists($slug, $authors)) {
            abort(404);
        }
        $author = $authors[$slug];
        $author['slug'] = $slug;
        
        $allArticles = MockData::getArticles();
        $articles = collect($allArticles)
            ->filter(fn($a) => $a['author_key'] === $slug)
            ->values()
            ->all();
    }
    
    return view('pages.author', compact('author', 'articles'));
})->name('author');

// 6. Search Page Route
Route::get('/search', function (Request $request) {
    $query = $request->query('q', '');
    
    if (!empty($query)) {
        $dbArticles = Article::with(['category.parent', 'author'])
            ->where('title', 'LIKE', "%{$query}%")
            ->orWhere('subtitle', 'LIKE', "%{$query}%")
            ->orWhere('summary', 'LIKE', "%{$query}%")
            ->orWhere('content', 'LIKE', "%{$query}%")
            ->get();
            
        $articles = $dbArticles->map(fn($a) => formatArticleForView($a))->toArray();
    } else {
        $articles = [];
    }
    
    return view('pages.search', compact('query', 'articles'));
})->name('search');

// 7. Tag Page Route
Route::get('/tag/{slug}', function ($slug) {
    $dbArticles = Article::with(['category.parent', 'author'])
        ->where('tags', 'LIKE', "%{$slug}%")
        ->get();
        
    $articles = $dbArticles->map(fn($a) => formatArticleForView($a))->toArray();
    
    return view('pages.tag', compact('slug', 'articles'));
})->name('tag');

// 8. Archive Route
Route::get('/archive', function () {
    $dbArticles = Article::with(['category.parent', 'author'])->get();
    $articles = $dbArticles->map(fn($a) => formatArticleForView($a))->toArray();
    
    return view('pages.archive', compact('articles'));
})->name('archive');


// 10. Video Gallery Route
Route::get('/videos', function () {
    $dbArticles = \App\Models\Article::with(['category', 'author'])
        ->whereIn('media_type', ['video_file', 'video_link'])
        ->orderByDesc('published_at')
        ->get();

    // Map database articles to the structure used by pages.videos
    $videos = $dbArticles->map(function ($article) {
        $videoUrl = '';
        $youtubeId = '';
        
        if ($article->media_type === 'video_file') {
            $videoUrl = asset($article->video_path);
        } else {
            $videoUrl = $article->media_link;
            
            // Extract youtube ID if it is a youtube link
            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/|youtube\.com\/live\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
                $youtubeId = $matches[1];
                $videoUrl = 'https://www.youtube.com/embed/' . $youtubeId;
            } elseif (preg_match('/vimeo\.com\/([0-9]+)/', $videoUrl, $matches)) {
                $videoUrl = 'https://player.vimeo.com/video/' . $matches[1];
            }
        }

        // Thumbnail image
        $imageUrl = 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=600&q=80';
        if ($article->media_type === 'video_link' && !empty($youtubeId)) {
            $imageUrl = 'https://img.youtube.com/vi/' . $youtubeId . '/hqdefault.jpg';
        } else {
            $imageUrl = $article->image_path ? asset($article->image_path) : 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=600&q=80';
        }

        return [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'summary' => $article->summary,
            'image' => $imageUrl,
            'video_url' => $videoUrl,
            'youtube_id' => $youtubeId,
            'is_local' => $article->media_type === 'video_file',
            'views' => $article->views >= 1000 ? number_format($article->views / 1000, 1) . 'K views' : $article->views . ' views',
            'date' => $article->published_at ? $article->published_at->format('M d, Y') : '',
            'duration' => 'वीडियो',
            'category' => $article->category ? $article->category->name : 'खेल',
        ];
    })->toArray();

    if (!empty($videos)) {
        $featured = reset($videos);
    } else {
        $featured = null;
    }

    return view('pages.videos', compact('featured', 'videos'));
})->name('videos');

// 11. Live Blog Page Route
Route::get('/live-blog/{slug}', function ($slug) {
    $articles = MockData::getArticles();
    $article = collect($articles)->firstWhere('slug', $slug);
    
    if (!$article) {
        abort(404);
    }
    
    $events = MockData::getLiveEvents();
    
    return view('pages.live-blog', compact('article', 'events'));
})->name('live_blog');

// 12. Contact Page Route
Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

// 13. About Page Route
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

// 14. Privacy Policy Route
Route::get('/privacy', function () {
    return view('pages.privacy');
})->name('privacy');

// 15. Terms of Service Route
Route::get('/terms', function () {
    return view('pages.terms');
})->name('terms');

// 16. 404 Testing Route
Route::get('/404-test', function () {
    abort(404);
});



// Auth Routes
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware('role')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', \App\Http\Controllers\AdminCategoryController::class);
    Route::resource('articles', \App\Http\Controllers\AdminArticleController::class);
    Route::resource('videos', \App\Http\Controllers\AdminVideoController::class);
    
    // Live TV Routes
    Route::get('livetv', [\App\Http\Controllers\AdminLiveTvController::class, 'edit'])->name('livetv.edit');
    Route::put('livetv', [\App\Http\Controllers\AdminLiveTvController::class, 'update'])->name('livetv.update');
    
    // Weather API Routes
    Route::get('weather', [\App\Http\Controllers\AdminWeatherController::class, 'edit'])->name('weather.edit');
    Route::put('weather', [\App\Http\Controllers\AdminWeatherController::class, 'update'])->name('weather.update');
    
    // Super Admin Only
    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\AdminUserController::class);
        Route::get('settings', [\App\Http\Controllers\AdminSettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [\App\Http\Controllers\AdminSettingController::class, 'update'])->name('settings.update');
    });
});

// Fallback route (handles 404 rendering)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
