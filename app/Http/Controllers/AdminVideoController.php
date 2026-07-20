<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminVideoController extends Controller
{
    /**
     * Display a listing of video news articles.
     */
    public function index()
    {
        $articles = Article::with(['category', 'author'])
            ->whereIn('media_type', ['video_file', 'video_link'])
            ->latest()
            ->paginate(15);
            
        return view('admin.videos.index', compact('articles'));
    }

    /**
     * Show the form for creating a new video news article.
     */
    public function create()
    {
        $categories = Category::with('subcategories')->whereNull('parent_id')->get();
        return view('admin.videos.create', compact('categories'));
    }

    /**
     * Store a newly created video news article.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'media_type' => 'required|string|in:video_file,video_link',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,webm,ogg,avi,mov|max:20480',
            'media_link' => 'nullable|string|max:1000',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_breaking' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        // Ensure slug is unique
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $mediaType = $request->input('media_type');
        $imagePath = null;
        $videoPath = null;
        $mediaLink = null;

        // If thumbnail image uploaded
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'article_' . time() . '.' . $file->getClientOriginalExtension();
            if (!file_exists(public_path('uploads/articles'))) {
                mkdir(public_path('uploads/articles'), 0755, true);
            }
            $file->move(public_path('uploads/articles'), $filename);
            $imagePath = '/uploads/articles/' . $filename;
        }

        if ($mediaType === 'video_file' && $request->hasFile('video')) {
            $file = $request->file('video');
            $filename = 'video_' . time() . '.' . $file->getClientOriginalExtension();
            if (!file_exists(public_path('uploads/videos'))) {
                mkdir(public_path('uploads/videos'), 0755, true);
            }
            $file->move(public_path('uploads/videos'), $filename);
            $videoPath = '/uploads/videos/' . $filename;
        } elseif ($mediaType === 'video_link') {
            $mediaLink = $request->media_link;
        }

        Article::create([
            'title' => $request->title,
            'slug' => $slug,
            'subtitle' => $request->subtitle,
            'summary' => $request->summary,
            'content' => $request->content,
            'image_path' => $imagePath,
            'media_type' => $mediaType,
            'video_path' => $videoPath,
            'media_link' => $mediaLink,
            'category_id' => $request->category_id,
            'user_id' => Auth::id(),
            'is_featured' => $request->has('is_featured'),
            'is_breaking' => $request->has('is_breaking'),
            'tags' => $request->tags,
            'published_at' => $request->published_at ?: now(),
        ]);

        return redirect()->route('admin.videos.index')->with('success', 'Video news created successfully!');
    }

    /**
     * Show the form for editing the specified video news article.
     */
    public function edit($id)
    {
        $article = Article::whereIn('media_type', ['video_file', 'video_link'])->findOrFail($id);
        $categories = Category::with('subcategories')->whereNull('parent_id')->get();
        return view('admin.videos.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified video news article.
     */
    public function update(Request $request, $id)
    {
        $article = Article::whereIn('media_type', ['video_file', 'video_link'])->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'media_type' => 'required|string|in:video_file,video_link',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'video' => 'nullable|mimes:mp4,webm,ogg,avi,mov|max:20480',
            'media_link' => 'nullable|string|max:1000',
            'tags' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
            'is_breaking' => 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);

        $slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);

        // Ensure slug is unique but ignore current article
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $mediaType = $request->input('media_type');

        $data = [
            'title' => $request->title,
            'slug' => $slug,
            'subtitle' => $request->subtitle,
            'summary' => $request->summary,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'media_type' => $mediaType,
            'is_featured' => $request->has('is_featured'),
            'is_breaking' => $request->has('is_breaking'),
            'tags' => $request->tags,
            'published_at' => $request->published_at ?: $article->published_at,
        ];

        // 1. Reset values if type has changed
        if ($mediaType !== $article->media_type) {
            if ($mediaType === 'video_file') {
                $data['media_link'] = null;
            } elseif ($mediaType === 'video_link') {
                $data['video_path'] = null;
            }
        }

        // 2. Handle cover image upload
        if ($request->hasFile('image')) {
            if ($article->image_path && file_exists(public_path($article->image_path))) {
                @unlink(public_path($article->image_path));
            }
            $file = $request->file('image');
            $filename = 'article_' . time() . '.' . $file->getClientOriginalExtension();
            if (!file_exists(public_path('uploads/articles'))) {
                mkdir(public_path('uploads/articles'), 0755, true);
            }
            $file->move(public_path('uploads/articles'), $filename);
            $data['image_path'] = '/uploads/articles/' . $filename;
        }

        // 3. Handle file uploads and link updates
        if ($mediaType === 'video_file') {
            if ($request->hasFile('video')) {
                if ($article->video_path && file_exists(public_path($article->video_path))) {
                    @unlink(public_path($article->video_path));
                }
                $file = $request->file('video');
                $filename = 'video_' . time() . '.' . $file->getClientOriginalExtension();
                if (!file_exists(public_path('uploads/videos'))) {
                    mkdir(public_path('uploads/videos'), 0755, true);
                }
                $file->move(public_path('uploads/videos'), $filename);
                $data['video_path'] = '/uploads/videos/' . $filename;
            }
        } elseif ($mediaType === 'video_link') {
            $data['media_link'] = $request->media_link;
        }

        $article->update($data);

        return redirect()->route('admin.videos.index')->with('success', 'Video news updated successfully!');
    }

    /**
     * Remove the specified video news article.
     */
    public function destroy($id)
    {
        $article = Article::whereIn('media_type', ['video_file', 'video_link'])->findOrFail($id);
        
        // Delete files
        if ($article->image_path && file_exists(public_path($article->image_path))) {
            @unlink(public_path($article->image_path));
        }
        if ($article->video_path && file_exists(public_path($article->video_path))) {
            @unlink(public_path($article->video_path));
        }

        $article->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video news deleted successfully!');
    }
}
