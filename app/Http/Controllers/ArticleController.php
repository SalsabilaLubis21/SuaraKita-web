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

        
        $categories = $distinctCategories->map(function ($category) {
            return (object)[
                'slug' => Str::slug($category),
                'name' => ucwords($category),
            ];
        });

        
        $categoryMap = $categories->pluck('name', 'slug')->toArray();

        if ($request->has('category') && $request->category != '' && $request->category != 'all') {
            $categorySlug = $request->category;
          
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

        // Sanitize article content to prevent XSS
        $content = $article->content;

        
        $allowed_tags = '<p><br><b><i><strong><em><ul><ol><li><a>';
        $content = strip_tags($content, $allowed_tags);

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
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $slug = Str::slug($request->title);

        // Handle file upload securely
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('public/article_covers', $filename);
            $coverImagePath = 'storage/article_covers/' . $filename;
        } else {
            return back()->withErrors(['cover_image' => 'Cover image upload failed.'])->withInput();
        }

        Article::create([
            'admin_id' => auth()->id(),
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'cover_image' => $coverImagePath,
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
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'published_at' => 'nullable|date',
        ]);

        $slug = Str::slug($request->title);

        // Handle file upload securely if new file is uploaded
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $filename = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('public/article_covers', $filename);
            $coverImagePath = 'storage/article_covers/' . $filename;
        } else {
            $coverImagePath = $article->cover_image;
        }

        $article->update([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'cover_image' => $coverImagePath,
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
