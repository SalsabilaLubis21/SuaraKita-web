@extends('layouts.app')

@section('title', 'Admin Account Settings')

@section('content')
<!-- Admin Settings Hero Section -->
<div class="admin-settings-hero position-relative overflow-hidden mb-4">
    <div class="admin-hero-overlay"></div>
    <div class="container py-4 position-relative">
        <div class="row justify-content-center">
            <div class="col-lg-10 text-center">
                <div class="admin-badge mb-3 fade-in">
                    <span class="admin-view-badge">Admin Panel</span>
                </div>
                <h1 class="display-5 fw-bold text-white mb-3 admin-title-hero">
                    Admin Account Settings
                </h1>
                <p class="text-white-50 mb-0 subtitle-hero">
                    Update your account details and change your password securely
                </p>
            </div>
        </div>
    </div>
</div>

<div class="container pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="admin-settings-container bg-white shadow-sm rounded-4 p-4 p-md-5 mb-4">
                <form action="{{ route('admin.settings.update') }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $admin->name ?? '') }}" class="form-input" required />
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $admin->email ?? '') }}" class="form-input" required />
                    </div>

                    <hr class="my-6">

                    <h2 class="section-subtitle mb-4">Change Password</h2>

                    <div class="mb-4">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-input" required />
                    </div>

                    <div class="mb-4">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" id="new_password" name="new_password" class="form-input" required />
                    </div>

                    <div class="mb-4">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="form-input" required />
                    </div>

                    <div>
                        <button type="submit" class="btn-submit">
                            Update Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<link href="{{ asset('css/admin-setting.css') }}" rel="stylesheet" />

@endsection
