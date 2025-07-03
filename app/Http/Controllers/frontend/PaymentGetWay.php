<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentGetWay extends Controller
{
    //
    public function create(Order $order)
    {
        return view('frontend.payment.create', compact('order'));
    }
    


    public function createStriPepayment(Order $order)
    {
        // Convert to cents (Stripe requires amount in cents)
        $amount = (int) ($order->total_amount * 100);

        try {
            Stripe::setApiKey(config('services.stripe.secret_key'));

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'usd',
                'metadata' => [
                    'order_id' => $order->id,
                    'order_number' => $order->id,
                ],
            ]);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to create payment intent'], 500);
        }
    }
    public function confirm(Request $request, Order $order)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.secret_key'));
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent', [])
        );
        if ($paymentIntent->status == 'succeeded') {
            $payment = new Payment();
            $payment->forceFill([
                'order_id' => $order->id,
                'amount' => $paymentIntent->amount / 100, // Convert from cents to dollars
                'currency' => $paymentIntent->currency,
                'status' => 'completed',
                'transaction_id' => $paymentIntent->id,
                'data' => json_encode($paymentIntent),
            ])->save();
            
            // Update order payment status
            $order->update([
                'payment_status' => 'paid'
            ]);
            
            return redirect()->route('order.success', $order->id)
                ->with('success', __('checkout.payment_successful'));
        }
        return redirect()->route('order.payment.create', $order->id)
            ->with('error', __('checkout.payment_failed'));
    }
}
