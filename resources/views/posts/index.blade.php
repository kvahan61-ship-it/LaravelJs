<div class="shop-grid">
    @foreach($posts as $post)
        <div class="product-card">
            <div class="product-badge">{{ $post->category->name ?? 'Ընդհանուր' }}</div>
            <a href="{{ route('post.show', $post->id) }}" class="product-image-wrapper">
                @if($post->images->count() > 0)
                    <div class="image-scroll-container">
                        @foreach($post->images as $image)
                            @if(str_starts_with($image->path, 'demo-'))
                                @php
                                    $pureName = str_replace('demo-', '', $image->path);
                                @endphp
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
    @endforeach
</div>
