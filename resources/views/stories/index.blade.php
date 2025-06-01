@extends('layouts.app')

@section('content')
<link href="{{ asset('css/stories.css') }}" rel="stylesheet" />

<div class="animated-bg">
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
</div>
<div class="grid-overlay"></div>

<div class="stories-hero">
    <div class="stories-hero-overlay"></div>
    <div class="stories-hero-content animate-fadeIn">
        <h1 class="stories-hero-title">Discover Inspiring Stories</h1>
        <p class="stories-hero-subtitle">Read and share real stories from our amazing community.</p>
        <a href="#" id="share-story-btn" class="share-story-btn animate-fadeInUp">Share Your Story</a>
    </div>
</div>
<div class="stories-container animate-fadeInUp">
    @if($stories->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">📖</div>
            <p>No stories available at the moment. Be the first to <a href='{{ route('stories.create') }}' class='inline-link'>share your story</a>!</p>
        </div>
    @else
        <div class="stories-grid">
            @foreach($stories as $story)
                <div class="story-card">
                    <a href="{{ route('stories.show', $story->id) }}" class="story-link">
                        <div class="story-card-header">
                            <h5 class="story-title">{{ $story->title }}</h5>
                            <span class="story-date">{{ $story->created_at ? \Carbon\Carbon::parse($story->created_at)->format('Y-m-d H:i') : 'Published' }}</span>
                        </div>
                        <p class="story-summary">{{ Str::limit($story->summary ?? $story->content, 120) }}</p>
                        <div class="story-meta">
                            <span class="story-author">By {{ $story->user ? $story->user->name : 'Anonymous' }}</span>
                        </div>
                    </a>
                    <div class="card-footer-modern">
                        <a href="{{ route('stories.show', $story->id) }}" class="btn-view-all" onclick="window.location.href=this.href">
                            Read More
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        @if (method_exists($stories, 'hasMorePages') && $stories->hasMorePages())
            <div class="text-center mt-4">
                <button class="load-more-btn" id="load-more-btn" data-next-page="{{ $stories->nextPageUrl() }}">
                    Load More Stories
                </button>
            </div>
        @endif
    @endif
</div>

<script>
    window.routes = {
        login: "{{ route('login') }}",
        storiesCreate: "{{ route('stories.create') }}"
    };
    window.isLoggedIn = @json(auth()->check());
</script>
<script src="{{ asset('js/stories.js') }}"></script>
@endsection
