@extends('layouts.app')

@section('content')
<link href="{{ asset('css/story-show.css') }}" rel="stylesheet" />

<div class="animated-bg">
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
</div>
<div class="grid-overlay"></div>

<div class="story-hero">
    <div class="story-hero-overlay"></div>
    <div class="story-hero-content">
        <div class="story-hero-title">{{ $story->title }}</div>
        <div class="story-hero-meta d-flex flex-row justify-content-center align-items-center gap-3" style="font-size: 1.1rem; color: #e0e0e0;">
            <div class="d-flex flex-row align-items-center gap-2">
                <span>By</span>
                <strong>{{ $story->user ? $story->user->name : 'Anonymous' }}</strong>
            </div>
            <div class="meta-divider"></div>
            <div class="d-flex flex-row align-items-center gap-2">
                <span>Published</span>
                <strong>{{ $story->created_at ? \Carbon\Carbon::parse($story->created_at)->format('M d, Y') : 'Published' }}</strong>
            </div>
            <div class="meta-divider"></div>
            <div class="d-flex flex-row align-items-center gap-2">
                <span>Reading Time</span>
                <strong>1 min read</strong>
            </div>
        </div>
    </div>
</div>

<div class="story-container">
    <div class="story-content">
        {!! nl2br(e($story->content)) !!}
    </div>

    <section id="comments">
        <div class="comments-title">Comments ({{ $story->comments->count() }})</div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($story->comments->isEmpty())
            <p>No comments yet. Be the first to comment!</p>
        @else
            <ul class="list-group mb-4">
                @foreach($story->comments as $comment)
                    <li class="list-group-item">
                        <div class="comment-meta">
                            <strong>{{ $comment->anonymous ? 'Anonymous' : ($comment->user ? $comment->user->name : 'Anonymous') }}</strong>
                            <span> - {{ $comment->created_at ? \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d H:i') : '' }}</span>
                        </div>
                        <div class="comment-text">{{ $comment->comment }}</div>
                    </li>
                @endforeach
            </ul>
        @endif

        <div class="mb-3 mt-4">
            <h4 style="color:#7f53ac;font-weight:600;">Add a Comment</h4>
            @guest
                <p>You can <a href="{{ route('login') }}" style="color:#7f53ac;text-decoration:none;border-bottom:1px dotted #7f53ac;">login</a> to comment or continue as anonymous below.</p>
            @endguest

            <form method="POST" action="{{ route('comments.store', $story->id) }}">
                @csrf
                <div class="mb-3">
                    <label for="comment" class="form-label">Your Comment</label>
                    <textarea id="comment" name="comment" class="form-control @error('comment') is-invalid @enderror" rows="4" required>{{ old('comment') }}</textarea>
                    @error('comment')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary">Submit Comment</button>
            </form>
        </div>
    </section>
</div>
@endsection
