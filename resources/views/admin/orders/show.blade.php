@extends('admin.layouts.master', ['is_active_parent' => 'orders', 'is_active' => 'orders'])
@section('title', 'Order Details')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">
                <i class="fas fa-shopping-cart me-2 text-primary"></i>Order Details #{{ $order->id }}
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
                    <li class="breadcrumb-item active">Order Details</li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Orders
        </a>
    </div>

    <!-- Alerts -->
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <!-- Order Information -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h4 class="mb-0">
                                <i class="fas fa-info-circle me-2"></i>Order Information
                            </h4>
                        </div>
                        <div class="col-md-6 text-end">
                            @if($order->order_status == 'pending')
                                <span class="badge bg-warning fs-6 me-2">Pending</span>
                            @elseif($order->order_status == 'processing')
                                <span class="badge bg-info fs-6 me-2">Processing</span>
                            @elseif($order->order_status == 'shipped')
                                <span class="badge bg-primary fs-6 me-2">Shipped</span>
                            @elseif($order->order_status == 'delivered')
                                <span class="badge bg-success fs-6 me-2">Delivered</span>
                            @else
                                <span class="badge bg-secondary fs-6 me-2">{{ ucfirst($order->order_status) }}</span>
                            @endif

                            @if($order->payment_status == 'pending')
                                <span class="badge bg-warning fs-6">Payment Pending</span>
                            @elseif($order->payment_status == 'paid')
                                <span class="badge bg-success fs-6">Paid</span>
                            @elseif($order->payment_status == 'failed')
                                <span class="badge bg-danger fs-6">Payment Failed</span>
                            @else
                                <span class="badge bg-secondary fs-6">{{ ucfirst($order->payment_status) }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <strong>Order Date:</strong><br>
                            {{ $order->created_at->format('d M Y') }}<br>
                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                        </div>
                        <div class="col-md-3">
                            <strong>Total Amount:</strong><br>
                            <span class="h5 text-success">${{ number_format($order->total_amount, 2) }}</span>
                        </div>
                        <div class="col-md-3">
                            <strong>Payment Method:</strong><br>
                            {{ ucfirst($order->payment_method) }}
                        </div>
                        <div class="col-md-3">
                            <strong>Currency:</strong><br>
                            {{ strtoupper($order->currency) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Order Items
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->product && $item->product->image)
                                            <img src="{{ asset($item->product->image) }}" 
                                                 alt="{{ $item->product_name }}" 
                                                 class="rounded me-3"
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                            <div class="bg-light border rounded d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $item->product_name }}</h6>
                                                @if($item->product)
                                                <small class="text-muted">Product ID: {{ $item->product->id }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="fw-bold">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-primary">
                                    <th colspan="3">Total Amount</th>
                                    <th class="h5">${{ number_format($order->total_amount, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            @if($order->notes)
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-comment me-2"></i>Order Notes
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Customer Information -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>Customer Information
                    </h5>
                </div>
                <div class="card-body">
                    @if($order->user)
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                             style="width: 40px; height: 40px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $order->user->name }}</h6>
                            <small class="text-muted">Registered Customer</small>
                        </div>
                    </div>
                    <p class="mb-2"><strong>Email:</strong> {{ $order->user->email }}</p>
                    <p class="mb-0"><strong>Joined:</strong> {{ $order->user->created_at->format('d M Y') }}</p>
                    @else
                    <div class="text-muted">
                        <i class="fas fa-user-times me-2"></i>Guest Customer
                    </div>
                    @endif
                </div>
            </div>

            <!-- Billing Address -->
            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Billing Address
                    </h5>
                </div>
                <div class="card-body">
                    <address class="mb-0">
                        <strong>{{ $order->billingAddress->first_name }} {{ $order->billingAddress->last_name }}</strong><br>
                        {{ $order->billingAddress->street_address }}<br>
                        {{ $order->billingAddress->city }}, {{ $order->billingAddress->state }}<br>
                        {{ $order->billingAddress->country }} {{ $order->billingAddress->postal_code }}<br><br>
                        <i class="fas fa-phone me-1"></i> {{ $order->billingAddress->phone_number }}<br>
                        <i class="fas fa-envelope me-1"></i> {{ $order->billingAddress->email }}
                    </address>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
@media print {
    .btn, .card-header, .breadcrumb, .modal {
        display: none !important;
    }
    
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endpush 