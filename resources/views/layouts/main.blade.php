<!doctype html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyShop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
@auth
    <header class="main-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo">MySocial</a>

            <form action="{{ route('home') }}" method="GET" class="search-bar">
                @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Որոնել ապրանքներ..." style="width: 100%; padding: 8px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none;">
                <button type="submit" style="display: none;">Որոնել</button>
            </form>

            <nav class="header-nav">
                @can('access-admin-panel')
                    <a href="/admin/dashboard" class="btn-admin-link" style="color: gold; font-weight: bold;" title="Admin">
                        👑
                    </a>
                @endcan

                <a href="{{ route('post.create') }}" class="nav-link" title="Վաճառել ապրանք">
                    <i class="fa fa-plus-circle" style="font-size: 22px;"></i>
                </a>

                <a href="{{ route('home') }}" class="nav-link">🏠</a>

                <a href="{{ route('cart.index') }}" class="nav-link cart-link" style="position: relative;">
                    <i class="fa fa-shopping-cart" style="font-size: 22px;"></i>
                    <span id="cart-badge" class="cart-badge">
                        {{ \App\Models\Cart::where('user_id', auth()->id())->count() }}
                    </span>
                </a>

                <a href="#" class="nav-link">🔔</a>

                <a href="{{route('profile.index')}}" class="user-menu" style="display: flex; align-items: center; gap: 8px;">
                    <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                         alt="Profile"
                         style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover; border: 1px solid #ddd;">
                    <span style="font-size: 14px; font-weight: 500;">{{ auth()->user()->name }}</span>
                </a>

                <form action="{{ route('logout') }}" method="POST" style="display: inline; margin-left: 10px;">
                    @csrf
                    <button type="submit" class="logout-btn" style="background: none; border: none; cursor: pointer; color: #ff4d4d; font-size: 18px;">
                        <i class="fa fa-sign-out"></i>
                    </button>
                </form>
            </nav>
        </div>
    </header>
@endauth

<main class="main-content">
    @yield('content')
</main>

@stack('scripts')
</body>
</html>
