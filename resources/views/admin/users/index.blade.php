@extends('layouts.app')

@section('title', 'Manage Users - Admin')

@section('content')
<link href="{{ asset('css/admin-user.css') }}" rel="stylesheet" />
<!-- Admin Users Hero Section -->
<div class="admin-users-hero position-relative overflow-hidden mb-4">
    <div class="admin-hero-overlay"></div>
    <div class="container py-4 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="admin-badge mb-3 fade-in">
                    <span class="admin-view-badge">Admin Panel</span>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3 admin-title-hero">
                    User Management
                </h1>
                <p class="text-white-50 mb-0 subtitle-hero">
                    Manage and oversee all registered users on the platform
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="admin-users-container bg-white shadow-sm rounded-4 p-4 p-md-5 mb-4">
                <!-- Admin Controls -->
                <div class="admin-controls mb-4 d-flex justify-content-between align-items-center">
                    <h2 class="section-title mb-0">All Users</h2>
                    <a href="{{ route('admin.dashboard') }}" class="admin-back-btn">
                        <i class="fas fa-arrow-left me-2"></i>
                        <span>Back to Dashboard</span>
                    </a>
                </div>

                @if($users->count())
                <div class="table-responsive">
                    <table class="table table-hover users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Registered At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="user-row fade-in">
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->created_at instanceof \Illuminate\Support\Carbon)
                                        {{ $user->created_at->format('M j, Y H:i') }}
                                    @else
                                        {{ \Carbon\Carbon::parse($user->created_at)->format('M j, Y H:i') }}
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure you want to delete this user?');" class="action-btn btn-delete">
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
                    {{ $users->links() }}
                </div>
                @else
                <div class="empty-state text-center py-5">
                    <div class="empty-icon mb-3">👤</div>
                    <h3>No Users Found</h3>
                    <p class="text-muted">There are no users to manage at this time.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
