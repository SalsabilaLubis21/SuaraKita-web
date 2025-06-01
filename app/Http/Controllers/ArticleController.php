<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    // Admin middleware can be added here for authorization

    public function index(Request $request)
    {
        $query = Article::with('admin')->whereNotNull('published_at')->orderBy('published_at', 'desc');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        // Get distinct categories from articles table
        $distinctCategories = Article::select('category')->distinct()->pluck('category');

        // Map categories to slug and name
        $categories = $distinctCategories->map(function ($category) {
            return (object)[
                'slug' => Str::slug($category),
                'name' => ucwords($category),
            ];
        });

        
        $categoryMap = $categories->pluck('name', 'slug')->toArray();

        if ($request->has('category') && $request->category != '' && $request->category != 'all') {
            $categorySlug = $request->category;
            // Map slug to actual category name
            $category = $categoryMap[$categorySlug] ?? null;
            if ($category) {
                $query->where('category', $category);
            } else {
                // If category not found in map, no results
                $query->whereRaw('0 = 1');
            }
        }

        $articles = $query->paginate(6)->withQueryString();

        return view('articles.index', compact('articles', 'categoryMap', 'categories'));
    }

    public function show($slug)
    {
        // Show article detail by slug
        $article = Article::where('slug', $slug)->firstOrFail();

        
        $article->increment('view_count');
        
        
        $content = $article->content;
        
        
        $content = '<p>' . str_replace("\n\n", '</p><p>', $content) . '</p>';
        
        
        $content = str_replace("\n", '<br>', $content);
        
      
        $content = str_replace('<p></p>', '', $content);
        
        $article->processed_content = $content;
        
        return view('articles.show', compact('article'));
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'cover_image' => 'required|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $slug = Str::slug($request->title);

        Article::create([
            'admin_id' => auth()->id(),
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'cover_image' => $request->cover_image,
            'content' => $request->content,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article created successfully.');
    }

    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'cover_image' => 'required|string',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $slug = Str::slug($request->title);

        $article->update([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'cover_image' => $request->cover_image,
            'content' => $request->content,
            'published_at' => $request->published_at,
        ]);

        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index')->with('success', 'Article deleted successfully.');
    }

    public function like($id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();
        $user->likes()->syncWithoutDetaching([$article->id]);
        return back()->with('success', 'Article liked.');
    }

    public function unlike($id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();
        $user->likes()->detach($article->id);
        return back()->with('success', 'Like removed.');
    }

    public function bookmark($id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();
        $user->bookmarks()->syncWithoutDetaching([$article->id]);
        return back()->with('success', 'Article bookmarked.');
    }

    public function unbookmark($id)
    {
        $article = Article::findOrFail($id);
        $user = Auth::user();
        $user->bookmarks()->detach($article->id);
        return back()->with('success', 'Bookmark removed.');
    }
}
