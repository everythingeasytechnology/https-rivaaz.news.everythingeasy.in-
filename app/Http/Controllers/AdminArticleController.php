<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::with(['category', 'author'])
            ->latest()
            ->paginate(15);
            
        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::with('subcategories')->whereNull('parent_id')->get();
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
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
            'media_type' => 'required|string|in:image_file,image_link,video_file,video_link',
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

        $mediaType = $request->input('media_type', 'image_file');
        $imagePath = null;
        $videoPath = null;
        $mediaLink = null;

        if ($mediaType === 'image_file' && $request->hasFile('image')) {
            $file = $request->file('image');
            $filename = 'article_' . time() . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/articles'))) {
                mkdir(public_path('uploads/articles'), 0755, true);
            }
            
            $file->move(public_path('uploads/articles'), $filename);
            $imagePath = '/uploads/articles/' . $filename;
        } elseif ($mediaType === 'image_link') {
            $mediaLink = $request->media_link;
        } elseif ($mediaType === 'video_file' && $request->hasFile('video')) {
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

        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::with('subcategories')->whereNull('parent_id')->get();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'media_type' => 'required|string|in:image_file,image_link,video_file,video_link',
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

        $mediaType = $request->input('media_type', 'image_file');

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
            if ($mediaType === 'image_file') {
                $data['video_path'] = null;
                $data['media_link'] = null;
            } elseif ($mediaType === 'image_link') {
                $data['image_path'] = null;
                $data['video_path'] = null;
            } elseif ($mediaType === 'video_file') {
                $data['image_path'] = null;
                $data['media_link'] = null;
            } elseif ($mediaType === 'video_link') {
                $data['image_path'] = null;
                $data['video_path'] = null;
            }
        }

        // 2. Handle file uploads and link updates
        if ($mediaType === 'image_file') {
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
        } elseif ($mediaType === 'image_link') {
            $data['media_link'] = $request->media_link;
        } elseif ($mediaType === 'video_file') {
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

        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully!');
    }
}
