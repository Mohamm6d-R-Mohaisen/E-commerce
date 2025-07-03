@extends('frontend.layout')

@section('title', __('checkout.payment'))

@section('content')
<!-- Start Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">{{ __('checkout.payment') }}</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('app.home') }}</a></li>
                    <li><a href="{{ route('checkout') }}">{{ __('checkout.checkout') }}</a></li>
                    <li>{{ __('checkout.payment') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Payment Area -->
<section class="payment-wrapper section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ __('auth.error') }}!</strong>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <div class="payment-form-wrapper">
                    <div class="payment-header">
                        <h2><i class="lni lni-credit-cards"></i> {{ __('checkout.secure_payment') }}</h2>
                        <p>{{ __('checkout.order_number') }}: <strong>#{{ $order->id }}</strong></p>
                        <div class="payment-amount">
                            <span class="amount">{{ number_format($order->total_amount, 2) }} {{ __('app.currency') }}</span>
                        </div>
                    </div>

                    <div class="payment-form">
                        <form id="payment-form">
                            @csrf
                            <div class="card-element-wrapper">
                                <label for="card-element">{{ __('checkout.card_details') }}</label>
                                <div id="card-element" class="stripe-element">
                                    <!-- Stripe Elements will create form elements here -->
                                </div>
                                <div id="card-errors" role="alert" class="error-message"></div>
                            </div>

                            <div class="payment-actions">
                                <button type="submit" id="submit-payment" class="btn btn-primary">
                                    <span id="button-text">
                                        <i class="lni lni-lock-alt"></i>
                                        {{ __('checkout.pay_now') }} - {{ number_format($order->total_amount, 2) }} {{ __('app.currency') }}
                                    </span>
                                    <div id="spinner" class="spinner hidden">
                                        <i class="lni lni-spinner lni-spin"></i>
                                    </div>
                                </button>
                                
                                <a href="{{ route('order.payment.create', $order->id) }}" class="btn btn-secondary">
                                    <i class="lni lni-arrow-left"></i>
                                    {{ __('checkout.back_to_checkout') }}
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="order-summary-sidebar">
                    <div class="sidebar-header">
                        <h3><i class="lni lni-cart"></i> {{ __('checkout.order_summary') }}</h3>
                    </div>
                    
                    <div class="sidebar-body">
                        <!-- Order Items -->
                        <div class="order-items-list">
                            @foreach($order->items as $item)
                                <div class="order-item">
                                    <div class="item-details">
                                        <div class="item-name">{{ $item->product_name }}</div>
                                        <div class="item-info">
                                            <span>{{ __('checkout.quantity') }}: {{ $item->quantity }}</span>
                                            <span class="item-price">{{ number_format($item->price * $item->quantity, 2) }} {{ __('app.currency') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="order-totals">
                            <div class="total-line grand-total">
                                <span class="total-label">{{ __('checkout.total') }}:</span>
                                <span class="total-amount">{{ number_format($order->total_amount, 2) }} {{ __('app.currency') }}</span>
                            </div>
                        </div>

                        <div class="security-info">
                            <div class="security-item">
                                <i class="lni lni-lock-alt"></i>
                                <span>{{ __('checkout.secure_encrypted') }}</span>
                            </div>
                            <div class="security-item">
                                <i class="lni lni-shield"></i>
                                <span>{{ __('checkout.ssl_protected') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Payment Area -->

<style>
/* Payment Page Styles */
.payment-wrapper {
    padding: 60px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.payment-form-wrapper {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
}

.payment-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 40px;
    text-align: center;
}

.payment-header h2 {
    margin: 0 0 15px 0;
    font-size: 24px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.payment-header p {
    margin: 0;
    opacity: 0.9;
    font-size: 16px;
}

.payment-amount {
    margin-top: 20px;
    padding: 15px 30px;
    background: rgba(255,255,255,0.2);
    border-radius: 50px;
    display: inline-block;
}

.payment-amount .amount {
    font-size: 28px;
    font-weight: 800;
}

.payment-form {
    padding: 40px;
}

.card-element-wrapper {
    margin-bottom: 30px;
}

.card-element-wrapper label {
    display: block;
    font-weight: 600;
    margin-bottom: 10px;
    color: #2c3e50;
}

.stripe-element {
    padding: 15px 20px;
    border: 2px solid #e8ecef;
    border-radius: 12px;
    background: #f8f9fa;
    transition: border-color 0.3s ease;
}

.stripe-element:focus-within {
    border-color: #3498db;
    background: white;
}

.error-message {
    color: #e74c3c;
    font-size: 14px;
    margin-top: 8px;
    font-weight: 500;
}

.payment-actions {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.payment-actions .btn {
    height: 55px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.payment-actions .btn-primary {
    background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
    border: none;
    color: white;
    flex: 1;
    min-width: 250px;
}

.payment-actions .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 184, 148, 0.3);
}

.payment-actions .btn-secondary {
    background: #ecf0f1;
    color: #2c3e50;
    border: none;
    padding: 0 30px;
}

.spinner.hidden {
    display: none;
}

.order-summary-sidebar {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    position: sticky;
    top: 100px;
}

.sidebar-header {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
    padding: 25px 30px;
}

.sidebar-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar-body {
    padding: 30px;
}

.order-items-list {
    margin-bottom: 25px;
}

.order-item {
    padding: 15px 0;
    border-bottom: 1px solid #eee;
}

.order-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.item-name {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
}

.item-info {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    color: #7f8c8d;
}

.item-price {
    font-weight: 700;
    color: #e74c3c;
}

.order-totals {
    border-top: 2px solid #eee;
    padding-top: 20px;
    margin-bottom: 25px;
}

.total-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.total-label {
    color: #7f8c8d;
    font-weight: 600;
}

.total-amount {
    font-weight: 700;
    color: #2c3e50;
}

.grand-total {
    border-top: 2px solid #eee;
    padding-top: 15px;
    margin-top: 15px;
}

.grand-total .total-label,
.grand-total .total-amount {
    font-size: 18px;
    color: #e74c3c;
    font-weight: 800;
}

.security-info {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
}

.security-item {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
    color: #00b894;
    font-size: 14px;
    font-weight: 600;
}

.security-item:last-child {
    margin-bottom: 0;
}

.security-item i {
    font-size: 16px;
}

@media (max-width: 991px) {
    .order-summary-sidebar {
        position: static;
        margin-top: 30px;
    }
    
    .payment-form {
        padding: 25px;
    }
    
    .payment-header {
        padding: 30px 20px;
    }
}
</style>

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe('{{ config("services.stripe.public_key") }}');
    const elements = stripe.elements();

    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#424770',
                '::placeholder': {
                    color: '#aab7c4',
                },
            },
            invalid: {
                color: '#9e2146',
            },
        },
    });

    cardElement.mount('#card-element');

    // Handle real-time validation errors from the card Element
    cardElement.on('change', ({error}) => {
        const displayError = document.getElementById('card-errors');
        if (error) {
            displayError.textContent = error.message;
        } else {
            displayError.textContent = '';
        }
    });

    // Handle form submission
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-payment');
    const buttonText = document.getElementById('button-text');
    const spinner = document.getElementById('spinner');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();

        // Disable submit button and show loading
        submitButton.disabled = true;
        buttonText.style.display = 'none';
        spinner.classList.remove('hidden');

        try {
            // Create payment intent
            const response = await fetch(`{{ route('order.payment.stripe.create', $order->id) }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            });

            const { clientSecret } = await response.json();

            // Confirm payment with card element
            const {error} = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        name: '{{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}',
                        email: '{{ $order->billingAddress->email }}',
                        phone: '{{ $order->billingAddress->phone_number }}',
                        address: {
                            line1: '{{ $order->billingAddress->street_address }}',
                            city: '{{ $order->billingAddress->city }}',
                            state: '{{ $order->billingAddress->state }}',
                            country: '{{ $order->billingAddress->country }}',
                            postal_code: '{{ $order->billingAddress->postal_code }}',
                        }
                    }
                }
            });

            if (error) {
                // Show error to customer
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                
                // Reset button state
                submitButton.disabled = false;
                buttonText.style.display = 'flex';
                spinner.classList.add('hidden');
            } else {
                // Payment successful, redirect to confirmation
                window.location.href = `{{ route('order.payment.stripe.return', $order->id) }}?payment_intent=${clientSecret.split('_secret_')[0]}`;
            }
        } catch (error) {
            console.error('Error:', error);
            document.getElementById('card-errors').textContent = 'An error occurred. Please try again.';
            
            // Reset button state
            submitButton.disabled = false;
            buttonText.style.display = 'flex';
            spinner.classList.add('hidden');
        }
    });
});
</script>
@endpush
@endsection