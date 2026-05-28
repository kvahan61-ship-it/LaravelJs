@extends('layouts.main')

@push('styles')
    @vite(['resources/css/Post/Post.css', 'resources/css/Home.css'])
@endpush

@section('content')
    <div class="home-container" style="max-width: 1200px; margin: 0 auto; padding: 20px;">

        @include('categories/index')

        <div class="shop-grid">
            @forelse($posts as $post)
                <div class="product-card">
                    <div class="product-badge">{{ $post->category->name ?? 'Ընդհանուր' }}</div>
                    <a href="{{ route('post.show', $post->id) }}" class="product-image-wrapper">
                        @if($post->images->count() > 0)
                            <div class="image-scroll-container">
                                @foreach($post->images as $image)
                                    @if(str_starts_with($image->path, 'demo-'))
                                        @php $pureName = str_replace('demo-', '', $image->path); @endphp
                                        <img src="{{ asset('images/products/' . $pureName) }}" alt="{{ $post->title }}" class="scroll-img" title="{{ $post->description ?? 'Նկարագրություն առկա չէ։' }}">
                                    @else
                                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $post->title }}" class="scroll-img" title="{{ $post->description ?? 'Նկարագրություն առկա չէ։' }}">
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="image-scroll-container">
                                <img src="{{ asset('images/no-image.png') }}" alt="No image" class="scroll-img">
                            </div>
                        @endif
                    </a>

                    <div class="product-info">
                        <h3 class="product-title">{{ $post->title }}</h3>
                        <div class="product-price-row">
                            <span class="price">{{ number_format($post->price, 0, '.', ' ') }} ֏</span>
                        </div>

                        <button class="add-to-cart-btn-primary" data-id="{{ $post->id }}">
                            <i class="fa fa-shopping-cart"></i> Ավելացնել զամբյուղ
                        </button>
                    </div>
                </div>
            @empty
                <div style="text-align: center; width: 100%; padding: 40px; font-size: 18px; color: #666;">
                    😢 Ապրանքներ չեն գտնվել։
                </div>
            @endforelse
        </div>

    </div>
@endsection

@push('scripts')
    @vite(['resources/js/Post/carusel.js', 'resources/js/Cart/cart-create.js'])
@endpush
