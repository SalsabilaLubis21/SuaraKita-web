<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
        $role = $request->query('role', 'user');
        return view('auth.login', compact('role'));
    }

    public function login(Request $request)
    {
        \Log::debug('Login attempt', ['request' => $request->all()]);

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $role = $request->input('role', 'user');
        $redirectAction = $request->input('redirect_action');
        $articleId = $request->input('article_id');

        if ($role === 'admin') {
            \Log::debug('Admin login attempt', ['credentials' => $credentials]);
            // Attempt to authenticate against admins table
            if (Auth::guard('admin')->attempt($credentials)) {
                $request->session()->regenerate();
                \Log::info('Admin login successful for email: ' . $request->input('email'));
                return redirect()->intended('/admin/dashboard');
            } else {
                \Log::warning('Admin login failed for email: ' . $request->input('email'));
            }
        } else {
            \Log::debug('User login attempt', ['credentials' => $credentials]);
            // Authenticate against users table
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                \Log::info('User login successful for email: ' . $request->input('email'));

                // Perform like or bookmark action if redirect parameters exist
                if ($redirectAction && $articleId) {
                    $user = Auth::user();
                    if ($redirectAction === 'like') {
                        $user->likes()->syncWithoutDetaching([$articleId]);
                    } elseif ($redirectAction === 'bookmark') {
                        $user->bookmarks()->syncWithoutDetaching([$articleId]);
                    }
                    return redirect()->route('user.dashboard');
                }

                $redirect = $request->input('redirect');
                return redirect()->intended($redirect ?? '/');
            } else {
                \Log::warning('User login failed for email: ' . $request->input('email'));
            }
        } 

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
