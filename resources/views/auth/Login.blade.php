@extends('layouts.main')
@push('styles')
    @vite(['resources/css/auth/Login.css'])
@endpush
@section('content')
    <div class="login-container">
        <form id="loginForm">
            @csrf
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div id="loginMessage"></div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('{{ route("login.post") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
                .then(res => res.json())
                .then(data => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        document.getElementById('loginMessage').innerText = data.errors.auth;
                    }
                });
        });
    </script>
@endpush
