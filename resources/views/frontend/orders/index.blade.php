@extends('frontend.layout')

@section('content')
<!-- Start Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">{{ __('checkout.my_orders') }}</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('app.home') }}</a></li>
                    <li>{{ __('checkout.my_orders') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Orders -->
<section class="orders-section section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                @if($orders->count() > 0)
                    @foreach($orders as $order)
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="mb-0">
                                        <i class="lni lni-shopping-basket"></i>
                                        {{ __('checkout.order_details') }}
                                    </h5>
                                    <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : 'primary' }}">
                                        {{ __('checkout.' . $order->order_status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p><strong>{{ __('checkout.total_amount') }}:</strong> ${{ number_format($order->total_amount, 2) }}</p>
                                    <p><strong>{{ __('checkout.payment_status') }}:</strong> 
                                        <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                            {{ __('checkout.' . $order->payment_status) }}
                                        </span>
                                    </p>
                                    <p><strong>{{ __('checkout.items_count') }}:</strong> {{ $order->items->sum('quantity') }} {{ __('checkout.items') }}</p>
                                </div>
                                <div class="col-md-4 text-md-end">
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">
                                        <i class="lni lni-eye"></i> {{ __('checkout.view_order') }}
                                    </a>
                                    @if($order->payment_status == 'pending')
                                    <a href="{{ route('order.payment.create', $order->id) }}" class="btn btn-success mt-2">
                                        <i class="lni lni-credit-cards"></i> {{ __('checkout.complete_payment') }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="lni lni-shopping-basket" style="font-size: 64px; color: #ccc;"></i>
                        <h4 class="mt-3">{{ __('checkout.no_orders_found') }}</h4>
                        <p class="text-muted">{{ __('checkout.no_orders_message') }}</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="lni lni-shopping-bag"></i> {{ __('checkout.start_shopping') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!-- End Orders -->
@endsection

@push('style')
<style>
.orders-section {
    padding: 50px 0;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

@media (max-width: 768px) {
    .text-md-end {
        text-align: left !important;
        margin-top: 15px;
    }
}
</style>
@endpush 