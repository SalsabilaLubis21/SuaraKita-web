@extends('layouts.app')

@section('content')
<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
<script src="{{ asset('js/dashboard.js') }}"></script>

    <div class="dashboard-container">
        <div class="bg-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>

        <div class="dashboard-content">
            <!-- Welcome Section -->
            <div class="welcome-card">
                <h1 class="welcome-title">User Dashboard</h1>
                <p class="welcome-subtitle">Welcome back, <span class="user-name">{{ auth()->user()->name }}</span>! Here's your activity overview</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $stories->count() }}</div>
                    <div class="stat-label">Stories Created</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ auth()->user()->bookmarks->count() }}</div>
                    <div class="stat-label">Bookmarked Articles</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ auth()->user()->likes->count() }}</div>
                    <div class="stat-label">Liked Articles</div>
                </div>
            </div>

            <!-- Stories Section -->
            <div class="section-card d-flex flex-column gap-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="section-title d-flex align-items-center gap-2">
                        <div class="section-icon">📚</div>
                        Your Stories
                    </h2>
                    <a href="{{ route('stories.create') }}" class="btn-modern btn-submit" style="height: fit-content; padding: 0.5rem 1rem;">
                        + Add New Story
                    </a>
                </div>
                <div>
                    @if($stories->isEmpty())
                        <div class="empty-state">
                            <p>You haven't created any stories yet. Start sharing your educational insights!</p>
                        </div>
                    @else
                        @foreach($stories as $story)
                            <div class="story-item">
                                <h3 class="story-title">{{ $story->title }}</h3>
                                <div class="story-actions">
                                    <a href="{{ route('stories.edit', $story->id) }}" class="btn-modern btn-edit">
                                        ✏️ Edit
                                    </a>
                                    <form action="{{ route('stories.destroy', $story->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-modern btn-delete" onclick="return confirm('Are you sure you want to delete this story?')">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Bookmarks and Likes Grid -->
            <div class="row">
                <div class="col-md-6">
                    <div class="section-card">
                        <h2 class="section-title">
                            <div class="section-icon">🔖</div>
                            Bookmarked Articles
                        </h2>
                        
                        @if(auth()->user()->bookmarks->isEmpty())
                            <div class="empty-state">
                                <p>No bookmarked articles yet. Start exploring and bookmark interesting content!</p>
                            </div>
                        @else
                            @foreach(auth()->user()->bookmarks as $article)
                                <div class="list-item">
                                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="section-card">
                        <h2 class="section-title">
                            <div class="section-icon">❤️</div>
                            Liked Articles
                        </h2>
                        
                        @if(auth()->user()->likes->isEmpty())
                            <div class="empty-state">
                                <p>No liked articles yet. Show appreciation for content you enjoy!</p>
                            </div>
                        @else
                            @foreach(auth()->user()->likes as $article)
                                <div class="list-item">
                                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
    </div>
</div>


@endsection
