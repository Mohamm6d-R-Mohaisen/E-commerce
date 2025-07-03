<?php

namespace App\View\Components\frontend;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartMenu extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        // الحصول على عناصر السلة باستخدام Global Scope (cookie_id)
        $cartItems = Cart::with('product')->get();
        
        $total = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        return view('components.frontend.cart-menu', compact('cartItems', 'total'));
    }
} 