@extends('layouts.app')

@section('content')
<link href="{{ asset('css/article-index.css') }}" rel="stylesheet" />
<script src="{{ asset('js/article-index.js') }}"></script>

<div class="animated-bg">
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
    <div class="bg-orb"></div>
</div>

<div class="grid-overlay"></div>

<div class="hero-section position-relative overflow-hidden mb-5">
    <div class="container-fluid py-5 position-relative">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1 class="hero-title">
                    Educational <span>Articles</span>
                </h1>
                <p class="lead text-white fs-4 mb-2 fade-in">
                    Discover insights that shape minds and inspire change
                </p>
                <div class="search-box mx-auto mb-3">
                    <form id="search-form" method="GET" action="{{ route('articles.index') }}">
                        <input type="hidden" name="category" value="{{ request('category', 'all') }}">
                        <div class="input-group glass-input">
                            <input type="text" name="search" class="form-control bg-transparent border-0 text-white"
                                placeholder="Search articles..." style="box-shadow: none; font-size: 1.25rem; height: 3rem;" value="{{ request('search') }}">
                            <button type="submit" class="input-group-text bg-transparent border-0" style="cursor: pointer; color: white;" id="search-icon" aria-label="Search">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    @if ($categories->isNotEmpty())
    <div class="filter-section d-flex justify-content-center flex-wrap gap-3 mb-5">
        <a href="{{ route('articles.index', ['search' => request('search')]) }}"
           class="filter-tag {{ request('category', 'all') == 'all' ? 'active' : '' }}">
            All
        </a>
        @foreach ($categories as $category)
            <a href="{{ route('articles.index', ['category' => $category->slug, 'search' => request('search')]) }}"
               class="filter-tag {{ request('category') == $category->slug ? 'active' : '' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>
    @endif

    <div id="articles-grid" class="articles-grid">
        @forelse ($articles as $article)
            <div class="modern-card" style="animation-delay: {{ $loop->index * 0.1 }}s;">
                <div class="card-image-wrapper">
                    <img src="{{ $article->cover_image ?? asset('images/default-article.jpg') }}" class="card-img-modern" alt="{{ $article->title }}">
                    <div class="image-overlay"></div>
                </div>
                <div class="modern-card-body">
                    <div class="article-meta">
                        <span class="date-badge">{{ $article->published_at->format('M d, Y') }}</span>
                        <div class="author-info">
                            <div class="author-avatar" style="background-image: url('{{ $article->admin && $article->admin->profile_image ? $article->admin->profile_image : asset('images/default-avatar.png') }}');"></div>
                            <span class="author-name">{{ $article->admin ? $article->admin->name : 'Unknown Author' }}</span>
                        </div>
                    </div>
                    <h5 class="article-title">
                        <a href="{{ route('articles.show', $article->slug) }}">
                            {{ $article->title }}
                        </a>
                    </h5>
                    <p class="article-excerpt">
                        {{ Str::limit($article->summary, 150) }}
                    </p>
                </div>
                <div class="card-footer-modern">
                    <a href="{{ route('articles.show', $article->slug) }}" class="read-more-btn" onclick="window.location.href=this.href">
                        Read More <i class="fas fa-arrow-right"></i>
                    </a>
                    <div class="article-actions">
                        @auth
                            <form action="{{ auth()->user()->likes->contains($article->id) ? route('articles.unlike', $article->id) : route('articles.like', $article->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="action-btn" title="Like" type="submit" style="text-decoration: none;">
                                    <i class="{{ auth()->user()->likes->contains($article->id) ? 'fas' : 'far' }} fa-heart"></i>
                                </button>
                            </form>
                            <form action="{{ auth()->user()->bookmarks->contains($article->id) ? route('articles.unbookmark', $article->id) : route('articles.bookmark', $article->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button class="action-btn" title="Bookmark" type="submit">
                                    <i class="{{ auth()->user()->bookmarks->contains($article->id) ? 'fas' : 'far' }} fa-bookmark"></i>
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login', ['redirect_action' => 'like', 'article_id' => $article->id]) }}" class="action-btn" title="Like" style="text-decoration: none;"><i class="far fa-heart"></i></a>
                            <a href="{{ route('login', ['redirect_action' => 'bookmark', 'article_id' => $article->id]) }}" class="action-btn" title="Bookmark"><i class="far fa-bookmark"></i></a>
                        @endauth
                        <button class="action-btn share-btn" title="Share" data-title="{{ $article->title }}" data-url="{{ route('articles.show', $article->slug) }}">
                            <i class="fas fa-share-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="far fa-file-alt fa-4x mb-3 empty-icon"></i>
                <h3>No Articles Found</h3>
                <p>It seems there are no articles matching your criteria. Try adjusting your search or filters.</p>
            </div>
        @endforelse
    </div>

    @if ($articles->hasMorePages())
        <div class="text-center mt-5">
            <button id="load-more-btn" class="load-more-btn" data-next-page="{{ $articles->nextPageUrl() }}">
                Load More Articles
                <span class="btn-spinner"></span>
            </button>
        </div>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality for icon click
        const searchIcon = document.getElementById('search-icon');
        const searchForm = document.getElementById('search-form');
        if (searchIcon && searchForm) {
            searchIcon.style.cursor = 'pointer';
            searchIcon.addEventListener('click', function() {
                searchForm.submit();
            });
        }

        // Share button functionality - Updated with better selector
        const shareButtons = document.querySelectorAll('.share-btn');
        shareButtons.forEach(button => {
            button.addEventListener('click', function() {
                const title = this.getAttribute('data-title');
                const url = this.getAttribute('data-url');

                if (navigator.share) {
                    navigator.share({
                        title: title,
                        url: url
                    }).then(() => {
                        console.log('Shared successfully');
                    }).catch((error) => {
                        console.error('Error sharing:', error);
                    });
                } else {
                    // Fallback: copy URL to clipboard
                    navigator.clipboard.writeText(url).then(() => {
                        alert('Article URL copied to clipboard');
                        console.log('URL copied to clipboard');
                    }).catch(() => {
                        alert('Sharing not supported and failed to copy URL');
                        console.error('Failed to copy URL to clipboard');
                    });
                }
            });
        });

        // Load More functionality
        const loadMoreBtn = document.getElementById('load-more-btn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const nextPageUrl = this.getAttribute('data-next-page');
                if (!nextPageUrl) return;

                this.disabled = true;
                this.querySelector('.btn-spinner').style.display = 'inline-block';

                fetch(nextPageUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newArticles = doc.querySelectorAll('#articles-grid > div');
                    const articlesGrid = document.getElementById('articles-grid');

                    newArticles.forEach(article => {
                        articlesGrid.appendChild(article);
                        // Re-attach share button event listeners for new articles
                        const shareBtn = article.querySelector('.share-btn');
                        if (shareBtn) {
                            shareBtn.addEventListener('click', function() {
                                const title = this.getAttribute('data-title');
                                const url = this.getAttribute('data-url');

                                if (navigator.share) {
                                    navigator.share({
                                        title: title,
                                        url: url
                                    }).then(() => {
                                        console.log('Shared successfully');
                                    }).catch((error) => {
                                        console.error('Error sharing:', error);
                                    });
                                } else {
                                    navigator.clipboard.writeText(url).then(() => {
                                        alert('Article URL copied to clipboard');
                                    }).catch(() => {
                                        alert('Sharing not supported and failed to copy URL');
                                    });
                                }
                            });
                        }
                    });
                    
                    // Update button for next page
                    const nextButton = doc.querySelector('#load-more-btn');
                    if (nextButton) {
                        this.setAttribute('data-next-page', nextButton.getAttribute('data-next-page'));
                    } else {
                        this.style.display = 'none';
                    }
                    
                    this.disabled = false;
                    this.querySelector('.btn-spinner').style.display = 'none';
                })
                .catch(() => {
                    this.disabled = false;
                    this.querySelector('.btn-spinner').style.display = 'none';
                });
            });
        }
    });
</script>

@endsection