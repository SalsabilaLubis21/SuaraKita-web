
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - SuaraKita</title>
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
                <h1 class="title">Welcome Back</h1>
                <p class="subtitle">Sign in to continue your educational journey</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <input type="hidden" name="role" value="{{ request()->query('role', 'user') }}">
                <input type="hidden" name="redirect" value="{{ request()->query('redirect', '/') }}">
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
                    >
                    @if ($errors->has('email'))
                        <div class="error-message" style="color: #ff4d4f; font-size: 14px; margin-top: 8px;">
                            Incorrect email or password. Please try again.
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        class="form-input" 
                        id="password" 
                        name="password" 
                        placeholder="Enter your password"
                        required
                    >
                    <div class="forgot-password">
                        <a href="{{ route('forgot.password.form') }}">Forgot Password?</a>
                    </div>
                </div>

                <button type="submit" class="login-button">
                    Sign In
                </button>

                <div class="register-link">
                    <a href="{{ route('register') }}">Don't have an account? Create one here</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Add smooth focus animations
        const inputs = document.querySelectorAll('.form-input');
        
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                if (this.value === '') {
                    this.parentElement.classList.remove('focused');
                }
            });
        });

        // Add 3D tilt effect
        const card = document.querySelector('.login-card');
        const container = document.querySelector('.login-container');
        
        container.addEventListener('mousemove', function(e) {
            const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            card.style.transform = `translateZ(20px) rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });
        
        container.addEventListener('mouseenter', function() {
            card.style.transition = 'none';
        });
        
        container.addEventListener('mouseleave', function() {
            card.style.transition = 'all 0.5s ease';
            card.style.transform = 'translateZ(0) rotateY(0) rotateX(0)';
        });

        // Add loading state to button
        const loginButton = document.querySelector('.login-button');
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(e) {
            loginButton.innerHTML = '<span style="opacity: 0.7;">Signing In...</span>';
            loginButton.style.pointerEvents = 'none';
        });
    </script>
</body>
</html>