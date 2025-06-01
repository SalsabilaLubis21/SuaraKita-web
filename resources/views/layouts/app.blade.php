<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'SuaraKita')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark position-absolute w-100" style="z-index: 1000; background: transparent !important;">
        <div class="container position-relative">
            <a class="navbar-brand" href="{{ url('/') }}">SuaraKita</a>
            <!-- Removed hamburger menu button for mobile, always show menu -->
            <div class="collapse navbar-collapse show" id="navbarNav" style="display: block !important;">
                <ul class="navbar-nav ms-auto d-flex align-items-center gap-3 flex-column flex-lg-row">
                    @auth('admin')
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link m-0 p-0" style="border:none; background:none;">Logout</button>
                            </form>
                        </li>
                    @elseauth
                        <li class="nav-item d-flex align-items-center">
                            <a class="nav-link" href="{{ route('user.dashboard') }}">User Dashboard</a>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link m-0 p-0" style="border:none; background:none;">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item d-flex justify-content-start w-100"><a class="nav-link" href="{{ route('login.choice') }}">Login</a></li>
                        <li class="nav-item d-flex justify-content-start w-100"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <style>
        @media (max-width: 768px) {
            .navbar-nav.ms-auto {
                position: absolute;
                top: 0.5rem;
                right: 0; /* Adjusted right to 0 for better symmetry */
                background: transparent;
                padding: 0 0.5rem; /* Added horizontal padding */
                z-index: 1050;
                flex-direction: row !important;
                gap: 0.75rem !important;
                justify-content: flex-end !important; /* Changed from space-between to flex-end */
                width: auto !important; /* Changed from 100% to auto */
                max-width: none !important; /* Removed max-width */
            }
            .navbar-nav.ms-auto .nav-item {
                margin: 0 0.5rem !important; /* Added horizontal margin */
                flex-grow: 0; /* Removed flex-grow */
                text-align: center;
            }
            .container.position-relative {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        }
        @media (min-width: 769px) {
            .navbar-nav.ms-auto {
                flex-direction: row !important;
                gap: 0.75rem !important;
                justify-content: flex-end !important;
                position: absolute;
                right: 1rem;
                top: 0.5rem;
            }
        }
    </style>

    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
