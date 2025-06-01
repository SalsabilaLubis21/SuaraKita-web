@extends('layouts.app')

@section('content')
<link href="{{ asset('css/story-create.css') }}" rel="stylesheet" />

<div class="animated-bg">
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
</div>
<div class="grid-overlay"></div>
<div class="create-story-hero">
    <div class="create-story-hero-overlay"></div>
    <div class="create-story-hero-content">
        <div class="create-story-hero-title">Share Your Inspiring Story</div>
        <div class="create-story-hero-meta">Let your voice be heard and inspire others!</div>
    </div>
</div>
<div class="create-story-container">
<form method="POST" action="{{ route('stories.store') }}">
        @csrf
        <div style="margin-bottom: 1.2rem;">
            <label for="title" class="create-story-label">Title</label>
            <input type="text" id="title" name="title" required maxlength="255" class="create-story-input" value="{{ old('title') }}">
            @error('title')
                <div style="color: #d32f2f; margin-top: 0.25rem; font-size:0.97rem;">{{ $message }}</div>
            @enderror
        </div>
        <div style="margin-bottom: 1.2rem;">
            <label for="content" class="create-story-label">Content</label>
            <textarea id="content" name="content" required rows="8" class="create-story-textarea">{{ old('content') }}</textarea>
            @error('content')
                <div style="color: #d32f2f; margin-top: 0.25rem; font-size:0.97rem;">{{ $message }}</div>
            @enderror
        </div>
        <div style="text-align: center;">
            <button type="submit" class="create-story-btn">Submit Story</button>
        </div>
    </form>
</div>
@endsection
