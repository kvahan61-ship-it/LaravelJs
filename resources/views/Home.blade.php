@extends('layouts.main')
@push('styles')
    @vite('resources/css/Post/Post.css')
    @vite(['resources/css/Home.css'])
@endpush
@section('content')
    <div class="container">
        @include('posts.index')
    </div>
@endsection
@push('scripts')
    @vite(['resources/js/Post/carusel.js'])
    @vite('resources/js/Cart/cart-create.js')
@endpush
