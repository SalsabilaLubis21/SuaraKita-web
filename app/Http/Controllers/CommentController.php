<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Story;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $storyId)
    {
        $request->validate([
            'commenter_name' => 'nullable|string|max:255',
            'comment' => 'required|string',
        ]);

        $story = Story::findOrFail($storyId);

        $comment = new Comment();
        $comment->story_id = $story->id;
        $comment->user_id = auth()->id() ?? null;
        $comment->commenter_name = $request->commenter_name ?? ($comment->user_id ? null : 'Anonymous');
        $comment->comment = $request->comment;
        $comment->created_at = now();
        $comment->save();

        return redirect()->route('stories.show', $story->id)->with('success', 'Comment added successfully.');
    }

    public function index()
    {
        $comments = Comment::latest()->paginate(10);
        return view('comments.index', compact('comments'));
    }
}
