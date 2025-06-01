@extends('layouts.app')

@section('title', $article->title . ' - Admin View')

@section('content')
<!-- Admin Article Hero Section -->
<div class="admin-article-hero position-relative overflow-hidden mb-4">
    <div class="admin-hero-bg" style="background-image: url('{{ $article->cover_image}}');"></div>
    <div class="admin-hero-overlay"></div>
    <div class="container py-4 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="admin-badge mb-3 fade-in">
                    <span class="admin-view-badge">Admin View</span>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3 admin-title-hero">
                    {{ $article->title }}
                </h1>
                <div class="admin-meta d-flex justify-content-center align-items-center gap-4 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="admin-avatar me-2"></div>
                        <div class="text-start">
                            <span class="d-block text-white-50 small">Category</span>
                            <span class="text-white fw-medium">{{ $article->category }}</span>
                        </div>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="text-start">
                        <span class="d-block text-white-50 small">Published</span>
                        <span class="text-white fw-medium">{{ $article->published_at ? $article->published_at->format('M j, Y') : 'Draft' }}</span>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="text-start">
                        <span class="d-block text-white-50 small">Status</span>
                        <span class="text-white fw-medium">{{ $article->published_at ? 'Published' : 'Draft' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-article-container bg-white shadow-sm rounded-4 p-4 p-md-5 mb-4">
                <!-- Admin Controls -->
                <div class="admin-controls mb-4 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i> Edit Article
                    </a>
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete
                        </button>
                    </form>
                </div>
                
                <!-- Article Content -->
                <div class="admin-article-content">
                    @php
                        // Memproses konten menjadi paragraf
                        $content = $article->content;
                        
                        // Memastikan konten memiliki paragraf yang benar
                        // Mengganti baris baru ganda dengan tag paragraf
                        $content = '<p>' . str_replace("\n\n", '</p><p>', $content) . '</p>';
                        
                        // Mengganti baris baru tunggal dengan <br>
                        $content = str_replace("\n", '<br>', $content);
                        
                        // Membersihkan paragraf kosong
                        $content = str_replace('<p></p>', '', $content);
                    @endphp
                    
                    {!! $content !!}
                </div>
            </div>
            
            <!-- Admin Actions -->
            <div class="admin-actions-bar d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.articles.index') }}" class="admin-back-btn">
                    <i class="fas fa-arrow-left me-2"></i>
                    <span>Back to Articles</span>
                </a>
                <a href="{{ route('articles.show', $article->slug) }}" class="admin-view-public-btn" target="_blank">
                    <i class="fas fa-external-link-alt me-1"></i>
                    <span>View Public Page</span>
                </a>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('css/admin-articles-show.css') }}" rel="stylesheet" />

@endsection
