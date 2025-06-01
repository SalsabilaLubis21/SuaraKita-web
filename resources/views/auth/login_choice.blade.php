<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login Choice</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
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

        /* Grid Overlay */
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

        /* Login Card */
        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 24px;
            padding: 3rem;
            max-width: 400px;
            width: 90%;
            text-align: center;
            transform-style: preserve-3d;
            transform: translateZ(0);
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 
                0 20px 50px rgba(0,0,0,0.3),
                0 0 30px var(--glow-color);
            position: relative;
            overflow: hidden;
        }

        .login-card:hover {
            transform: translateZ(30px) translateY(-10px);
            box-shadow: 
                0 30px 70px rgba(0,0,0,0.4),
                0 0 50px var(--glow-color);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            z-index: 1;
        }

        .login-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 2rem;
            background: linear-gradient(135deg, #ffffff 0%, #667eea 50%, #f093fb 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            transform: translateZ(20px);
            position: relative;
        }

        .login-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: var(--accent-gradient);
            border-radius: 2px;
        }

        .login-buttons {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 2.5rem;
            transform-style: preserve-3d;
        }

        .login-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1.2rem;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 16px;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateZ(10px);
            position: relative;
            overflow: hidden;
        }

        .login-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--primary-gradient);
            transition: left 0.6s ease;
            z-index: -1;
        }

        .login-button:hover::before {
            left: 0;
        }

        .login-button:hover {
            transform: translateZ(20px) translateY(-5px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
            border-color: rgba(255,255,255,0.4);
        }

        .login-button.admin::before {
            background: var(--secondary-gradient);
        }

        .back-link {
            display: inline-block;
            margin-top: 2rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            transform: translateZ(5px);
            position: relative;
            padding: 0.5rem 1.5rem;
            border-radius: 50px;
            border: 1px solid var(--glass-border);
        }

        .back-link::before {
            content: '←';
            margin-right: 0.5rem;
            transition: transform 0.3s ease;
            display: inline-block;
        }

        .back-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.3);
        }

        .back-link:hover::before {
            transform: translateX(-3px);
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem;
            }
            
            .login-title {
                font-size: 2rem;
            }
        }

        /* Loading Animation */
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        .loading-shimmer {
            position: relative;
            overflow: hidden;
        }

        .loading-shimmer::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            animation: shimmer 2s infinite;
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
    
    <div class="login-card">
        <h1 class="login-title">Login as</h1>
        <div class="login-buttons">
            <a href="{{ route('login', ['role' => 'user']) }}" class="login-button user">User</a>
            <a href="{{ route('login', ['role' => 'admin']) }}" class="login-button admin">Admin</a>
        </div>
        <div>
            <a href="{{ route('welcome') }}" class="back-link">Back to Home</a>
        </div>
    </div>
</body>
</html>
