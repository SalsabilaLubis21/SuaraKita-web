@extends('layouts.app')

@section('title', 'Manage Stories - Admin')

@section('content')
<!-- Admin Stories Hero Section -->
<div class="admin-stories-hero position-relative overflow-hidden mb-4">
    <div class="admin-hero-overlay"></div>
    <div class="container py-4 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="admin-badge mb-3 fade-in">
                    <span class="admin-view-badge">Admin Panel</span>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3 admin-title-hero">
                    Manage Stories
                </h1>
                <p class="text-white-50 mb-0 subtitle-hero">
                    Review and manage user stories across your platform
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-stories-container bg-white shadow-sm rounded-4 p-4 p-md-5 mb-4">
                <!-- Admin Controls -->
                <div class="admin-controls mb-4 d-flex justify-content-between align-items-center">
                    <h2 class="section-title mb-0">All Stories</h2>
                    <a href="{{ route('admin.dashboard') }}" class="admin-back-btn">
                        <i class="fas fa-arrow-left me-2"></i>
                        <span>Back to Dashboard</span>
                    </a>
                </div>
                
                @if($stories->count())
                <div class="table-responsive">
                    <table class="table table-hover stories-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>User</th>
                                <th>Comments</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stories as $story)
                            <tr class="story-row fade-in">
                                <td>{{ $story->id }}</td>
                                <td class="story-title">{{ $story->title }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2"></div>
                                        <span>{{ $story->user ? $story->user->name : 'Guest' }}</span>
                                    </div>
                                </td>
                                <td><span class="comment-count">{{ $story->comments->count() }}</span></td>
                                <td>
                                    @if($story->created_at instanceof \Illuminate\Support\Carbon)
                                        {{ $story->created_at->format('M j, Y H:i') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($story->created_at)->format('M j, Y H:i') }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.stories.show', $story->id) }}" class="action-btn btn-view">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        <form action="{{ route('admin.stories.destroy', $story->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this story?');" class="action-btn btn-delete">
                                                <i class="fas fa-trash-alt"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 pagination-container">
                    {{ $stories->links() }}
                </div>
                @else
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-3">📚</div>
                    <h3>No Stories Found</h3>
                    <p class="text-muted">There are no stories to manage at this time.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
/* Admin Stories Hero Section */
.admin-stories-hero {
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

/* Admin Stories Container */
.admin-stories-container {
    animation: fadeIn 0.8s ease-out;
    line-height: 1.7;
    border-top: 4px solid #7c3aed;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #4a5568;
    position: relative;
    padding-left: 15px;
}

.section-title::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 4px;
    background: linear-gradient(to bottom, #7c3aed, #4f46e5);
    border-radius: 4px;
}

/* Stories Table Styling */
.stories-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}

.stories-table th {
    background-color: #f9fafb;
    color: #4b5563;
    font-weight: 600;
    padding: 12px 16px;
    text-align: left;
    border-bottom: 2px solid #e5e7eb;
}

.stories-table td {
    padding: 12px 16px;
    border-bottom: 1px solid #e5e7eb;
    vertical-align: middle;
}

.story-row {
    transition: all 0.3s ease;
}

.story-row:hover {
    background-color: #f9fafb;
}

.user-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(45deg, #4f46e5, #7c3aed);
}

.story-title {
    font-weight: 500;
    max-width: 250px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.comment-count {
    display: inline-block;
    background: rgba(124, 58, 237, 0.1);
    color: #7c3aed;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.85rem;
    font-weight: 500;
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

.btn-view {
    background: #e6fffa;
    color: #319795;
    border: 1px solid #b2f5ea;
}

.btn-view:hover {
    background: #319795;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(49, 151, 149, 0.2);
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

/* Admin Back Button */
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

/* Empty State */
.empty-state {
    animation: fadeIn 1s ease-out;
}

.empty-icon {
    font-size: 3rem;
    opacity: 0.5;
}

/* Pagination */
.pagination-container {
    display: flex;
    justify-content: center;
}

.pagination-container nav div:first-child {
    display: none;
}

.pagination-container .pagination {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
    gap: 5px;
}

.pagination-container .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #f9fafb;
    color: #4b5563;
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination-container .page-item.active .page-link {
    background: #7c3aed;
    color: white;
}

.pagination-container .page-item .page-link:hover {
    background: #e9d5ff;
    color: #6d28d9;
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
    .admin-stories-hero {
        min-height: 25vh;
    }
    
    .display-5 {
        font-size: 1.8rem;
    }
    
    .admin-controls {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .story-title {
        max-width: 150px;
    }
    
    .stories-table {
        display: block;
        overflow-x: auto;
    }
    
    .action-btn {
        padding: 4px 8px;
        font-size: 0.8rem;
    }
}
</style>
@endsection
