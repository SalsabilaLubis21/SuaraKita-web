<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Story;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function index()
    {
        $user = Auth::user();
        $stories = Story::where('user_id', $user->id)->get();

        return view('user.dashboard', compact('stories'));
    }
}
