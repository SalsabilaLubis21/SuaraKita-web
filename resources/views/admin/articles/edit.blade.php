@extends('layouts.app')

@section('content')

<link href="{{ asset('css/admin-articles-edit.css') }}" rel="stylesheet" />

<div class="main-container">
    <div class="header">
        <h1>Edit Article</h1>
        <p class="subtitle">Update your educational content with the form below</p>
    </div>

    <div class="form-container">
        <form action="{{ route('articles.update', $article->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title" class="form-label">Article Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $article->title) }}" class="form-input" required>
                <div class="form-icon">📝</div>
            </div>

            <div class="form-group">
                <label for="category" class="form-label">Category</label>
                <input type="text" name="category" id="category" value="{{ old('category', $article->category) }}" class="form-input" required>
                <div class="form-icon">🏷️</div>
            </div>

            <div class="form-group">
                <label for="summary" class="form-label">Summary</label>
                <textarea name="summary" id="summary" class="form-textarea" required>{{ old('summary', $article->summary) }}</textarea>
                <div class="form-icon">📝</div>
            </div>

            <div class="form-group">
                <label for="cover_image" class="form-label">Cover Image URL</label>
                <input type="text" name="cover_image" id="cover_image" value="{{ old('cover_image', $article->cover_image) }}" class="form-input" required>
                <div class="form-icon">🖼️</div>
            </div>

            <div class="form-group">
                <label for="published_at" class="form-label">Published At</label>
                <input type="datetime-local" name="published_at" id="published_at" value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}" class="form-input">
               
            </div>

            <div class="form-group">
                <label for="content" class="form-label">Content</label>
                <textarea name="content" id="content" class="form-textarea">{{ old('content', $article->content) }}</textarea>
                <div class="form-icon">📄</div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                    <span>←</span>
                    Back to Articles
                </a>
                <button type="submit" class="btn btn-primary">
                    <span>✓</span>
                    Update Article
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Animasi saat form di-focus
    document.querySelectorAll('.form-input, .form-textarea').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-5px)';
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });
    });
</script>
@endsection
