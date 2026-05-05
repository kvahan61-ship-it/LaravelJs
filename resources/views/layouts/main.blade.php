<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
@auth
    <header class="main-header">
        <div class="header-container">
            <a href="{{ route('home') }}" class="logo">MySocial</a>

            <div class="search-bar">
                <input type="text" placeholder="Որոնել ընկերներ...">
            </div>

            <nav class="header-nav">
                @auth
                    <a href="{{ route('home') }}" class="nav-link">🏠</a>
                    <a href="#" class="nav-link">🔔</a>
                    <div class="user-menu">
                        <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : asset('images/default-avatar.png') }}"
                             alt="Profile Picture"
                             style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <span>{{ auth()->user()->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">Ելք</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="login-btn">Մուտք</a>
                @endauth
            </nav>
        </div>
    </header>
@endauth
<main>
    @yield('content')

    @stack('scripts')
</main>
</body>
</html>
