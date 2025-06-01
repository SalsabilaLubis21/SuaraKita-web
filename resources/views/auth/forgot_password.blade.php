<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forgot Password - SuaraKita</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/login.css') }}" rel="stylesheet" />
</head>
<body>
    <div class="animated-bg">
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
    </div>
    
    <div class="grid-overlay"></div>

    <div class="login-container">
        <div class="login-card">
            <div class="logo-section">
                <div class="logo">EC</div>
                <h1 class="title">Forgot Password</h1>
                <p class="subtitle">Enter your email and new password</p>
            </div>

            @if (session('status'))
                <div class="status-message" style="color: #4BB543; font-size: 16px; margin-bottom: 20px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('forgot.password.submit') }}">
                @csrf
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        class="form-input" 
                        id="email" 
                        name="email" 
                        placeholder="Enter your email"
                        required 
                        autofocus
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <div class="error-message" style="color: #ff4d4f; font-size: 14px; margin-top: 8px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input 
                        type="password" 
                        class="form-input" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your new password"
                        required
                    >
                    @error('password')
                        <div class="error-message" style="color: #ff4d4f; font-size: 14px; margin-top: 8px;">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input 
                        type="password" 
                        class="form-input" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Confirm your new password"
                        required
                    >
                </div>

                <button type="submit" class="login-button">
                    Reset Password
                </button>

                <div class="register-link">
                    <a href="{{ route('login') }}">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
