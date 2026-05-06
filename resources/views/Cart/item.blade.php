<div class="cart-item-row" style="display: flex; align-items: center; gap: 20px; background: #fff; padding: 15px; border-radius: 12px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <div class="item-img">
        <img src="{{ $post->images->count() > 0 ? asset('storage/' . $post->images->first()->path) : asset('images/no-image.png') }}"
             style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
    </div>
    <div class="item-details" style="flex: 2;">
        <h4 style="margin: 0; font-size: 18px;">{{ $post->title }}</h4>
        <p style="color: #666; margin: 5px 0;">{{ number_format($post->price, 0, '.', ' ') }} ֏</p>
    </div>

    @if(isset($isCart))
        <div class="item-quantity" style="display: flex; align-items: center; gap: 10px;">
            <button class="qty-btn update-qty" data-action="decrease">-</button>
            <span style="font-weight: bold; min-width: 20px; text-align: center;">{{ $count }}</span>
            <button class="qty-btn update-qty" data-action="increase">+</button>
        </div>
        <div class="item-total" style="flex: 1; text-align: right; font-weight: bold; color: #2ecc71;">
            {{ number_format($post->price * $count, 0, '.', ' ') }} ֏
        </div>
    @endif
</div>
