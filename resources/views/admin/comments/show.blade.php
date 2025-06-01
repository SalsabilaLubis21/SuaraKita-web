@extends('layouts.app')

@section('title', 'Comment Details - Admin')

@section('content')
<!-- Admin Comment Hero Section -->
<div class="admin-comment-hero position-relative overflow-hidden mb-4">
    <div class="admin-hero-overlay"></div>
    <div class="container py-4 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="admin-badge mb-3 fade-in">
                    <span class="admin-view-badge">Admin View</span>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3 admin-title-hero">
                    Comment Details
                </h1>
                <p class="text-white-50 mb-0 subtitle-hero">
                    Reviewing individual comment information
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-comment-container bg-white shadow-sm rounded-4 p-4 p-md-5 mb-4">
                <!-- Comment Information -->
                <div class="comment-info-grid">
                    <div class="comment-info-card">
                        <div class="info-label">Story</div>
                        <div class="info-value">{{ $comment->story ? $comment->story->title : 'N/A' }}</div>
                    </div>
                    
                    <div class="comment-info-card">
                        <div class="info-label">User</div>
                        <div class="info-value d-flex align-items-center">
                            <div class="user-avatar me-2"></div>
                            <span>{{ $comment->user ? $comment->user->name : ($comment->commenter_name ?? 'Anonymous') }}</span>
                        </div>
                    </div>
                    
                    <div class="comment-info-card">
                        <div class="info-label">Created At</div>
                        <div class="info-value">
                            @if($comment->created_at instanceof \Illuminate\Support\Carbon)
                                {{ $comment->created_at->format('M j, Y H:i') }}
                            @else
                                {{ \Carbon\Carbon::parse($comment->created_at)->format('M j, Y H:i') }}
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Comment Content -->
                <div class="comment-content-section mt-4">
                    <h3 class="content-title">Comment Content</h3>
                    <div class="comment-content p-4 rounded-3 whitespace-pre-line">
                        {{ $comment->comment }}
                    </div>
                </div>
                
                <!-- Admin Controls -->
                <div class="admin-controls mt-5 d-flex justify-content-end gap-2">
                    <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this comment?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-1"></i> Delete Comment
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Admin Actions -->
            <div class="admin-actions-bar d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('admin.comments.index') }}" class="admin-back-btn">
                    <i class="fas fa-arrow-left me-2"></i>
                    <span>Back to Comments</span>
                </a>
                @if($comment->story)
                <a href="{{ route('stories.show', $comment->story->id) }}" class="admin-view-public-btn" target="_blank">
                    <i class="fas fa-external-link-alt me-1"></i>
                    <span>View Story</span>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Admin Comment Hero Section */
.admin-comment-hero {
    min-height: 30vh;
    display: flex;
    align-items: center;
    position: relative;
    margin-top: 0;
    padding-top: 60px;
}

.admin-hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(76, 29, 149, 0.8) 0%, rgba(91, 33, 182, 0.9) 100%);
}

.admin-title-hero {
    animation: fadeInUp 0.8s ease-out;
    text-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.subtitle-hero {
    animation: fadeInUp 1s ease-out;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
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

/* Admin Comment Container */
.admin-comment-container {
    animation: fadeIn 0.8s ease-out;
    line-height: 1.7;
    border-top: 4px solid #7c3aed;
}

/* Comment Info Grid */
.comment-info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.comment-info-card {
    padding: 1.5rem;
    background: #f9fafb;
    border-radius: 12px;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.comment-info-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-color: #d1d5db;
}

.info-label {
    font-size: 0.9rem;
    color: #6b7280;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.info-value {
    font-size: 1.1rem;
    color: #1f2937;
    font-weight: 600;
}

.user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(45deg, #4f46e5, #7c3aed);
}

/* Comment Content Section */
.content-title {
    font-size: 1.3rem;
    font-weight: 600;
    color: #4b5563;
    margin-bottom: 1rem;
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

.comment-content {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    font-size: 1rem;
    line-height: 1.7;
    color: #4b5563;
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

.admin-view-public-btn {
    color: #6b7280;
    text-decoration: none;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    font-weight: 500;
    padding: 8px 16px;
    border-radius: 20px;
    background-color: rgba(124, 58, 237, 0.1);
}

.admin-view-public-btn:hover {
    color: white;
    background-color: #7c3aed;
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
    .admin-comment-hero {
        min-height: 25vh;
    }
    
    .display-5 {
        font-size: 1.8rem;
    }
    
    .comment-info-grid {
        grid-template-columns: 1fr;
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
    
    .admin-back-btn, .admin-view-public-btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
