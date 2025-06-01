<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;

class AdminStoryController extends Controller
{
    public function index()
    {
        // List all stories with user info and comments for admin management
        $stories = Story::with('user', 'comments')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.stories.index', compact('stories'));
    }

    public function show($id)
    {
        $story = Story::with('user', 'comments')->findOrFail($id);
        return view('admin.stories.show', compact('story'));
    }

    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        $story->delete();

        return redirect()->route('admin.stories.index')->with('success', 'Story deleted successfully.');
    }
}
