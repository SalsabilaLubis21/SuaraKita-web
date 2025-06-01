<?php

use Illuminate\Support\Facades\Route;

Route::get('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot.password.form');
Route::post('/forgot-password', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'submitForgotPasswordForm'])->name('forgot.password.submit');


use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\UserDashboardController;

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\CommentController;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::get('/login-choice', function () {
    return view('auth.login_choice');
})->name('login.choice');

// Authentication routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Admin dashboard route
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Rute untuk Manajemen Artikel
    Route::resource('articles', App\Http\Controllers\AdminArticleController::class);

    // Rute untuk Manajemen Cerita (Stories)
    Route::resource('stories', App\Http\Controllers\AdminStoryController::class);

    // Rute untuk Moderasi Komentar (Comments)
    Route::resource('comments', App\Http\Controllers\AdminCommentController::class);

    // Rute untuk Manajemen User
    Route::resource('users', App\Http\Controllers\AdminUserController::class)->only(['index', 'destroy']);

    // Rute untuk Analytics
    Route::get('analytics', [App\Http\Controllers\AdminAnalyticsController::class, 'index'])->name('analytics.index');

    // Rute untuk Settings
    Route::get('settings', [App\Http\Controllers\AdminSettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [App\Http\Controllers\AdminSettingsController::class, 'update'])->name('settings.update');
});

// User dashboard route
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

    // Story edit and delete routes for users
    Route::get('/stories/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
    Route::put('/stories/{story}', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');

    // Add route for user add story page
    Route::get('/add-story', [StoryController::class, 'create'])->name('user.add_story');
});

// Articles routes
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');

// Stories routes
Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('/stories/create', [StoryController::class, 'create'])->name('stories.create');
Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
Route::get('/stories/{id}', [StoryController::class, 'show'])->name('stories.show');

// Comments routes
Route::post('/stories/{storyId}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
Route::middleware(['auth'])->group(function () {
    Route::post('/articles/{id}/like', [ArticleController::class, 'like'])->name('articles.like');
    Route::post('/articles/{id}/unlike', [ArticleController::class, 'unlike'])->name('articles.unlike');
    Route::post('/articles/{id}/bookmark', [ArticleController::class, 'bookmark'])->name('articles.bookmark');
    Route::post('/articles/{id}/unbookmark', [ArticleController::class, 'unbookmark'])->name('articles.unbookmark');
});
