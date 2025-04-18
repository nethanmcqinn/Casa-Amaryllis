<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Casa Amaryllis') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
    <style>
        /* Base styles */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #fdf2f8 0%, #f5f3ff 100%);
        }

        /* Navigation */
        .navbar {
            background: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 5rem;
        }

        .brand-logo {
            font-size: 1.5rem;
            font-weight: bold;
            background: linear-gradient(to right, #db2777, #9333ea);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            color: #374151;
            text-decoration: none;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
        }

        .nav-link:hover {
            color: #db2777;
            background: #fdf2f8;
        }

        .nav-link i {
            margin-right: 0.5rem;
        }

        .cart-link {
            position: relative;
        }

        .cart-counter {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #db2777;
            color: white;
            font-size: 0.75rem;
            height: 20px;
            width: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-logout {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .btn-logout:hover {
            color: #db2777;
            background: #fdf2f8;
        }

        /* Main content */
        .main-content {
            min-height: calc(100vh - 9rem);
            padding: 2rem 1rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 2rem 0;
            margin-top: 3rem;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        @media (min-width: 768px) {
            .footer-content {
                flex-direction: row;
                justify-content: space-between;
            }
        }

        .footer-links {
            display: flex;
            gap: 2rem;
        }

        .footer-link {
            color: #4b5563;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-link:hover {
            color: #db2777;
        }

        .footer-bottom {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 1.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-content">
                <a href="{{ url('/') }}" class="brand-logo">Casa Amaryllis</a>
                <div class="nav-links">
                    <a href="{{ route('shop.index') }}" class="nav-link">
                        <i class="fas fa-store"></i> Shop
                    </a>
                    @auth
                        <a href="{{ route('profile') }}" class="nav-link">
                            <i class="fas fa-user"></i> Profile
                        </a>
                        <a href="{{ route('cart.index') }}" class="nav-link cart-link">
                            <i class="fas fa-shopping-cart"></i> Cart
                            @if($cartCount = auth()->user()->carts()->sum('quantity'))
                                <span class="cart-counter">{{ $cartCount }}</span>
                            @endif
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="nav-link">
                            @csrf
                            <button type="submit" class="btn-logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="nav-link">
                            <i class="fas fa-user-plus"></i> Register
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <a href="{{ url('/') }}" class="brand-logo">Casa Amaryllis</a>
                <div class="footer-links">
                    <a href="#" class="footer-link">About Us</a>
                    <a href="#" class="footer-link">Contact</a>
                    <a href="#" class="footer-link">Privacy Policy</a>
                </div>
            </div>
            <div class="footer-bottom">
                &copy; {{ date('Y') }} Casa Amaryllis. All rights reserved.
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
