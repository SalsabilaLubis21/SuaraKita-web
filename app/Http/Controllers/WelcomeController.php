<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Story;

class WelcomeController extends Controller
{
    public function index()
    {
        $articles = Article::whereNotNull('published_at')->orderBy('published_at', 'desc')->take(3)->get();
        $stories = Story::with('user')->orderBy('created_at', 'desc')->take(3)->get();
        $featuredArticle = Article::find(1);

        $categories = collect([
            (object)['slug' => 'climate change', 'name' => 'Climate Change'],
            (object)['slug' => 'kesehatan mental', 'name' => 'Mental Health'],
            (object)['slug' => 'lingkungan', 'name' => 'Environment'],
            (object)['slug' => 'kesetaraan gender', 'name' => 'Gender Equality'],
        ]);

        return view('welcome', compact('articles', 'stories', 'featuredArticle', 'categories'));
    }
}
