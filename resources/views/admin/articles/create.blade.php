@extends('layouts.app')

@section('title', 'Create New Article - Admin')

@section('content')
<!-- Admin Create Article Hero Section -->
<div class="admin-create-hero position-relative overflow-hidden mb-4">
    <div class="admin-hero-overlay"></div>
    <div class="container py-4 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="admin-badge mb-3 fade-in">
                    <span class="admin-view-badge">Admin Panel</span>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3 admin-title-hero">
                    Create New Article
                </h1>
                <p class="text-white-50 mb-0 admin-subtitle">
                    Create engaging content for your audience
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-form-container bg-white shadow-sm rounded-4 p-4 p-md-5 mb-4">
                <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="form-group mb-4">
                                <label for="title" class="form-label fw-medium mb-2">Article Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                    class="form-control form-control-lg @error('title') is-invalid @enderror" 
                                    placeholder="Enter a compelling title" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-4">
                                <label for="category" class="form-label fw-medium mb-2">Category <span class="text-danger">*</span></label>
                                <input type="text" name="category" id="category" value="{{ old('category') }}" 
                                    class="form-control @error('category') is-invalid @enderror" 
                                    placeholder="e.g. Environment, Education" required>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="summary" class="form-label fw-medium mb-2">Summary</label>
                        <textarea name="summary" id="summary" rows="3" 
                            class="form-control @error('summary') is-invalid @enderror" 
                            placeholder="A brief summary of your article">{{ old('summary') }}</textarea>
                        @error('summary')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">A compelling summary will appear at the beginning of your article</div>
                    </div>
                    
                    <div class="form-group mb-4">
                        <label for="content" class="form-label fw-medium mb-2">Content <span class="text-danger">*</span></label>
                        <textarea name="content" id="content" rows="12" 
                            class="form-control @error('content') is-invalid @enderror" 
                            placeholder="Write your article content here...">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="cover_image" class="form-label fw-medium mb-2">Cover Image</label>
                            <input type="file" name="cover_image" id="cover_image" 
                                class="form-control @error('cover_image') is-invalid @enderror" 
                                accept="image/*">
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Recommended size: 1200 x 630 pixels</div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="cover_image_url" class="form-label fw-medium mb-2">Or enter Cover Image URL</label>
                            <input type="url" name="cover_image_url" id="cover_image_url" 
                                value="{{ old('cover_image_url') }}"
                                class="form-control @error('cover_image_url') is-invalid @enderror" 
                                placeholder="https://example.com/image.jpg">
                            @error('cover_image_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Enter a direct URL to an image</div>
                        </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="published_at" class="form-label fw-medium mb-2">Publish Date</label>
                                <input type="datetime-local" name="published_at" id="published_at" 
                                    value="{{ old('published_at') }}" 
                                    class="form-control @error('published_at') is-invalid @enderror">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Leave empty to save as draft</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions d-flex justify-content-between align-items-center mt-5">
                        <a href="{{ route('admin.articles.index') }}" class="btn-cancel">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <div class="d-flex gap-2">
                            <button type="submit" name="save_draft" value="1" class="btn-draft">
                                <i class="fas fa-save me-1"></i> Save as Draft
                            </button>
                            <button type="submit" class="btn-publish">
                                <i class="fas fa-paper-plane me-1"></i> Publish Article
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('css/admin-articles-create.css') }}" rel="stylesheet" />

@endsection
