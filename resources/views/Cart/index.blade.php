@extends('layouts.main')

@section('content')
    <div class="container" style="max-width: 1000px; margin: 40px auto; padding: 0 20px;">
        <h2 style="margin-bottom: 30px; font-weight: 800; display: flex; align-items: center; gap: 10px;">
            🛒 Քո Զամբյուղը
        </h2>

        @if($cartItems->count() > 0)
            <div class="cart-layout" style="display: flex; gap: 30px; align-items: flex-start;">

                <div class="cart-items-list" style="flex: 2;">
                    @foreach($cartItems as $item)
                        @include('Cart.item', [
                            'post' => $item->post,
                            'count' => $item->count,
                            'isCart' => true
                        ])
                    @endforeach
                </div>

                <div class="checkout-card" style="flex: 1; background: #fff; padding: 25px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); position: sticky; top: 100px;">
                    <h4 style="margin-top: 0; border-bottom: 1px solid #eee; padding-bottom: 15px;">Ընդհանուր</h4>

                    <div style="display: flex; justify-content: space-between; margin: 20px 0;">
                        <span>Ապրանքներ ({{ $cartItems->sum('count') }})</span>
                        <span>{{ number_format($total, 0, '.', ' ') }} ֏</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                        <span>Առաքում</span>
                        <span style="color: #2ecc71;">Անվճար</span>
                    </div>

                    <div style="display: flex; justify-content: space-between; font-size: 20px; font-weight: bold; margin-bottom: 25px; border-top: 1px solid #eee; padding-top: 15px;">
                        <span>Գումարը:</span>
                        <span>{{ number_format($total, 0, '.', ' ') }} ֏</span>
                    </div>

                    <button class="checkout-btn" style="width: 100%; background: #007bff; color: white; border: none; padding: 15px; border-radius: 12px; font-size: 16px; font-weight: bold; cursor: pointer; transition: 0.3s;">
                        Ձևակերպել պատվերը
                    </button>
                </div>
            </div>
        @else
            <div style="text-align: center; padding: 60px 0;">
                <div style="font-size: 60px; margin-bottom: 20px;">📭</div>
                <h3 style="color: #888;">Ձեր զամբյուղը դատարկ է:</h3>
                <a href="{{ route('home') }}" class="btn-shop" style="display: inline-block; margin-top: 20px; padding: 12px 25px; background: #007bff; color: white; text-decoration: none; border-radius: 8px;">Գնալ գնումների</a>
            </div>
        @endif
    </div>

    <style>
        .qty-btn { background: #f0f2f5; border: none; width: 30px; height: 30px; border-radius: 8px; cursor: pointer; transition: 0.2s; }
        .qty-btn:hover { background: #e4e6e9; }
        .checkout-btn:hover { background: #0056b3; transform: translateY(-2px); }
        .cart-layout { flex-direction: row; }

       \\
    </style>
@endsection
