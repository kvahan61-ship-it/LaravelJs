@extends('layouts.main')

@push('styles')
    @vite('resources/css/Cart/cart.css')
@endpush

@section('content')
    <div class="cart-container">
        <h2 class="cart-title">
            🛒 Քո Զամբյուղը
        </h2>

        @if($cartItems->count() > 0)
            <div class="cart-layout">

                <div class="cart-items-list">
                    @foreach($cartItems as $item)
                        @include('Cart.item', [
                            'post' => $item->post,
                            'count' => $item->count,
                            'isCart' => true,
                            'cartItemId' => $item->id,
                        ])
                    @endforeach
                </div>

                <div class="checkout-card">
                    <h4>Ընդհանուր</h4>

                    <div class="checkout-row">
                        <span>Ապրանքներ ({{ $cartItems->sum('count') }})</span>
                        <span>{{ number_format($total, 0, '.', ' ') }} ֏</span>
                    </div>
                    <div class="checkout-row shipping">
                        <span>Առաքում</span>
                        <span class="shipping-free">Անվճար</span>
                    </div>

                    <div class="checkout-total">
                        <span>Գումարը:</span>
                        <span>{{ number_format($total, 0, '.', ' ') }} ֏</span>
                    </div>

                    <button class="checkout-btn">
                        Ձևակերպել պատվերը
                    </button>
                </div>
            </div>
        @else
            <div class="cart-empty">
                <div class="cart-empty-icon">📭</div>
                <h3 class="cart-empty-text">Ձեր զամբյուղը դատարկ է:</h3>
                <a href="{{ route('home') }}" class="btn-shop">Գնալ գնումների</a>
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    @vite('resources/js/Cart/cart.js')
@endpush
