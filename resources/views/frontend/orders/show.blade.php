@extends('frontend.layout')

@section('content')
<!-- Start Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">{{ __('checkout.order_details') }}</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('app.home') }}</a></li>
                    <li><a href="{{ route('orders.index') }}">{{ __('checkout.my_orders') }}</a></li>
                    <li>{{ __('checkout.order_details') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Order Details -->
<section class="order-details section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                
                <!-- Order Header -->
                <div class="order-header mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="mb-0">
                                        <i class="lni lni-shopping-basket"></i> 
                                        {{ __('checkout.order_details') }}
                                    </h4>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="badge badge-lg bg-light text-dark">
                                        {{ __('checkout.' . $order->order_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <strong>{{ __('checkout.order_date') }}:</strong><br>
                                    {{ $order->created_at->format('M d, Y') }}<br>
                                    <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                </div>
                                <div class="col-md-3">
                                    <strong>{{ __('checkout.total_amount') }}:</strong><br>
                                    <span class="h5 text-success">${{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                <div class="col-md-3">
                                    <strong>{{ __('checkout.payment_method') }}:</strong><br>
                                    {{ ucfirst($order->payment_method) }}
                                </div>
                                <div class="col-md-3">
                                    <strong>{{ __('checkout.payment_status') }}:</strong><br>
                                    <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                        {{ __('checkout.' . $order->payment_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Order Items -->
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="lni lni-package"></i> {{ __('checkout.order_items') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
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
                                                <td>
                                                    <div class="product-info">
                                                        @if($item->product && $item->product->image)
                                                        <img src="{{ $item->product->image_url }}" 
                                                             alt="{{ $item->product_name }}" 
                                                             class="product-thumb me-3"
                                                             onerror="this.style.display='none'">
                                                        @else
                                                        <div class="product-placeholder me-3">
                                                            <i class="lni lni-image"></i>
                                                        </div>
                                                        @endif
                                                        <div>
                                                            <h6 class="mb-0">{{ $item->product_name }}</h6>
                                                            @if($item->product && $item->product->slug)
                                                            <small class="text-muted">
                                                                <a href="{{ route('product.show', $item->product->slug) }}" target="_blank">
                                                                    {{ __('checkout.view_product') }}
                                                                </a>
                                                            </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>${{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr class="table-active">
                                                <th colspan="3">{{ __('checkout.total_amount') }}</th>
                                                <th>${{ number_format($order->total_amount, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Order Notes -->
                        @if($order->notes)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="lni lni-comments"></i> {{ __('checkout.order_notes') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <p class="mb-0">{{ $order->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Order Info Sidebar -->
                    <div class="col-lg-4">
                        <!-- Billing Address -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">
                                    <i class="lni lni-map-marker"></i> {{ __('checkout.billing_address') }}
                                </h5>
                            </div>
                            <div class="card-body">
                                <address>
                                    <strong>{{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}</strong><br>
                                    {{ $order->billingAddress->street_address }}<br>
                                    {{ $order->billingAddress->city }}, {{ $order->billingAddress->state }}<br>
                                    {{ $order->billingAddress->country }} {{ $order->billingAddress->postal_code }}<br><br>
                                    <i class="lni lni-phone"></i> {{ $order->billingAddress->phone_number }}<br>
                                    <i class="lni lni-envelope"></i> {{ $order->billingAddress->email }}
                                </address>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Order Details -->
@endsection

@push('style')
<style>
.order-details {
    padding: 50px 0;
}

.order-header .badge-lg {
    font-size: 0.9rem;
    padding: 0.5rem 1rem;
}

.product-info {
    display: flex;
    align-items: center;
}

.product-thumb {
    width: 60px;
    height: 60px;
    object-fit: cover;
    border-radius: 8px;
    border: 2px solid #f1f2f6;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.product-placeholder {
    width: 60px;
    height: 60px;
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 24px;
}

address {
    line-height: 1.6;
    margin-bottom: 0;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

@media print {
    .breadcrumbs,
    .navbar,
    .footer {
        display: none !important;
    }
}

@media (max-width: 768px) {
    .product-info {
        flex-direction: column;
        text-align: center;
        gap: 10px;
    }
    
    .product-thumb,
    .product-placeholder {
        margin: 0 auto 10px auto;
    }
    
    .table-responsive {
        font-size: 14px;
    }
}
</style>
@endpush
