@extends('layouts.main')
@push('styles')
    @vite(['resources/css/auth/Login.css'])
@endpush
@section('content')
    <div class="login-container">
        <div id="login-errors"></div>

        <form action="{{ route('login.post') }}" method="POST" class="login-form">
            @csrf
            <input type="email" name="email" required placeholder="Էլ. հասցե">
            <input type="password" name="password" required placeholder="Գաղտնաբառ">

            <button type="submit">Մուտք գործել</button>
        </form>

        <div class="register-link-card">
            <p>Չունե՞ք հաշիվ: <a href="{{ route('register') }}">Գրանցվել</a></p>
        </div>
        <div>
            <a href="{{ route('password.request') }}">Մոռացե՞լ եք գաղտնաբառը</a>
        </div>
    </div>
@endsection
@push('scripts')
    @vite(['resources/js/auth/auth.js'])
@endpush
