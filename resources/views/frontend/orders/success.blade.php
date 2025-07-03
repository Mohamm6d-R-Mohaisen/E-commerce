@extends('frontend.layout')

@section('title', __('checkout.order_success'))

@section('content')
<!-- Start Order Success -->
<section class="order-success-wrapper section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="order-success-content">
                    <!-- Success Header -->
                    <div class="success-header">
                        <div class="success-icon">
                            <i class="lni lni-checkmark-circle"></i>
                        </div>
                        <h1>{{ __('checkout.order_placed_successfully') }}</h1>
                        <p>{{ __('checkout.thank_you_for_order') }}</p>
                    </div>

                    <!-- Order Details -->
                    <div class="order-details-card">
                        <div class="card-header">
                            <h3><i class="lni lni-package"></i> {{ __('checkout.order_details') }}</h3>
                        </div>
                        
                        <div class="card-body">
                            <!-- Order Items -->
                            <div class="order-items">
                                <h4>{{ __('checkout.ordered_items') }}</h4>
                                <div class="items-list">
                                    @foreach($order->items as $item)
                                        <div class="order-item">
                                            @if($item->product && $item->product->image)
                                            <img src="{{ $item->product->image_url }}" 
                                                 alt="{{ $item->product_name }}" 
                                                 class="order-item-image"
                                                 onerror="this.style.display='none'">
                                            @else
                                            <div class="order-item-placeholder">
                                                <i class="lni lni-image"></i>
                                            </div>
                                            @endif
                                            <div class="item-details">
                                                <h5>{{ $item->product_name }}</h5>
                                                <p>{{ __('checkout.quantity') }}: {{ $item->quantity }} × {{ number_format($item->price, 2) }} {{ __('app.currency') }}</p>
                                                @if($item->product && $item->product->slug)
                                                <small>
                                                    <a href="{{ route('product.show', $item->product->slug) }}" target="_blank">
                                                        {{ __('checkout.view_product') }}
                                                    </a>
                                                </small>
                                                @endif
                                            </div>
                                            <div class="item-total">
                                                <span>{{ number_format($item->quantity * $item->price, 2) }} {{ __('app.currency') }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <div class="order-total">
                                    <div class="total-row">
                                        <span>{{ __('checkout.total') }}:</span>
                                        <span class="total-amount">{{ number_format($order->total_amount, 2) }} {{ __('app.currency') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Billing Address -->
                            <div class="billing-address">
                                <h4>{{ __('checkout.billing_address') }}</h4>
                                <div class="address-details">
                                    <p><strong>{{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}</strong></p>
                                    <p>{{ $order->billingAddress->email }}</p>
                                    <p>{{ $order->billingAddress->phone_number }}</p>
                                    <p>{{ $order->billingAddress->city }}@if($order->billingAddress->postal_code), {{ $order->billingAddress->postal_code }}@endif</p>
                                    @if($order->billingAddress->street_address)
                                        <p>{{ $order->billingAddress->street_address }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Order Status -->
                            <div class="order-status">
                                <h4>{{ __('checkout.order_status') }}</h4>
                                <div class="status-info">
                                    <div class="status-item">
                                        <span class="status-label">{{ __('checkout.payment_method') }}:</span>
                                        <span class="status-value">{{ ucfirst($order->payment_method) }}</span>
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">{{ __('checkout.payment_status') }}:</span>
                                        <span class="status-value status-{{ $order->payment_status }}">{{ __('checkout.' . $order->payment_status) }}</span>
                                    </div>
                                    <div class="status-item">
                                        <span class="status-label">{{ __('checkout.order_status') }}:</span>
                                        <span class="status-value status-{{ $order->order_status }}">{{ __('checkout.' . $order->order_status) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="order-actions">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="lni lni-home"></i>
                            {{ __('checkout.continue_shopping') }}
                        </a>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary">
                            <i class="lni lni-eye"></i>
                            {{ __('checkout.view_order') }}
                        </a>
                        <button onclick="window.print()" class="btn btn-outline-secondary">
                            <i class="lni lni-printer"></i>
                            {{ __('checkout.print_order') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Order Success -->

<style>
/* Order Success Styles */
.order-success-wrapper {
    padding: 60px 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
}

.order-success-content {
    background: white;
    border-radius: 25px;
    overflow: hidden;
    box-shadow: 0 30px 60px rgba(0,0,0,0.2);
}

/* Success Header */
.success-header {
    background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
    color: white;
    padding: 50px 40px;
    text-align: center;
}

.success-icon {
    font-size: 80px;
    margin-bottom: 20px;
    animation: checkmarkPulse 2s ease-in-out infinite;
}

@keyframes checkmarkPulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.success-header h1 {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 15px;
    color: white;
}

.success-header p {
    font-size: 16px;
    margin-bottom: 25px;
    opacity: 0.9;
}



/* Order Details Card */
.order-details-card {
    margin: 0;
}

.card-header {
    background: #f8f9fa;
    padding: 25px 40px;
    border-bottom: 2px solid #eee;
}

.card-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-header i {
    color: #3498db;
    font-size: 24px;
}

.card-body {
    padding: 40px;
}

/* Order Items */
.order-items,
.billing-address,
.order-status {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
}

.order-items:last-child,
.billing-address:last-child,
.order-status:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.order-items h4,
.billing-address h4,
.order-status h4 {
    font-size: 18px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.order-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 20px 0;
    border-bottom: 1px solid #f1f2f6;
}

.order-item-image {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #f1f2f6;
    flex-shrink: 0;
}

.order-item-placeholder {
    width: 50px;
    height: 50px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 20px;
    flex-shrink: 0;
}

.order-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.item-details {
    flex: 1;
}

.item-details h5 {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 5px;
}

.item-details p {
    color: #7f8c8d;
    margin: 0 0 5px 0;
    font-size: 14px;
}

.item-details small a {
    color: #3498db;
    text-decoration: none;
    font-size: 12px;
}

.item-details small a:hover {
    text-decoration: underline;
}

.item-total {
    font-size: 16px;
    font-weight: 700;
    color: #e74c3c;
    flex-shrink: 0;
}

.order-total {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 12px;
    margin-top: 20px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.total-row span:first-child {
    font-size: 18px;
    font-weight: 600;
    color: #2c3e50;
}

.total-amount {
    font-size: 22px;
    font-weight: 800;
    color: #e74c3c;
}

/* Address Details */
.address-details p {
    margin-bottom: 8px;
    color: #2c3e50;
    font-size: 14px;
}

.address-details p:last-child {
    margin-bottom: 0;
}

/* Order Status */
.status-info {
    display: grid;
    gap: 15px;
}

.status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px 20px;
    background: #f8f9fa;
    border-radius: 10px;
}

.status-label {
    font-weight: 600;
    color: #2c3e50;
}

.status-value {
    font-weight: 700;
    text-transform: capitalize;
}

.status-pending {
    color: #f39c12;
}

.status-paid {
    color: #27ae60;
}

.status-processing {
    color: #3498db;
}

.status-shipped {
    color: #9b59b6;
}

.status-delivered {
    color: #27ae60;
}

.status-cancelled {
    color: #e74c3c;
}

/* Action Buttons */
.order-actions {
    padding: 30px 40px;
    background: #f8f9fa;
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
    justify-content: center;
}

.order-actions .btn {
    height: 50px;
    padding: 0 25px;
    border-radius: 12px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.order-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.order-actions .btn-primary {
    background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    border: none;
}

.order-actions .btn-outline-primary {
    border: 2px solid #3498db;
    color: #3498db;
    background: transparent;
}

.order-actions .btn-outline-primary:hover {
    background: #3498db;
    color: white;
}

.order-actions .btn-outline-secondary {
    border: 2px solid #95a5a6;
    color: #95a5a6;
    background: transparent;
}

.order-actions .btn-outline-secondary:hover {
    background: #95a5a6;
    color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
    .success-header {
        padding: 40px 25px;
    }
    
    .success-header h1 {
        font-size: 24px;
    }
    
    .success-icon {
        font-size: 60px;
    }
    
    .card-body {
        padding: 25px;
    }
    
    .order-actions {
        padding: 25px;
        flex-direction: column;
    }
    
    .order-item {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .order-item-image,
    .order-item-placeholder {
        margin: 0 auto;
    }
    
    .status-item {
        flex-direction: column;
        gap: 5px;
        text-align: center;
    }
}

/* Print Styles */
@media print {
    .order-actions {
        display: none;
    }
    
    .order-success-wrapper {
        background: white;
        padding: 0;
    }
    
    .order-success-content {
        box-shadow: none;
        border-radius: 0;
    }
    
    .success-header {
        background: white;
        color: black;
    }
}
</style>
@endsection