<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminArticleController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index(Request $request)
    {
        
        $query = Article::orderBy('created_at', 'desc');

        
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

       
        $articles = $query->get();

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        return view('admin.articles.create');
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'cover_image' => 'nullable|image|max:2048',
            'cover_image_url' => 'nullable|url',
            'published_at' => 'nullable|date',
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('public/cover_images');
            $coverImage = basename($path);
        } elseif (!empty($validatedData['cover_image_url'])) {
            $coverImage = $validatedData['cover_image_url'];
        } else {
            $coverImage = null;
        }

        $article = new Article();
        $article->title = $validatedData['title'];
        $article->slug = Str::slug($validatedData['title']);
        $article->category = $validatedData['category'];
        $article->summary = $validatedData['summary'] ?? null;
        $article->content = $validatedData['content'];
        $article->cover_image = $coverImage;
        $article->published_at = $validatedData['published_at'] ?? null;

        if (auth('admin')->check()) {
            $article->admin_id = auth('admin')->id();
        }

        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'Article published successfully.');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        return view('admin.articles.edit', compact('article'));
    }
    /**
     * Display the specified article.
     */
    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        // Logic to update article
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Article deleted successfully.');
    }
}