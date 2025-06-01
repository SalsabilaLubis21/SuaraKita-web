<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Story;
use App\Models\Comment;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $totalArticles = Article::count();
        $publishedStories = Story::count(); 
        $userComments = Comment::count();
        $activeUsers = User::count(); 

        return view('admin.dashboard', compact('totalArticles', 'publishedStories', 'userComments', 'activeUsers'));
    }
}
