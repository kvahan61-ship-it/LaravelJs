<div class="shop-grid">
    @foreach($posts as $post)
        <div class="product-card">
            <div class="product-badge">{{ $post->category->name ?? 'Ընդհանուր' }}</div>
            <a href="{{ route('post.show', $post->id) }}" class="product-image-wrapper">
                @if($post->images->count() > 0)
                    <div class="image-scroll-container">
                        @foreach($post->images as $image)
                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $post->title }}" class="scroll-img">
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
    @endforeach
</div>
