<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::with(['post.images'])
            ->where('user_id', $userId)
            ->get();

        $total = $cartItems->sum(function($item) {
            return ($item->post->price ?? 0) * $item->count;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    public function store(Request $request, $postId)
    {
        try {
            $userId = Auth::id();

            if (!$userId) {
                return response()->json(['status' => 'error', 'message' => 'Մուտք գործեք համակարգ'], 401);
            }

            $cartItem = Cart::where('user_id', $userId)
                ->where('post_id', $postId)
                ->first();

            if ($cartItem) {
                $cartItem->increment('count');
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'post_id' => $postId,
                    'count' => 1
                ]);
            }

            $cartCount = Cart::where('user_id', $userId)->count();

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'success',
                    'cart_count' => $cartCount,
                    'message' => 'Ապրանքն ավելացվեց զամբյուղում'
                ]);
            }

            return back()->with('success', 'Ապրանքն ավելացվեց զամբյուղում');

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    public function updateQuantity(Request $request, $id)
    {
        $cartItem = Cart::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

        if ($request->action === 'increase') {
            $cartItem->increment('quantity');
        } elseif ($request->action === 'decrease' && $cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        }

        $rowTotal = $cartItem->quantity * $cartItem->post->price;
        $cartTotal = Cart::where('user_id', auth()->id())->get()->sum(function($item) {
            return $item->quantity * $item->post->price;
        });

        return response()->json([
            'status' => 'success',
            'new_quantity' => $cartItem->quantity,
            'row_total' => $rowTotal,
            'cart_total' => $cartTotal
        ]);
    }
}
