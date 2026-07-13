<?php

use Illuminate\Support\Facades\Route;
use App\Support\MockData;
use Illuminate\Http\Request;

// 1. Home Page Route
Route::get('/', function () {
    $articles = MockData::getArticles();
    $webStories = MockData::getWebStories();
    $photos = MockData::getPhotos();
    $videos = MockData::getVideos();
    $tags = MockData::getTrendingTags();
    
    // Split articles into featured, trending, category list
    $featured = collect($articles)->firstWhere('is_featured', true) ?? reset($articles);
    $others = collect($articles)->reject(fn($a) => $a['id'] === $featured['id'])->values()->all();
    
    return view('pages.home', compact('featured', 'others', 'webStories', 'photos', 'videos', 'tags'));
})->name('home');

// 2. Category Page
Route::get('/category/{slug}', function ($slug) {
    $categories = MockData::getCategories();
    
    if (!array_key_exists($slug, $categories)) {
        abort(404);
    }
    
    $category = $categories[$slug];
    $category['slug'] = $slug;
    $allArticles = MockData::getArticles();
    
    $articles = collect($allArticles)
        ->filter(fn($a) => $a['category'] === $slug)
        ->values()
        ->all();
        
    return view('pages.category', compact('category', 'articles'));
})->name('category');

// 3. Subcategory Page
Route::get('/category/{category_slug}/{subcategory_slug}', function ($category_slug, $subcategory_slug) {
    $categories = MockData::getCategories();
    
    if (!array_key_exists($category_slug, $categories)) {
        abort(404);
    }
    
    $category = $categories[$category_slug];
    $category['slug'] = $category_slug;
    
    // Normalize and search for the subcategory
    $subMatched = false;
    foreach ($category['subcategories'] as $sub) {
        if (strtolower(str_replace(' ', '-', $sub)) === strtolower($subcategory_slug)) {
            $subcategory_slug = $sub; // use original name
            $subMatched = true;
            break;
        }
    }
    
    if (!$subMatched) {
        abort(404);
    }
    
    $allArticles = MockData::getArticles();
    $articles = collect($allArticles)
        ->filter(fn($a) => $a['category'] === $category_slug && strtolower(str_replace(' ', '-', $a['subcategory'])) === strtolower(str_replace(' ', '-', $subcategory_slug)))
        ->values()
        ->all();
        
    return view('pages.subcategory', compact('category', 'subcategory_slug', 'articles'));
})->name('subcategory');

// 4. Single News Article Route
Route::get('/news/{slug}', function ($slug) {
    $articles = MockData::getArticles();
    $article = collect($articles)->firstWhere('slug', $slug);
    
    if (!$article) {
        abort(404);
    }
    
    $comments = MockData::getComments();
    $related = collect($articles)
        ->reject(fn($a) => $a['id'] === $article['id'])
        ->filter(fn($a) => $a['category'] === $article['category'])
        ->take(3)
        ->values()
        ->all();
        
    return view('pages.single', compact('article', 'comments', 'related'));
})->name('news.single');

// 5. Author Page Route
Route::get('/author/{slug}', function ($slug) {
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
        
    return view('pages.author', compact('author', 'articles'));
})->name('author');

// 6. Search Page Route
Route::get('/search', function (Request $request) {
    $query = $request->query('q', '');
    $allArticles = MockData::getArticles();
    
    $articles = [];
    if (!empty($query)) {
        $articles = collect($allArticles)
            ->filter(function($a) use ($query) {
                return stripos($a['title'], $query) !== false || 
                       stripos($a['subtitle'], $query) !== false ||
                       stripos($a['summary'], $query) !== false;
            })
            ->values()
            ->all();
    }
    
    return view('pages.search', compact('query', 'articles'));
})->name('search');

// 7. Tag Page Route
Route::get('/tag/{slug}', function ($slug) {
    $allArticles = MockData::getArticles();
    
    $articles = collect($allArticles)
        ->filter(function($a) use ($slug) {
            return collect($a['tags'])->contains(fn($t) => strtolower($t) === strtolower($slug));
        })
        ->values()
        ->all();
        
    return view('pages.tag', compact('slug', 'articles'));
})->name('tag');

// 8. Archive Route
Route::get('/archive', function () {
    $articles = MockData::getArticles();
    return view('pages.archive', compact('articles'));
})->name('archive');

// 9. Photo Gallery Route
Route::get('/photos', function () {
    $photos = MockData::getPhotos();
    return view('pages.photos', compact('photos'));
})->name('photos');

// 10. Video Gallery Route
Route::get('/videos', function () {
    $videos = MockData::getVideos();
    $featured = reset($videos);
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

// Admin Panel Routing Group
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/news', function () {
        return view('admin.news.index');
    })->name('news.index');

    Route::get('/news/create', function () {
        return view('admin.news.editor');
    })->name('news.create');

    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('categories.index');

    Route::get('/live-blog', function () {
        return view('admin.live-blog.index');
    })->name('live-blog.index');


    Route::get('/ads', function () {
        return view('admin.ads.index');
    })->name('ads.index');

    Route::get('/seo', function () {
        return view('admin.seo.index');
    })->name('seo.index');

    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');

    Route::get('/media', function () {
        return view('admin.media.index');
    })->name('media.index');

    Route::get('/web-stories', function () {
        return view('admin.web-stories.index');
    })->name('web-stories.index');

    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');

    Route::get('/code-injections', function () {
        return view('admin.code-injections.index');
    })->name('code-injections.index');

    Route::get('/support', function () {
        return view('admin.support.index');
    })->name('support.index');
});

// Fallback route (handles 404 rendering)
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
