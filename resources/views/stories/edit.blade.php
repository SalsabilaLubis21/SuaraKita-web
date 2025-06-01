@extends('layouts.app')

@section('content')
<link href="{{ asset('css/story-edit.css') }}" rel="stylesheet" />

<div class="animated-bg">
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
</div>
<div class="grid-overlay"></div>
<div class="edit-story-hero">
    <div class="edit-story-hero-overlay"></div>
    <div class="edit-story-hero-content">
        <div class="edit-story-hero-title">Edit Your Story</div>
        <div class="edit-story-hero-meta">Update your inspiring story below</div>
    </div>
</div>
<div class="edit-story-container">
    <form action="{{ route('stories.update', $story->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 1.2rem;">
            <label for="title" class="edit-story-label">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $story->title) }}" required maxlength="255" class="edit-story-input">
            @error('title')
                <div style="color: #d32f2f; margin-top: 0.25rem; font-size:0.97rem;">{{ $message }}</div>
            @enderror
        </div>
        <div style="margin-bottom: 1.2rem;">
            <label for="content" class="edit-story-label">Content</label>
            <textarea id="content" name="content" rows="8" required class="edit-story-textarea">{{ old('content', $story->content) }}</textarea>
            @error('content')
                <div style="color: #d32f2f; margin-top: 0.25rem; font-size:0.97rem;">{{ $message }}</div>
            @enderror
        </div>
        <div style="text-align: center;">
            <button type="submit" class="edit-story-btn">Update Story</button>
        </div>
    </form>
</div>
@endsection
