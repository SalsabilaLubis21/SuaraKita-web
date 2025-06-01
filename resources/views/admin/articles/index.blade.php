<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Article Management</title>
  <link href="{{ asset('css/admin-articles-index.css') }}" rel="stylesheet" />

</head>
<body>
    <div class="main-container">
        <div class="header">
            <h1>Article Management</h1>
            <p class="subtitle">Complete control center for managing your educational content</p>
        </div>

        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number">5</div>
                <div class="stat-label">Total Articles</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">3</div>
                <div class="stat-label">Published</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">2</div>
                <div class="stat-label">Draft</div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                <span>➕</span>
                Create New Article
            </a>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
        <span>🏠</span>
        Go to Dashboard
    </a>
        </div>

        <div class="table-header">
    <h2 class="table-title">Your Articles</h2>
    <form action="{{ route('admin.articles.index') }}" method="GET" class="search-form">
        <div class="search-box">
            <input type="text" name="search" placeholder="Search articles..." value="{{ request('search') }}">
        </div>
    </form>
</div>

            <div class="articles-grid">
                @foreach ($articles as $article)
                <div class="article-card">
                    <h3 class="article-title">{{ $article->title }}</h3>
                    <span class="article-category">{{ $article->category }}</span>
                    <div class="article-actions">
                        <a href="{{ route('admin.articles.show', $article->id) }}" class="action-btn btn-view">👁️ View</a>
                        <a href="{{ route('admin.articles.edit', $article->id) }}" class="action-btn btn-edit">✏️ Edit</a>
                        <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn-delete">🗑️ Delete</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    
</body>
</html>