<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - SuaraKita</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Space+Grotesk:wght@400;500;600;700&display=swap');

        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --dark-gradient: linear-gradient(135deg, #0c0c0c 0%, #1a1a2e 100%);
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
            --shadow-color: rgba(0, 0, 0, 0.1);
            --glow-color: rgba(102, 126, 234, 0.4);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0f23 0%, #1a1a2e 50%, #16213e 100%);
            color: #ffffff;
            overflow-x: hidden;
            perspective: 1000px;
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -2;
        }

        .bg-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            animation: float 20s infinite ease-in-out;
        }

        .bg-orb:nth-child(1) {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, #667eea, #764ba2);
            top: -200px;
            left: -200px;
            animation-delay: 0s;
        }

        .bg-orb:nth-child(2) {
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, #f093fb, #f5576c);
            top: 20%;
            right: -150px;
            animation-delay: 5s;
        }

        .bg-orb:nth-child(3) {
            width: 250px;
            height: 250px;
            background: radial-gradient(circle, #4facfe, #00f2fe);
            bottom: 20%;
            left: 10%;
            animation-delay: 10s;
        }

        .bg-orb:nth-child(4) {
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, #a8edea, #fed6e3);
            top: 60%;
            right: 20%;
            animation-delay: 15s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) translateX(0px) scale(1); }
            25% { transform: translateY(-30px) translateX(20px) scale(1.1); }
            50% { transform: translateY(20px) translateX(-20px) scale(0.9); }
            75% { transform: translateY(-10px) translateX(15px) scale(1.05); }
        }

        /* Glass Morphism Grid */
        .grid-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            z-index: -1;
            animation: gridPulse 4s ease-in-out infinite;
        }

        @keyframes gridPulse {
            0%, 100% { opacity: 0.3; }
            50% { opacity: 0.6; }
        }

        .register-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 500px;
            margin: 2rem;
            perspective: 1000px;
            transform-style: preserve-3d;
        }

        .register-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
            animation: slideIn 0.8s ease-out;
            transform-style: preserve-3d;
            transform: translateZ(0);
        }

        .register-card:hover {
            /* Completely remove hover effect */
            transform: none !important;
            box-shadow: none !important;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(50px) translateZ(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0) translateZ(0);
            }
        }

        .logo-section {
            text-align: center;
            margin-bottom: 32px;
            transform-style: preserve-3d;
        }

        .logo {
            width: 70px;
            height: 70px;
            background: var(--primary-gradient);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            font-size: 28px;
            color: white;
            font-weight: bold;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            animation: pulse 2s infinite;
            transform: translateZ(30px);
        }

        @keyframes pulse {
            0%, 100% {
                transform: translateZ(30px) scale(1);
            }
            50% {
                transform: translateZ(30px) scale(1.05);
            }
        }

        .title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 32px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transform: translateZ(20px);
            background: linear-gradient(135deg, #ffffff 0%, #667eea 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .subtitle {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 400;
            transform: translateZ(15px);
        }

        .form-group {
            margin-bottom: 24px;
            position: relative;
            transform-style: preserve-3d;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 8px;
            transition: color 0.3s ease;
            transform: translateZ(10px);
        }

        .form-input {
            width: 100%;
            padding: 16px 20px;
            font-size: 16px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            color: white;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            transform: translateZ(5px);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-input:focus {
            outline: none;
            border-color: #4facfe;
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 0 0 4px rgba(79, 172, 254, 0.1);
            transform: translateZ(15px);
        }

        .register-button {
            width: 100%;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            color: white;
            background: var(--accent-gradient);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
            transform: translateZ(20px);
        }

        .register-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .register-button:hover::before {
            left: 100%;
        }

        .register-button:hover {
            transform: translateZ(30px) translateY(-2px);
            box-shadow: 0 15px 35px rgba(79, 172, 254, 0.4);
        }

        .register-button:active {
            transform: translateZ(20px) translateY(0);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            transform: translateZ(10px);
        }

        .login-link a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .login-link a:hover {
            color: #4facfe;
        }

        .login-link a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #4facfe;
            transition: width 0.3s ease;
        }

        .login-link a:hover::after {
            width: 100%;
        }

        @media (max-width: 480px) {
            .register-card {
                margin: 20px;
                padding: 30px 25px;
            }
            
            .title {
                font-size: 24px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-gradient);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent-gradient);
        }
    </style>
</head>
<body>
    <div class="animated-bg">
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
        <div class="bg-orb"></div>
    </div>

    <div class="grid-overlay"></div>

    <div class="register-container">
        <div class="register-card">
            <div class="logo-section">
                <div class="logo">EC</div>
                <h1 class="title">Create Account</h1>
                <p class="subtitle">Join our educational community today</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input 
                        type="text" 
                        class="form-input" 
                        id="name" 
                        name="name" 
                        placeholder="Enter your full name"
                        required 
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input 
                        type="email" 
                        class="form-input" 
                        id="email" 
                        name="email" 
                        placeholder="Enter your email"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        class="form-input" 
                        id="password" 
                        name="password" 
                        placeholder="Create a password"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input 
                        type="password" 
                        class="form-input" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="Confirm your password"
                        required
                    >
                </div>

                <button type="submit" class="register-button">
                    Create Account
                </button>

                <div class="login-link">
                    <a href="{{ route('login') }}">Already have an account? Sign in here</a>
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

        // Add loading state to button
        const registerButton = document.querySelector('.register-button');
        const form = document.querySelector('form');
        
        form.addEventListener('submit', function(e) {
            registerButton.innerHTML = '<span style="opacity: 0.7;">Creating Account...</span>';
            registerButton.style.pointerEvents = 'none';
        });

        // Add 3D tilt effect to card
        const card = document.querySelector('.register-card');
        
        document.addEventListener('mousemove', function(e) {
            if (window.innerWidth <= 768) return;
            
            const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
            const yAxis = (window.innerHeight / 2 - e.pageY) / 25;
            
            card.style.transform = `translateZ(10px) rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
        });
        
        document.addEventListener('mouseleave', function() {
            card.style.transform = 'translateZ(0) rotateY(0) rotateX(0)';
        });
    </script>
</body>
</html>
