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

            $quantity = intval($request->input('quantity', 1));
            if ($quantity < 1) { $quantity = 1; }

            $cartItem = Cart::where('user_id', $userId)
                ->where('post_id', $postId)
                ->first();

            if ($cartItem) {
                $cartItem->increment('count', $quantity);
            } else {
                Cart::create([
                    'user_id' => $userId,
                    'post_id' => $postId,
                    'count' => $quantity
                ]);
            }

            $cartCount = Cart::where('user_id', $userId)->count();

            if ($request->ajax() || $request->wantsJson()) {
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
            $cartItem->increment('count');
        } elseif ($request->action === 'decrease' && $cartItem->count > 1) {
            $cartItem->decrement('count');
        }

        $rowTotal = $cartItem->count * ($cartItem->post->price ?? 0);

        $cartTotal = Cart::where('user_id', auth()->id())->get()->sum(function($item) {
            return $item->count * ($item->post->price ?? 0);
        });

        return response()->json([
            'status' => 'success',
            'new_quantity' => $cartItem->count,
            'row_total' => $rowTotal,
            'cart_total' => $cartTotal
        ]);
    }
}
