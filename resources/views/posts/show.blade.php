@extends('layouts.main')

@section('content')
    <div class="product-page-container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">

        <a href="{{ route('home') }}" style="text-decoration: none; color: #666; display: inline-flex; align-items: center; gap: 5px; margin-bottom: 20px;">
            ← Գնալ գնումների
        </a>

        <div class="product-main" style="display: flex; gap: 40px; flex-wrap: wrap;">

            <div class="product-gallery" style="flex: 1; min-width: 300px;">
                <div class="single-image-wrapper">

                    @if($post->images->count() > 0)
                        <div class="show-carousel-track" id="showCarouselTrack">
                            @foreach($post->images as $image)
                                @if(str_starts_with($image->path, 'demo-'))
                                    @php
                                        $pureName = str_replace('demo-', '', $image->path);
                                    @endphp
                                    <img src="{{ asset('images/products/' . $pureName) }}" alt="{{ $post->title }}">
                                @else
                                    {{-- Եթե յուզերի իրական ավելացրածն է՝ կարդում ենք storage-ից --}}
                                    <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $post->title }}">
                                @endif
                            @endforeach
                        </div>

                        @if($post->images->count() > 1)
                            <button type="button" class="carousel-nav-btn" id="prevShowBtn">&larr;</button>
                            <button type="button" class="carousel-nav-btn" id="nextShowBtn">&rarr;</button>

                            <div id="showCarouselCounter">
                                1 / {{ $post->images->count() }}
                            </div>
                        @endif
                    @else
                        <img src="{{ asset('images/no-image.png') }}" alt="No image" style="width: 100%; height: 450px; object-fit: cover;">
                    @endif

                    <div class="product-description-bar">
                        <p>
                            {{ $post->description ?? 'Նկարագրություն առկա չէ։' }}
                        </p>
                    </div>

                </div>
            </div>

            <div class="product-info-box" style="flex: 1; min-width: 300px; display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <span class="category-badge" style="background: #e1f0ff; color: #007bff; padding: 6px 12px; border-radius: 20px; font-size: 14px; font-weight: bold;">
                        {{ $post->category->name ?? 'Ընդհանուր' }}
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 5px; margin-left: 10px;">
                        <i class="fa fa-eye" style="font-size: 16px;"></i>
                        <strong>{{ $viewsCount }}</strong> դիտում
                    </span>

                    <h1 style="font-size: 32px; margin: 15px 0 10px 0; font-weight: 800; color: #2c3e50;">{{ $post->title }}</h1>

                    <div class="price-tag" style="font-size: 28px; font-weight: bold; color: #2ecc71; margin-bottom: 25px;">
                        {{ number_format($post->price, 0, '.', ' ') }} ֏
                    </div>

                    <div class="quantity-selector" style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                        <span style="font-size: 16px; color: #7f8c8d; font-weight: bold;">Քանակ՝</span>
                        <div style="display: flex; align-items: center; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #f8f9fa;">
                            <button type="button" class="quantity-btn minus-btn" style="background: none; border: none; padding: 10px 15px; font-size: 18px; cursor: pointer; font-weight: bold; color: #555;">-</button>
                            <input type="number" id="product-quantity" value="1" min="1" style="width: 50px; text-align: center; border: none; background: transparent; font-size: 16px; font-weight: bold; -moz-appearance: textfield;">
                            <button type="button" class="quantity-btn plus-btn" style="background: none; border: none; padding: 10px 15px; font-size: 18px; cursor: pointer; font-weight: bold; color: #555;">+</button>
                        </div>
                    </div>

                    <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
                </div>

                <div style="margin-top: 30px; display: flex; gap: 15px;">
                    <button class="add-to-cart-btn-primary" data-id="{{ $post->id }}" style="flex: 3; background: #28a745; color: white; border: none; padding: 16px; border-radius: 12px; font-size: 18px; font-weight: bold; cursor: pointer; transition: 0.3s; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        <i class="fa fa-shopping-cart"></i> Ավելացնել զամբյուղ
                    </button>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        @vite(['resources/css/Post/Post.css', 'resources/js/Cart/cart-create.js'])
    @endpush
@endsection
