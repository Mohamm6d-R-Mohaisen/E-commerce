@extends('frontend.layout')

@section('content')
<!-- End Payment Area -->
<script src="https://js.stripe.com/v3/"></script>
<div class="account-login section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-12">
                
                <!-- Order Summary Section -->
                <div class="order-summary-section mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="lni lni-cart"></i> {{ __('checkout.order_summary') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>{{ __('checkout.order_details') }}</h6>
                                    <p><strong>{{ __('checkout.total_amount') }}:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                                    <p><strong>{{ __('checkout.items_count') }}:</strong> {{ $order->items->sum('quantity') }} {{ __('checkout.items') }}</p>
                    </div>
                                <div class="col-md-6">
                                    <h6>{{ __('checkout.billing_address') }}</h6>
                                    <address>
                                        <strong>{{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}</strong><br>
                                        {{ $order->billingAddress->street_address }}<br>
                                        {{ $order->billingAddress->city }}, {{ $order->billingAddress->state }}<br>
                                        {{ $order->billingAddress->country }} {{ $order->billingAddress->postal_code }}<br>
                                        <i class="lni lni-phone"></i> {{ $order->billingAddress->phone_number }}<br>
                                        <i class="lni lni-envelope"></i> {{ $order->billingAddress->email }}
                                    </address>
                                </div>
                            </div>

                            <!-- Order Items -->
                            <div class="order-items mt-3">
                                <h6>{{ __('checkout.order_items') }}</h6>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>{{ __('checkout.product') }}</th>
                                                <th>{{ __('checkout.price') }}</th>
                                                <th>{{ __('checkout.quantity') }}</th>
                                                <th>{{ __('checkout.total') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->items as $item)
                                            <tr>
                                                <td>{{ $item->product_name }}</td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="fw-bold">
                                                <td colspan="3">{{ __('checkout.total_amount') }}</td>
                                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="payment-section">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h4 class="mb-0"><i class="lni lni-credit-cards"></i> {{ __('checkout.secure_payment') }}</h4>
                        </div>
                        <div class="card-body">
                            <div id="payment-message" style="display: none;" class="alert alert-info"></div>
                            
                            <form action="" method="post" id="payment-form">
                                <div id="payment-element"></div>
                                <button type="submit" id="submit" class="btn btn-primary btn-lg w-100 mt-3">
                                    <span id="button-text">
                                        <i class="lni lni-lock-alt"></i> {{ __('checkout.pay_now') }} - ${{ number_format($order->total_amount, 2) }}
                                    </span>
                                    <span id="spinner" style="display: none;">
                                        <i class="lni lni-spinner lni-spin"></i> {{ __('checkout.processing') }}...
                                    </span>
                        </button>
                            </form>
                            
                            <div class="text-center mt-3">
                                <a href="{{ route('checkout') }}" class="btn btn-outline-secondary">
                                    <i class="lni lni-arrow-left"></i> {{ __('checkout.back_to_checkout') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<script>
    // This is your test publishable API key.
    const stripe = Stripe("{{ config('services.stripe.publishable_key') }}");

    let elements;

    initialize();

    document
        .querySelector("#payment-form")
        .addEventListener("submit", handleSubmit);

    // Fetches a payment intent and captures the client secret
    async function initialize() {
        const {
            clientSecret
        } = await fetch("{{ route('order.payment.stripe.create', $order->id) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                "_token": "{{ csrf_token() }}"
            }),
        }).then((r) => r.json());

        elements = stripe.elements({
            clientSecret
        });

        const paymentElement = elements.create("payment");
        paymentElement.mount("#payment-element");
    }

    async function handleSubmit(e) {
        e.preventDefault();
        setLoading(true);

        const {
            error
        } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                // Make sure to change this to your payment completion page
                return_url: "{{ route('order.payment.stripe.return', $order->id) }}",
            },
        });

        // This point will only be reached if there is an immediate error when
        // confirming the payment. Otherwise, your customer will be redirected to
        // your `return_url`. For some payment methods like iDEAL, your customer will
        // be redirected to an intermediate site first to authorize the payment, then
        // redirected to the `return_url`.
        if (error.type === "card_error" || error.type === "validation_error") {
            showMessage(error.message);
        } else {
            showMessage("An unexpected error occurred.");
        }

        setLoading(false);
    }

    // ------- UI helpers -------

    function showMessage(messageText) {
        const messageContainer = document.querySelector("#payment-message");

        messageContainer.style.display = "block";
        messageContainer.textContent = messageText;

        setTimeout(function() {
            messageContainer.style.display = "none";
            messageText.textContent = "";
        }, 4000);
    }

    // Show a spinner on payment submission
    function setLoading(isLoading) {
        if (isLoading) {
            // Disable the button and show a spinner
            document.querySelector("#submit").disabled = true;
            document.querySelector("#spinner").style.display = "inline";
            document.querySelector("#button-text").style.display = "none";
        } else {
            document.querySelector("#submit").disabled = false;
            document.querySelector("#spinner").style.display = "none";
            document.querySelector("#button-text").style.display = "inline";
        }
    }
</script>
@endsection

@push('style')
<style>
.order-summary-section .card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.payment-section .card {
    border: none;
    box-shadow: 0 2px 15px rgba(0,0,0,0.1);
}

.card-header {
    border-bottom: none;
    padding: 1.25rem;
}

.card-header h4 {
    font-weight: 600;
}

address {
    line-height: 1.6;
    color: #6c757d;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.order-items {
    border-top: 1px solid #dee2e6;
    padding-top: 1rem;
}

#payment-element {
    margin: 1rem 0;
}

.btn-lg {
    padding: 12px 24px;
    font-size: 1.1rem;
    font-weight: 600;
}

.lni-spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.alert {
    border-radius: 8px;
}

@media (max-width: 768px) {
    .col-lg-8 {
        padding: 0 15px;
    }
    
    .card-body {
        padding: 1rem;
    }
}
</style>
@endpush
