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
        <div class="quantity-selector" style="display: flex; align-items: center; gap: 15px; margin-bottom: 0;">
            <span style="font-size: 16px; color: #7f8c8d; font-weight: bold;">Քանակ՝</span>
            <div style="display: flex; align-items: center; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; background: #f8f9fa;">

                <button type="button" class="quantity-btn cart-qty-btn minus" data-id="{{ $cartItemId }}" style="background: none; border: none; padding: 10px 15px; font-size: 18px; cursor: pointer; font-weight: bold; color: #555;">-</button>

                <input type="number" class="cart-qty-input" value="{{ $count }}" min="1" readonly style="width: 50px; text-align: center; border: none; background: transparent; font-size: 16px; font-weight: bold; -moz-appearance: textfield;">

                <button type="button" class="quantity-btn cart-qty-btn plus" data-id="{{ $cartItemId }}" style="background: none; border: none; padding: 10px 15px; font-size: 18px; cursor: pointer; font-weight: bold; color: #555;">+</button>

            </div>
        </div>

        <div class="item-total row-total" style="flex: 1; text-align: right; font-weight: bold; color: #2ecc71;">
            {{ number_format($post->price * $count, 0, '.', ' ') }} ֏
        </div>
    @endif
</div>
