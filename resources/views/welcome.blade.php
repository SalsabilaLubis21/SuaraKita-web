<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Social Awareness Campaign</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet" />

</head>
<body>
    <div class="animated-bg">
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
    </div>
    
    <div class="grid-overlay"></div>
    
    <header>
        @php
            use Carbon\Carbon;
        @endphp
        @if($featuredArticle)
        <div class="article-banner">
            <img src="{{ $featuredArticle->cover_image }}" alt="{{ $featuredArticle->title }}" />
            <div class="hero-content">
                <h1 class="hero-title">PERUBAHAN<br>IKLIM</h1>
                <p class="hero-caption">Mari bersama-sama menjaga bumi kita untuk generasi mendatang</p>
              
                <a href="{{ route('articles.show', $featuredArticle->slug) }}" class="btn-view-all">
                    Read Article
                </a>
            </div>
        </div>
        @endif

    <main>
        <section>
            <div class="section-header">
                <h2 class="section-title">Educational Articles</h2>
                <a href="{{ route('articles.index') }}" class="btn-view-all">View All</a>
            </div>
            
            <div class="articles-grid">
                @forelse($articles as $article)
                <div class="educational-article-card">
                    <img src="{{ $article->cover_image ?? 'https://via.placeholder.com/350x220.png?text=Article+Image' }}"
                         alt="{{ $article->title ?? 'Article Title' }}"
                         class="educational-article-image" />
                    <div class="educational-article-content">
                        <h3 class="educational-article-title">{{ $article->title ?? 'Article Title Not Available' }}</h3>
                        <p class="educational-article-date">
                            📅 {{ isset($article->published_at) ? Carbon::parse($article->published_at)->format('F d, Y') : 'May 22, 2025' }}
                        </p>
                        <p class="educational-article-excerpt">
                            {{ isset($article->content) ? \Illuminate\Support\Str::limit(strip_tags($article->content), 120) : 'Content not available for this article.' }}
                        </p>
                    </div>
                </div>
                @empty
                    <div class="educational-article-card">
                        <img src="https://images.unsplash.com/photo-1569163139394-de4e4f43e4e5?w=350&h=220&fit=crop"
                             alt="Climate Crisis"
                             class="educational-article-image" />
                        <div class="educational-article-content">
                            <h3 class="educational-article-title">The Climate Crisis Explained</h3>
                            <p class="educational-article-date">📅 April 22, 2024</p>
                            <p class="educational-article-excerpt">Understanding the long-term shifts in global climate patterns and the urgent need for action to address greenhouse gas emissions and environmental challenges.</p>
                        </div>
                    </div>
                    
                    <div class="educational-article-card">
                        <img src="https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=350&h=220&fit=crop"
                             alt="Mental Health"
                             class="educational-article-image" />
                        <div class="educational-article-content">
                            <h3 class="educational-article-title">Understanding Mental Health</h3>
                            <p class="educational-article-date">📅 April 22, 2024</p>
                            <p class="educational-article-excerpt">Demystifying mental health challenges and promoting acceptance, understanding, and support for those facing psychological difficulties.</p>
                        </div>
                    </div>
                    
                    <div class="educational-article-card">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616c96639db?w=350&h=220&fit=crop&crop=face"
                             alt="Gender Equality"
                             class="educational-article-image" />
                        <div class="educational-article-content">
                            <h3 class="educational-article-title">Gender Equality in the Workplace</h3>
                            <p class="educational-article-date">📅 May 22, 2025</p>
                            <p class="educational-article-excerpt">Gender equality in the workplace is a fundamental right that must be guaranteed. However, challenges persist in achieving true equality.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </section>

        <section>
            <div class="section-header">
                <h2 class="section-title">User Stories</h2>
                <a href="{{ route('stories.index') }}" class="btn-view-all">View All</a>
            </div>
            <p class="section-intro">Share your story to raise awareness and support others in our community</p>
            
            <div class="stories-grid">
                @forelse($stories as $story)
                <div class="story-card">
                    <h3 class="story-title">{{ $story->title ?? 'Story Title Not Available' }}</h3>
                    <p class="story-meta">
                        👤 {{ $story->user ? $story->user->name : 'Anonymous' }} - {{ isset($story->created_at) ? Carbon::parse($story->created_at)->format('F d') : 'Unknown Date' }}
                    </p>
                    <p class="story-excerpt">
                        {{ isset($story->content) ? \Illuminate\Support\Str::limit(strip_tags($story->content), 150) : 'Story content not available.' }}
                    </p>
                    <a href="{{ route('stories.show', $story->id) }}" class="story-readmore">Read More</a>
                </div>
                @empty
                    <div class="story-card">
                        <h3 class="story-title">My Climate Journey</h3>
                        <p class="story-meta">👤 Sarah Johnson - May 15</p>
                        <p class="story-excerpt">Learning about sustainable living changed my perspective completely. Now I'm passionate about reducing waste and helping others understand how small changes can make a big difference for our planet's future.</p>
                        <a href="#" class="story-readmore">Read More</a>
                    </div>
                    
                    <div class="story-card">
                        <h3 class="story-title">Finding Support</h3>
                        <p class="story-meta">👤 Michael Chen - May 18</p>
                        <p class="story-excerpt">When I first struggled with mental health, I felt alone and isolated. This community showed me I wasn't the only one facing these challenges and provided the support I desperately needed.</p>
                        <a href="#" class="story-readmore">Read More</a>
                    </div>
                    
                    <div class="story-card">
                        <h3 class="story-title">Breaking Barriers</h3>
                        <p class="story-meta">👤 Priya Sharma - May 20</p>
                        <p class="story-excerpt">As a woman in tech, I faced many challenges and barriers. Sharing my story helps other women know they can succeed too and that perseverance pays off in the end.</p>
                        <a href="#" class="story-readmore">Read More</a>
                    </div>
                @endforelse
            </div>
        </section>

        <section>
            <div class="section-header">
                <h2 class="section-title">Comments</h2>
                <a href="{{ route('comments.index') }}" class="btn-view-all">View All</a>
            </div>
            
            <div class="comments-container">
                @php
                    $comments = \App\Models\Comment::latest()->take(3)->get();
                @endphp
                @forelse($comments as $comment)
                <div class="comment-item">
                    <div class="comment-header">
                        <h3 class="comment-author">{{ $comment->user ? $comment->user->name : 'Anonymous' }}</h3>
                        <p class="comment-date">
                            🕒 {{ Carbon::parse($comment->created_at)->format('F j, Y') }}
                        </p>
                    </div>
                    <p class="comment-content">{{ strip_tags($comment->content) }}</p>
                    <p class="comment-additional">{{ $comment->comment ?? 'No additional comment' }}</p>
                </div>
                @empty
                    <div class="comment-item">
                        <div class="comment-header">
                            <h3 class="comment-author">James Wilson</h3>
                            <p class="comment-date">🕒 April 18, 2024</p>
                        </div>
                        <p class="comment-content">Thank you for sharing your inspiring story, Sarah. It really opened my eyes to the importance of sustainable living.</p>
                        <p class="comment-additional">A truly touching and motivational story that everyone should read.</p>
                    </div>
                    
                    <div class="comment-item">
                        <div class="comment-header">
                            <h3 class="comment-author">Emily Rodriguez</h3>
                            <p class="comment-date">🕒 April 18, 2024</p>
                        </div>
                        <p class="comment-content">I completely agree with your points about gender equality. It's essential for creating a fair and just society for everyone.</p>
                        <p class="comment-additional">We definitely need more discussions and awareness about this important topic.</p>
                    </div>

                    <div class="comment-item">
                        <div class="comment-header">
                            <h3 class="comment-author">Anonymous</h3>
                            <p class="comment-date">🕒 May 1, 2024</p>
                        </div>
                    <p class="comment-content">This article opened my eyes to new perspectives</p>
                </div>
                @endforelse
            </div>
        </section>
    </main>

    
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3 class="footer-title">Quick Navigation</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('articles.index') }}">Educational Articles</a></li>
                    <li><a href="{{ route('stories.index') }}">User Stories</a></li>
                    <li><a href="{{ route('comments.index') }}">Comments</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3 class="footer-title">Article Category</h3>
                <ul class="footer-links">
                    @foreach ($categories as $category)
                        <li><a href="{{ route('articles.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                    @endforeach
                </ul>
            </div>  
            <div class="footer-section">
                <h3 class="footer-title">About Us</h3>
                <p class="footer-about">
                    SuaraKita adalah platform untuk berbagi cerita, artikel edukasi, dan komentar seputar isu sosial seperti perubahan iklim, kesehatan mental, lingkungan, dan kesetaraan gender. Bersama, kita bisa menciptakan perubahan positif!
                </p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} SuaraKita. All rights reserved.</p>
        </div>
    </footer>

   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
