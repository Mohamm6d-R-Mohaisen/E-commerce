<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display cart items
     */
    public function index()
    {
        $cartItems = Cart::with('product.category')->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('frontend.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1'
        ]);

        $cookieId = Cart::getCookieId();
        $userId = Auth::id();

        // البحث عن العنصر الموجود بشكل صريح باستخدام cookie_id و product_id
        $existingItem = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', $cookieId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingItem) {
            $existingItem->quantity += $request->quantity ?? 1;
            $existingItem->save();

            $message = __('auth.cart_quantity_updated');
        } else {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $request->product_id,
                'quantity' => $request->quantity ?? 1,
                'cookie_id' => $cookieId,
            ]);

            $message = __('auth.product_added_to_cart');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => Cart::sum('quantity')
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cookieId = Cart::getCookieId();
        $cartItem = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', $cookieId)
            ->where('product_id', $productId)
    ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => __('auth.product_not_in_cart')]);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $total = Cart::with('product')->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('auth.quantity_updated'),
                'item_total' => number_format($cartItem->quantity * $cartItem->product->price, 2),
                'cart_total' => number_format($total, 2)
            ]);
        }

        return redirect()->back()->with('success', __('auth.quantity_updated'));
    }

    /**
     * Remove item from cart
     */
    public function destroy($productId)
    {
        $cookieId = Cart::getCookieId();
        $cartItem = Cart::withoutGlobalScope('cookie_id')
            ->where('cookie_id', $cookieId)
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => __('auth.product_not_in_cart')]);
        }

        $cartItem->delete();

        $total = Cart::with('product')->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('auth.product_removed_from_cart'),
                'cart_total' => number_format($total, 2),
                'cart_count' => Cart::count()
            ]);
        }

        return redirect()->back()->with('success', __('auth.product_removed_from_cart'));
    }

    /**
     * Clear all cart items
     */
    public function clear()
{
    Cart::query()->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => __('auth.cart_cleared'),
                'cart_count' => 0
            ]);
        }

        return redirect()->back()->with('success', __('auth.cart_cleared'));
    }

    /**
     * Get cart items for AJAX requests
     */
    public function getCartItems()
    {
        $cartItems = Cart::with('product')->get();

        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json([
            'items' => $cartItems,
            'total' => $total,
            'count' => $cartItems->sum('quantity')
        ]);
    }

    /**
     * Calculate cart total
     */
    public function calculateTotal()
    {
        return Cart::with('product')->get()->sum(function ($item) {
        return $item->quantity * $item->product->price;
    });
}

    /**
     * Get cart items count
     */
    public function getCartCount()
    {
        return Cart::sum('quantity');
    }

    /**
     * Get cart items for component
     */
    public static function getItemsForComponent($cookieId)
    {
        return Cart::with('product')->where('cookie_id', $cookieId)->get();
    }

    /**
     * Get cart total for component
     */
    public static function getTotalForComponent($cookieId)
    {
        return Cart::with('product')
            ->where('cookie_id', $cookieId)
            ->get()
            ->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
    }
}
