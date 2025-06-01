@extends('layouts.app')

@section('title', $article->title)

<link href="{{ asset('css/article-show.css') }}" rel="stylesheet" />
<script src="{{ asset('js/article-show.js') }}"></script>


@section('content')
@php
    $categoryMap = [
        'climate change' => 'Climate Change',
        'kesehatan mental' => 'Mental Health',
        'lingkungan' => 'Environment',
        'kesetaraan gender' => 'Gender Equality',
    ];

    $displayCategory = $categoryMap[strtolower($article->category ?? '')] ?? ($article->category ?? 'Educational');
@endphp
<!-- Hero Section with Article Cover Image -->
<div class="article-hero position-relative overflow-hidden mb-5">
    <div class="article-hero-bg" style="background-image: url('{{ $article->cover_image }}');"></div>
    <div class="article-hero-overlay"></div>
    <div class="container-fluid py-5 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="article-category mb-3 fade-in">
                    <span class="category-badge">{{ $displayCategory }}</span>
                </div>
                <h1 class="display-4 fw-bold text-white mb-4 article-title-hero">
                    {{ $article->title }}
                </h1>
                <div class="article-meta-hero d-flex justify-content-center align-items-center gap-4 mb-4">
                    <div class="d-flex align-items-center">
                        <div class="author-avatar-lg me-2"></div>
                        <div class="text-start">
                            <span class="d-block text-white-50 small">Author</span>
                            <span class="text-white fw-medium">{{ $article->admin ? $article->admin->name : ($article->user ? $article->user->name : 'Admin') }}</span>
                        </div>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="text-start">
                        <span class="d-block text-white-50 small">Published</span>
                        <span class="text-white fw-medium">{{ $article->published_at->format('M j, Y') }}</span>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="text-start">
                <span class="d-block text-white-50 small">Reading Time</span>
                <span class="text-white fw-medium">
                    @php
                        $text = strip_tags($article->content);
                        preg_match_all('/\w+/', $text, $matches);
                        $wordCount = count($matches[0]);
                        $readingTime = ceil($wordCount / 200);
                    @endphp
                    @php
                        // Set minimum reading time to 1 minute
                        if ($readingTime < 1) {
                            $readingTime = 1;
                        }
                    @endphp
                    {{ $readingTime }} min read
                </span>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="article-container bg-white shadow-sm rounded-4 p-4 p-md-5 mb-5">
                <!-- Article Summary -->
                <div class="article-summary mb-5">
                    <p class="lead fw-medium">{{ $article->summary }}</p>
                </div>
                
                <!-- Article Content -->
                <div class="article-content">
                    @php
                        // Memproses konten menjadi paragraf
                        $content = $article->content;
                        
                        // Memastikan konten memiliki paragraf yang benar
                        // Mengganti baris baru tunggal dengan tag paragraf
                        $content = '<p>' . str_replace("\n\n", '</p><p>', $content) . '</p>';
                        
                        // Mengganti baris baru tunggal dengan <br>
                        $content = str_replace("\n", '<br>', $content);
                        
                        // Membersihkan paragraf kosong
                        $content = str_replace('<p></p>', '', $content);
                    @endphp
                    
                    {!! $content !!}
                </div>
                
                <!-- Article Tags -->
                <div class="article-tags mt-5 pt-4 border-top">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('articles.index', ['category' => $article->category]) }}" class="tag-pill">
                            {{ $displayCategory }}
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Article Actions -->
            <div class="article-actions-bar d-flex justify-content-between align-items-center mb-5">
                <div class="d-flex gap-3">
                    @auth
                        <form action="{{ auth()->user()->likes->contains($article->id) ? route('articles.unlike', $article->id) : route('articles.like', $article->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="action-btn-lg" title="Like" type="submit">
                                <i class="{{ auth()->user()->likes->contains($article->id) ? 'fas' : 'far' }} fa-heart"></i>
                                <span>{{ auth()->user()->likes->contains($article->id) ? 'Unlike' : 'Like' }}</span>
                            </button>
                        </form>
                        <form action="{{ auth()->user()->bookmarks->contains($article->id) ? route('articles.unbookmark', $article->id) : route('articles.bookmark', $article->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="action-btn-lg" title="Bookmark" type="submit">
                                <i class="{{ auth()->user()->bookmarks->contains($article->id) ? 'fas' : 'far' }} fa-bookmark"></i>
                                <span>{{ auth()->user()->bookmarks->contains($article->id) ? 'Unbookmark' : 'Bookmark' }}</span>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login', ['redirect_action' => 'like', 'article_id' => $article->id]) }}" class="action-btn-lg"><i class="far fa-heart"></i> <span>Like</span></a>
                        <a href="{{ route('login', ['redirect_action' => 'bookmark', 'article_id' => $article->id]) }}" class="action-btn-lg"><i class="far fa-bookmark"></i> <span>Bookmark</span></a>
                    @endauth
                    <button class="action-btn-lg" title="Share">
                        <i class="fas fa-share-alt"></i>
                        <span>Share</span>
                    </button>
                </div>
                <a href="{{ route('articles.index') }}" class="back-btn">
                    <i class="fas fa-arrow-left me-2"></i>
                    <span>Back to Articles</span>
                </a>
            </div>
            
            <!-- Related Articles -->
            <div class="related-articles mt-5">
                <h3 class="section-title mb-4">Related Articles</h3>
                <div class="row g-4">
                    @php
                        $relatedArticles = \App\Models\Article::where('category', $article->category)
                            ->where('id', '!=', $article->id)
                            ->whereNotNull('published_at')
                            ->orderBy('published_at', 'desc')
                            ->take(4)
                            ->get();
                    @endphp
                    
                    @forelse($relatedArticles as $relatedArticle)
                        @php
                            $relatedDisplayCategory = $categoryMap[strtolower($relatedArticle->category ?? '')] ?? ($relatedArticle->category ?? 'Educational');
                        @endphp
                        <div class="col-md-6 col-lg-4 col-xl-3"> <!-- Mengubah grid layout -->
                            <div class="related-card h-100">
                                <div class="related-img-wrapper">
                                    <img src="{{ $relatedArticle->cover_image }}" alt="{{ $relatedArticle->title }}" class="related-img">
                                    <div class="related-category">
                                        <span>{{ $relatedDisplayCategory }}</span>
                                    </div>
                                </div>
                                <div class="related-body p-3">
                                    <h5 class="related-title">
                                        <a href="{{ route('articles.show', $relatedArticle->slug) }}">{{ $relatedArticle->title }}</a>
                                    </h5>
                                    <p class="related-excerpt mb-2">{{ Str::limit($relatedArticle->summary, 60) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="small text-muted">{{ $relatedArticle->published_at->format('M j, Y') }}</div>
                                        <div class="related-read-time small">
                                            <i class="fas fa-clock me-1"></i>
                                            {{ ceil(str_word_count($relatedArticle->content) / 200) }} min
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center text-muted py-4">
                                <p>No related articles found.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>


