@extends('layouts.app')

@section('title', $story->title . ' - Admin View')

@section('content')
<!-- Admin Story Hero Section -->
<div class="admin-story-hero position-relative overflow-hidden mb-4">
    <div class="admin-hero-bg"></div>
    <div class="admin-hero-overlay"></div>
    <div class="container py-4 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="admin-badge mb-3 fade-in">
                    <span class="admin-view-badge">Admin View</span>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3 admin-title-hero">
                    {{ $story->title }}
                </h1>
                <div class="admin-meta d-flex justify-content-center align-items-center gap-4 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="admin-avatar me-2"></div>
                        <div class="text-start">
                            <span class="d-block text-white-50 small">Author</span>
                            <span class="text-white fw-medium">{{ $story->user ? $story->user->name : 'Guest' }}</span>
                        </div>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="text-start">
                        <span class="d-block text-white-50 small">Created</span>
                        <span class="text-white fw-medium">
                            @if($story->created_at instanceof \Illuminate\Support\Carbon)
                                {{ $story->created_at->format('M j, Y') }}
                            @else
                                {{ \Carbon\Carbon::parse($story->created_at)->format('M j, Y') }}
                            @endif
                        </span>
                    </div>
                    <div class="meta-divider"></div>
                    <div class="text-start">
                        <span class="d-block text-white-50 small">Comments</span>
                        <span class="text-white fw-medium">{{ $story->comments->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-story-container bg-white shadow-sm rounded-4 p-4 p-md-5 mb-4">
                <!-- Admin Controls -->
                <div class="admin-controls mb-4 d-flex justify-content-end gap-2">
                    <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this story?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete Story
                        </button>
                    </form>
                </div>
                
                <!-- Story Content -->
                <div class="admin-story-content">
                    <p class="whitespace-pre-line">{{ $story->content }}</p>
                </div>
                
                <!-- Comments Section -->
                <div class="comments-section mt-5">
                    <h3 class="content-title mb-4">Comments ({{ $story->comments->count() }})</h3>
                    
                    @if($story->comments->count())
                        <div class="comments-list">
                            @foreach($story->comments as $comment)
                                <div class="comment-card fade-in">
                                    <div class="comment-header d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar me-2"></div>
                                            <div>
                                                <div class="comment-author">{{ $comment->user ? $comment->user->name : ($comment->commenter_name ?? 'Anonymous') }}</div>
                                                <div class="comment-date text-muted small">
                                                    @if($comment->created_at instanceof \Illuminate\Support\Carbon)
                                                        {{ $comment->created_at->format('M j, Y H:i') }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($comment->created_at)->format('M j, Y H:i') }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this comment?');" class="action-btn btn-delete btn-sm">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                    <div class="comment-body">
                                        {{ $comment->comment }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-comments text-center py-4">
                            <p class="text-muted">No comments yet.</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Admin Actions -->
            <div class="admin-actions-bar d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.stories.index') }}" class="admin-back-btn">
                    <i class="fas fa-arrow-left me-2"></i>
                    <span>Back to Stories</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* Admin Story Hero Section */
.admin-story-hero {
    min-height: 40vh;
    display: flex;
    align-items: center;
    position: relative;
    margin-top: 0;
    padding-top: 60px;
}

.admin-hero-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-size: cover;
    background-position: center;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    filter: blur(3px);
    transform: scale(1.05);
}

.admin-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(76, 29, 149, 0.6) 0%, rgba(91, 33, 182, 0.7) 100%);
}

.admin-title-hero {
    animation: fadeInUp 0.8s ease-out;
    text-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.admin-view-badge {
    background: linear-gradient(45deg, #4f46e5, #7c3aed);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    display: inline-block;
    animation: fadeInUp 0.6s ease-out;
    box-shadow: 0 0 15px rgba(124, 58, 237, 0.5);
}

.admin-meta {
    animation: fadeInUp 0.9s ease-out;
}

.admin-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(45deg, #4f46e5, #7c3aed);
}

.meta-divider {
    width: 1px;
    height: 30px;
    background-color: rgba(255,255,255,0.2);
}

/* Admin Story Container */
.admin-story-container {
    animation: fadeIn 0.8s ease-out;
    line-height: 1.7;
    border-top: 4px solid #7c3aed;
}

/* Story Content Styling */
.admin-story-content {
    font-size: 1rem;
    line-height: 1.8;
    color: #374151;
    white-space: pre-line;
}

/* Comments Section */
.content-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #4b5563;
    position: relative;
    padding-left: 15px;
}

.content-title::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #7c3aed, #4f46e5);
    border-radius: 4px;
}

.comments-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.comment-card {
    background: #f9fafb;
    border-radius: 12px;
    padding: 1.5rem;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.comment-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    border-color: #d1d5db;
}

.comment-author {
    font-weight: 600;
    color: #4b5563;
}

.comment-body {
    color: #4b5563;
    line-height: 1.7;
}

.user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(45deg, #4f46e5, #7c3aed);
}

/* Admin Actions */
.admin-back-btn {
    color: #6b7280;
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    font-weight: 500;
}

.admin-back-btn:hover {
    color: #7c3aed;
    transform: translateX(-5px);
}

.admin-controls .btn {
    border-radius: 20px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.admin-controls .btn-danger {
    background-color: #ef4444;
    border-color: #ef4444;
}

.admin-controls .btn-danger:hover {
    background-color: #dc2626;
    border-color: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Action Buttons */
.action-btn {
    padding: 6px 12px;
    border: none;
    border-radius: 8px;
    font-size: 0.85rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.btn-delete {
    background: #fed7d7;
    color: #e53e3e;
    border: 1px solid #feb2b2;
}

.btn-delete:hover {
    background: #e53e3e;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(229, 62, 62, 0.2);
}

.btn-sm {
    padding: 4px 8px;
    font-size: 0.75rem;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeInUp {
    from { 
        opacity: 0;
        transform: translateY(20px);
    }
    to { 
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .admin-story-hero {
        min-height: 30vh;
    }
    
    .display-5 {
        font-size: 1.8rem;
    }
    
    .admin-meta {
        flex-direction: column;
        gap: 1rem;
    }
    
    .meta-divider {
        display: none;
    }
    
    .admin-controls {
        flex-direction: column;
        align-items: stretch;
    }
    
    .admin-controls .btn {
        margin-bottom: 0.5rem;
        width: 100%;
    }
    
    .admin-actions-bar {
        flex-direction: column;
        gap: 1rem;
    }
    
    .admin-back-btn {
        width: 100%;
        justify-content: center;
    }
    
    .comment-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .comment-card {
        padding: 1rem;
    }
}
</style>
@endsection
