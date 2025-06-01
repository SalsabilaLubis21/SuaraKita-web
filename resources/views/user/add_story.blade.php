@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-content">
        <div class="section-card">
            <h2 class="section-title">
                <div class="section-icon">✍️</div>
                Add New Story
            </h2>
            <form action="{{ route('stories.store') }}" method="POST" id="add-story-form">
                @csrf
                <div class="form-group mb-3">
                    <label for="title" class="form-label text-white">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required placeholder="Enter story title">
                </div>
                <div class="form-group mb-3">
                    <label for="content" class="form-label text-white">Content</label>
                    <textarea name="content" id="content" class="form-control" rows="6" required placeholder="Enter story content"></textarea>
                </div>
                <button type="submit" class="btn-modern btn-submit">Add Story</button>
            </form>
        </div>
    </div>
</div>

<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
<script src="{{ asset('js/dashboard.js') }}"></script>
@endsection
