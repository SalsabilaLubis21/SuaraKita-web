@extends('layouts.app')

@section('content')

<link href="{{ asset('css/admin-dashboard.css') }}" rel="stylesheet" />


<div class="admin-dashboard">
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="dashboard-content">
        <!-- Welcome Section -->
        <div class="welcome-section">
            <div class="crown-icon">👑</div>
            <h1 class="admin-title">Admin Dashboard</h1>
            <p class="admin-subtitle">Complete control center for managing your educational platform</p>
        </div>

        <!-- Statistics Overview -->
        <div class="stats-overview">
            <div class="stat-card">
                <div class="stat-number">{{ $totalArticles }}</div>
                <div class="stat-label">Total Articles</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $publishedStories }}</div>
                <div class="stat-label">Published Stories</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $userComments }}</div>
                <div class="stat-label">User Comments</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $activeUsers }}</div>
                <div class="stat-label">Active Users</div>
            </div>
        </div>

        <!-- Management Cards -->
        <div class="management-grid">
            <div class="management-card">
                <div class="card-icon articles-icon">📰</div>
                <h3 class="card-title">Article Management</h3>
                <p class="card-description">Create, edit, and publish educational articles. Manage content categories and featured posts.</p>
                <a href="{{ route('admin.articles.index') }}" class="action-button btn-articles">
                    <span>📝</span>
                    Manage Articles
                </a>
            </div>

            <div class="management-card">
                <div class="card-icon stories-icon">📚</div>
                <h3 class="card-title">Story Management</h3>
                <p class="card-description">Review user-submitted stories, moderate content, and feature inspiring educational journeys.</p>
                <a href="{{ route('admin.stories.index') }}" class="action-button btn-stories">
                    <span>📖</span>
                    Manage Stories
                </a>
            </div>

            <div class="management-card">
                <div class="card-icon comments-icon">💬</div>
                <h3 class="card-title">Comment Moderation</h3>
                <p class="card-description">Monitor user discussions, moderate comments, and maintain a positive community environment.</p>
                <a href="{{ route('admin.comments.index') }}" class="action-button btn-comments">
                    <span>🛡️</span>
                    Moderate Comments
                </a>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3 class="quick-actions-title">Quick Actions</h3>
            <div class="quick-action-buttons">
                <a href="{{ route('admin.articles.create') }}" class="quick-btn">➕ Add New Article</a>
                <a href="{{ route('admin.users.index') }}" class="quick-btn">👥 User Management</a>
                <a href="{{ route('admin.analytics.index') }}" class="quick-btn">📊 Analytics</a>
                <a href="{{ route('admin.settings.index') }}" class="quick-btn">⚙️ Settings</a>
            </div>
        </div>
    </div>
</div>


<script>
    // Add intersection observer for scroll animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.management-card, .stat-card').forEach(card => {
        observer.observe(card);
    });

    // Add click effects to buttons
    document.querySelectorAll('.action-button, .quick-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // Create ripple effect
            const ripple = document.createElement('span');
            const rect = this.getBoundingClientRect();
            const size = Math.max(rect.width, rect.height);
            const x = e.clientX - rect.left - size / 2;
            const y = e.clientY - rect.top - size / 2;
            
            ripple.style.cssText = `
                position: absolute;
                width: ${size}px;
                height: ${size}px;
                left: ${x}px;
                top: ${y}px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 50%;
                transform: scale(0);
                animation: ripple 0.6s linear;
                pointer-events: none;
            `;
            
            this.style.position = 'relative';
            this.style.overflow = 'hidden';
            this.appendChild(ripple);
            
            setTimeout(() => ripple.remove(), 600);
        });
    });

    // Add dynamic stat counter animation
    function animateCounter(element, target, duration = 2000) {
        let start = 0;
        const increment = target / (duration / 16);
        
        const timer = setInterval(() => {
            start += increment;
            if (start >= target) {
                element.textContent = target;
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(start);
            }
        }, 16);
    }

    // Animate counters when they come into view
    const statObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const number = entry.target.querySelector('.stat-number');
                const target = parseInt(number.textContent);
                number.textContent = '0';
                setTimeout(() => animateCounter(number, target), 300);
                statObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stat-card').forEach(card => {
        statObserver.observe(card);
    });

    // CSS for ripple animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes ripple {
            to {
                transform: scale(2);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection