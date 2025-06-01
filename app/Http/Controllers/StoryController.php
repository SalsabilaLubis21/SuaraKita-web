<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoryController extends Controller
{
    public function index()
    {
        $stories = Story::latest()->paginate(10);
        return view('stories.index', compact('stories'));
    }

    public function show($id)
    {
        $story = Story::with(['user', 'comments.user'])->findOrFail($id);
        return view('stories.show', compact('story'));
    }

    public function addComment(Request $request, $storyId)
    {
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);

        $story = Story::findOrFail($storyId);

        $comment = new Comment();
        $comment->story_id = $story->id;
        $comment->content = $request->input('comment');

        if (Auth::check()) {
            $comment->user_id = Auth::id();
            $comment->anonymous = false;
        } else {
            $comment->user_id = null;
            $comment->anonymous = true;
        }

        $comment->save();

        return redirect()->route('stories.show', $story->id)->with('success', 'Comment added successfully.');
    }

    public function create()
    {
        return view('stories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $story = new Story();
        $story->title = $request->input('title');
        $story->content = $request->input('content');
        $story->user_id = Auth::check() ? Auth::id() : null;
        $story->save();

        return redirect()->route('stories.show', $story->id)->with('success', 'Story created successfully.');
    }

    public function edit($id)
    {
        $story = Story::findOrFail($id);
        return view('stories.edit', compact('story'));
    }
}
