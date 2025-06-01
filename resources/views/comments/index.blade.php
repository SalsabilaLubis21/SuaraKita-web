<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>All Comments - SuaraKita</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/comments.css') }}" rel="stylesheet" />

</head>
<body>
    <div class="animated-bg">
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
    </div>
    <div class="grid-overlay"></div>
    <div class="container">
        <div class="header">
            <div class="title">All Comments</div>
            <div class="subtitle">All user comments from stories and articles are displayed here. Explore the voices of our community!</div>
        </div>
        <div class="comments-container">
            @if($comments->isEmpty())
                <div class="no-comments">No comments yet.</div>
            @else
                <div class="comments-grid">
                    @foreach($comments as $comment)
                        <div class="comment-card">
                            <div class="comment-header">
                                <div class="comment-author">{{ $comment->anonymous ? 'Anonymous' : ($comment->user ? $comment->user->name : 'Anonymous') }}</div>
                                <div class="comment-date">{{ $comment->created_at ? \Carbon\Carbon::parse($comment->created_at)->format('Y-m-d H:i') : '' }}</div>
                            </div>
                            <div class="comment-content">{{ $comment->comment }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        <div class="navigation">
            <a href="{{ url('/') }}" class="back-link">&larr; Back to Home</a>
        </div>
    </div>
</body>
</html>