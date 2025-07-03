<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;

class OrderController extends Controller
{
    /**
     * Show the checkout page
     */
    public function create()
    {
        // Get cart items using Global Scope (cookie-based)
        $cartItems = Cart::with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('home')->with('error', __('app.cart_is_empty'));
        }

        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return view('frontend.checkout.index', compact('cartItems', 'total'));
    }

    /**
     * Store a new order
     */
    public function store(Request $request)
    {
        // Basic validation
        $request->validate([
            'billing_first_name' => 'required|string|max:255',
            'billing_last_name' => 'required|string|max:255',
            'billing_email' => 'required|email|max:255',
            'billing_phone' => 'required|string|max:20',
            'billing_street_address' => 'required|string|max:500',
            'billing_city' => 'required|string|max:100',
            'billing_country' => 'required|string|size:2',
        ]);

        try {
            DB::beginTransaction();
            
            // Check if user is authenticated
            if (!Auth::check()) {
                Log::error('User not authenticated when trying to create order');
                return redirect()->route('login')->with('error', 'Please login first');
            }

            // Get cart items using Global Scope (cookie-based)
            $cartItems = Cart::with('product')->get();
            Log::info('Cart items count: ' . $cartItems->count());

            if ($cartItems->isEmpty()) {
                Log::error('Cart is empty when trying to create order');
                return redirect()->route('home')->with('error', __('app.cart_is_empty'));
            }

            // Calculate total
            $total = $cartItems->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
            Log::info('Order total calculated: ' . $total);

            // Create order with default payment method
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $total,
                'payment_method' => 'stripe',
                'payment_status' => 'pending',
                'order_status' => 'pending',
                'currency' => 'USD',
                'notes' => $request->notes,
            ]);
            Log::info('Order created successfully with ID: ' . $order->id);

            // Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                ]);
            }
            Log::info('Order items created successfully');

            // Create billing address (remove type field)
            OrderAddress::create([
                'order_id' => $order->id,
                'first_name' => $request->billing_first_name,
                'last_name' => $request->billing_last_name,
                'email' => $request->billing_email,
                'phone_number' => $request->billing_phone,
                'street_address' => $request->billing_street_address,
                'city' => $request->billing_city,
                'state' => $request->billing_state,
                'country' => $request->billing_country,
                'postal_code' => $request->billing_postal_code,
            ]);
            Log::info('Billing address created successfully');

            // Clear cart - using Global Scope to clear cookie-based cart
            Cart::query()->delete();
            Log::info('Cart cleared successfully');

            DB::commit();

            // Redirect to Stripe payment page
            return redirect()->route('order.payment.create', $order->id)
                ->with('success', __('checkout.order_created_successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating order: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Show order success page
     */
    public function success($orderId)
    {
        $order = Order::with(['items.product', 'billingAddress'])->findOrFail($orderId);
        
        // Check if the order belongs to the authenticated user
        if ($order->user_id !== Auth::id()) {
            abort(404);
        }

        return view('frontend.orders.success', compact('order'));
    }

    /**
     * Show user's orders
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items.product', 'billingAddress'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }

    /**
     * Show specific order details
     */
    public function show($orderId)
    {
        $order = Order::with(['items.product', 'billingAddress'])
            ->where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.orders.show', compact('order'));
    }

    /**
     * Update order status (for admin use or future features)
     */
    public function updateStatus(Request $request, $orderId)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $order->update([
            'order_status' => $request->status
        ]);

        return redirect()->back()->with('success', __('checkout.order_status_updated'));
    }

    /**
     * Cancel order (if allowed)
     */
    public function cancel($orderId)
    {
        $order = Order::where('id', $orderId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Only allow cancellation for pending orders
        if ($order->order_status !== 'pending') {
            return redirect()->back()->with('error', __('checkout.cannot_cancel_order'));
        }

        $order->update([
            'order_status' => 'cancelled'
        ]);

        return redirect()->back()->with('success', __('checkout.order_cancelled_successfully'));
    }
}
