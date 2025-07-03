@extends('frontend.layout')

@section('title', __('checkout.complete_order'))

@section('content')
<!-- Start Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">{{ __('checkout.checkout') }}</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('app.home') }}</a></li>
                    <li><a href="{{ route('cart.index') }}">{{ __('app.cart') }}</a></li>
                    <li>{{ __('checkout.checkout') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Checkout Area -->
<section class="checkout-wrapper section">
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

                <div class="checkout-steps-form-style-1">
                    <div class="checkout-form-area">
                        <form action="{{ route('order.store') }}" method="POST" class="row" id="checkout-form">
                            @csrf
                            
                            <!-- Billing Information -->
                            <div class="col-12">
                                <div class="single-form">
                                    <h2><i class="lni lni-user"></i> {{ __('checkout.billing_information') }}</h2>
                                    <p>{{ __('checkout.please_fill_all_fields') }}</p>
                                    
                                    <div class="row">
                                        <!-- First Name -->
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="billing_first_name">{{ __('checkout.first_name') }} <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                    id="billing_first_name" 
                                                    name="billing_first_name" 
                                                    class="form-control @error('billing_first_name') is-invalid @enderror"
                                                    value="{{ old('billing_first_name', Auth::user()->first_name ?? '') }}"
                                                    placeholder="{{ __('checkout.enter_first_name') }}"
                                                    required>
                                                @error('billing_first_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Last Name -->
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="billing_last_name">{{ __('checkout.last_name') }} <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                    id="billing_last_name" 
                                                    name="billing_last_name" 
                                                    class="form-control @error('billing_last_name') is-invalid @enderror"
                                                    value="{{ old('billing_last_name', Auth::user()->last_name ?? '') }}"
                                                    placeholder="{{ __('checkout.enter_last_name') }}"
                                                    required>
                                                @error('billing_last_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Email -->
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="billing_email">{{ __('checkout.email') }} <span class="text-danger">*</span></label>
                                                <input type="email" 
                                                    id="billing_email" 
                                                    name="billing_email" 
                                                    class="form-control @error('billing_email') is-invalid @enderror"
                                                    value="{{ old('billing_email', Auth::user()->email ?? '') }}"
                                                    required>
                                                @error('billing_email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Phone -->
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="billing_phone">{{ __('checkout.phone') }} <span class="text-danger">*</span></label>
                                                <input type="tel" 
                                                    id="billing_phone" 
                                                    name="billing_phone" 
                                                    class="form-control @error('billing_phone') is-invalid @enderror"
                                                    value="{{ old('billing_phone', Auth::user()->phone_number ?? '') }}"
                                                    required>
                                                @error('billing_phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Street Address -->
                                        <div class="col-12">
                                            <div class="single-form">
                                                <label for="billing_street_address">{{ __('checkout.street_address') }} <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                    id="billing_street_address" 
                                                    name="billing_street_address" 
                                                    class="form-control @error('billing_street_address') is-invalid @enderror"
                                                    value="{{ old('billing_street_address') }}"
                                                    placeholder="{{ __('checkout.street_address_placeholder') }}"
                                                    required>
                                                @error('billing_street_address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- City -->
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="billing_city">{{ __('checkout.city') }} <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                    id="billing_city" 
                                                    name="billing_city" 
                                                    class="form-control @error('billing_city') is-invalid @enderror"
                                                    value="{{ old('billing_city') }}"
                                                    placeholder="{{ __('checkout.city_placeholder') }}"
                                                    required>
                                                @error('billing_city')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- State -->
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="billing_state">{{ __('checkout.state') }}</label>
                                                <input type="text" 
                                                    id="billing_state" 
                                                    name="billing_state" 
                                                    class="form-control @error('billing_state') is-invalid @enderror"
                                                    value="{{ old('billing_state') }}"
                                                    placeholder="{{ __('checkout.state_placeholder') }}">
                                                @error('billing_state')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Country -->
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="billing_country">{{ __('checkout.country') }} <span class="text-danger">*</span></label>
                                                <select id="billing_country" 
                                                    name="billing_country" 
                                                    class="form-control @error('billing_country') is-invalid @enderror"
                                                    required>
                                                    <option value="">{{ __('checkout.select_country') }}</option>
                                                    <option value="SA" {{ old('billing_country', 'SA') == 'SA' ? 'selected' : '' }}>{{ __('checkout.saudi_arabia') }}</option>
                                                    <option value="AE" {{ old('billing_country') == 'AE' ? 'selected' : '' }}>{{ __('checkout.uae') }}</option>
                                                    <option value="KW" {{ old('billing_country') == 'KW' ? 'selected' : '' }}>{{ __('checkout.kuwait') }}</option>
                                                    <option value="QA" {{ old('billing_country') == 'QA' ? 'selected' : '' }}>{{ __('checkout.qatar') }}</option>
                                                    <option value="BH" {{ old('billing_country') == 'BH' ? 'selected' : '' }}>{{ __('checkout.bahrain') }}</option>
                                                    <option value="OM" {{ old('billing_country') == 'OM' ? 'selected' : '' }}>{{ __('checkout.oman') }}</option>
                                                    <option value="JO" {{ old('billing_country') == 'JO' ? 'selected' : '' }}>{{ __('checkout.jordan') }}</option>
                                                    <option value="LB" {{ old('billing_country') == 'LB' ? 'selected' : '' }}>{{ __('checkout.lebanon') }}</option>
                                                    <option value="EG" {{ old('billing_country') == 'EG' ? 'selected' : '' }}>{{ __('checkout.egypt') }}</option>
                                                </select>
                                                @error('billing_country')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <!-- Postal Code -->
                                        <div class="col-md-6">
                                            <div class="single-form">
                                                <label for="billing_postal_code">{{ __('checkout.postal_code') }}</label>
                                                <input type="text" 
                                                    id="billing_postal_code" 
                                                    name="billing_postal_code" 
                                                    class="form-control @error('billing_postal_code') is-invalid @enderror"
                                                    value="{{ old('billing_postal_code') }}"
                                                    placeholder="{{ __('checkout.postal_code_placeholder') }}">
                                                @error('billing_postal_code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Notes -->
                            <div class="col-12">
                                <div class="single-form">
                                    <label for="notes">{{ __('checkout.order_notes') }}</label>
                                    <textarea 
                                        id="notes" 
                                        name="notes" 
                                        class="form-control @error('notes') is-invalid @enderror"
                                        rows="3"
                                        placeholder="{{ __('checkout.order_notes_placeholder') }}">{{ old('notes') }}</textarea>
                                    @error('notes')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <div class="checkout-sidebar">
                    <div class="checkout-sidebar-header">
                        <h3><i class="lni lni-cart"></i> {{ __('checkout.order_summary') }}</h3>
                    </div>
                    
                    <div class="checkout-sidebar-body">
                        <!-- Cart Items -->
                        <div class="cart-items-list">
                            @foreach($cartItems as $item)
                                <div class="cart-single-item">
                                    <div class="item-image">
                                        @if($item->product->image)
                                            <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}">
                                        @else
                                            <div class="no-image">📦</div>
                                        @endif
                                    </div>
                                    <div class="item-content">
                                        <div class="item-name">{{ $item->product->name }}</div>
                                        <div class="item-details">
                                            <span>{{ __('checkout.quantity') }}: {{ $item->quantity }}</span>
                                            <span>{{ number_format($item->product->price, 2) }} {{ __('app.currency') }}</span>
                                        </div>
                                    </div>
                                    <div class="item-total">
                                        <span class="total-price">{{ number_format($item->quantity * $item->product->price, 2) }} {{ __('app.currency') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Order Totals -->
                        <div class="order-totals">
                            <div class="total-line">
                                <span class="total-label">{{ __('checkout.subtotal') }}:</span>
                                <span class="total-amount">{{ number_format($total, 2) }} {{ __('app.currency') }}</span>
                            </div>
                            <div class="total-line">
                                <span class="total-label">{{ __('checkout.shipping') }}:</span>
                                <span class="total-amount">{{ __('checkout.free') }}</span>
                            </div>
                            <div class="total-line">
                                <span class="total-label">{{ __('checkout.tax') }}:</span>
                                <span class="total-amount">{{ __('checkout.included') }}</span>
                            </div>
                            <div class="total-line grand-total">
                                <span class="total-label">{{ __('checkout.total') }}:</span>
                                <span class="total-amount">{{ number_format($total, 2) }} {{ __('app.currency') }}</span>
                            </div>
                        </div>

                        <!-- Checkout Action -->
                        <div class="checkout-action">
                            <button type="submit" class="btn primary-btn">
                                <i class="lni lni-checkmark-circle"></i>
                                {{ __('checkout.confirm_order') }} - {{ number_format($total, 2) }} {{ __('app.currency') }}
                            </button>
                            <p class="checkout-note">
                                <i class="lni lni-lock-alt"></i>
                                {{ __('checkout.secure_encrypted') }}
                            </p>
                        </div>
                    </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Checkout Area -->

<style>
/* Enhanced Checkout Styles */
.checkout-wrapper {
    padding: 60px 0;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.checkout-form-area {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.single-form h2 {
    color: #2c3e50;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.single-form h2 i {
    color: #3498db;
    font-size: 24px;
}

.single-form > p {
    color: #7f8c8d;
    margin-bottom: 25px;
    font-size: 14px;
}

.single-form label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    display: block;
    font-size: 14px;
}

.single-form .form-control {
    height: 50px;
    border: 2px solid #e8ecef;
    border-radius: 12px;
    padding: 0 20px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.single-form .form-control:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    background: white;
}

.single-form textarea.form-control {
    height: auto;
    padding: 15px 20px;
    resize: vertical;
}

/* Enhanced Checkout Sidebar */
.checkout-sidebar {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    position: sticky;
    top: 100px;
}

.checkout-sidebar-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 25px 30px;
}

.checkout-sidebar-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 10px;
}

.checkout-sidebar-body {
    padding: 30px;
}

/* Enhanced Cart Items */
.cart-items-list {
    margin-bottom: 30px;
}

.cart-single-item {
    display: flex;
    align-items: center;
    padding: 20px 0;
    border-bottom: 1px solid #eee;
}

.cart-single-item:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.item-image {
    width: 70px;
    height: 70px;
    border-radius: 12px;
    overflow: hidden;
    margin-right: 15px;
    flex-shrink: 0;
}

.item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #adb5bd;
    font-size: 24px;
}

.item-content {
    flex: 1;
    min-width: 0;
}

.item-name {
    font-size: 14px;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 8px;
    line-height: 1.3;
}

.item-details {
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    color: #7f8c8d;
}

.item-total {
    margin-left: 15px;
    text-align: right;
}

.total-price {
    font-weight: 700;
    color: #e74c3c;
    font-size: 15px;
}

/* Enhanced Order Totals */
.order-totals {
    border-top: 2px solid #eee;
    padding-top: 25px;
    margin-bottom: 30px;
}

.total-line {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.total-line:last-child {
    margin-bottom: 0;
}

.total-label {
    color: #7f8c8d;
    font-size: 14px;
    font-weight: 600;
}

.total-amount {
    font-weight: 700;
    color: #2c3e50;
    font-size: 14px;
}

.grand-total {
    border-top: 2px solid #eee;
    padding-top: 20px;
    margin-top: 20px;
}

.grand-total .total-label,
.grand-total .total-amount {
    font-size: 18px;
    font-weight: 800;
    color: #e74c3c;
}

/* Enhanced Checkout Action */
.checkout-action .btn {
    height: 60px;
    font-size: 16px;
    font-weight: 700;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: linear-gradient(135deg, #00b894 0%, #00a085 100%);
    border: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.checkout-action .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 30px rgba(0, 184, 148, 0.3);
}

.checkout-note {
    text-align: center;
    margin-top: 15px;
    color: #7f8c8d;
    font-size: 12px;
    margin-bottom: 0;
    font-weight: 600;
}

.checkout-note i {
    color: #00b894;
    margin-right: 5px;
}

/* Responsive Design */
@media (max-width: 991px) {
    .checkout-sidebar {
        position: static;
        margin-top: 30px;
    }
    
    .checkout-form-area {
        padding: 25px;
    }
    
    .checkout-sidebar-body {
        padding: 20px;
    }
}

@media (max-width: 768px) {
    .cart-single-item {
        flex-direction: column;
        text-align: center;
        padding: 15px 0;
    }
    
    .item-image {
        margin-right: 0;
        margin-bottom: 10px;
    }
    
    .item-total {
        margin-left: 0;
        margin-top: 10px;
    }
}
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.getElementById('checkout-form');
    const submitButton = document.querySelector('.btn.primary-btn');
    
    // Handle form submission
    checkoutForm.addEventListener('submit', function(e) {
        // Direct form submission since no payment method selection
        // Form will submit normally to OrderController@store
    });
    
    function showToast(message, type) {
        // Remove existing toasts
        document.querySelectorAll('.checkout-toast').forEach(toast => toast.remove());
        
        const toastClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const icon = type === 'success' ? '✓' : '✗';
        
        const toast = document.createElement('div');
        toast.className = `alert ${toastClass} alert-dismissible fade show checkout-toast`;
        toast.style.cssText = `
            position: fixed; 
            top: 20px; 
            right: 20px; 
            z-index: 9999; 
            min-width: 300px;
            max-width: 400px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            border: none;
            border-radius: 8px;
        `;
        
        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <span class="me-2" style="font-size: 1.2em;">${icon}</span>
                <span class="flex-grow-1">${message}</span>
                <button type="button" class="btn-close" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.style.opacity = '0';
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (toast.parentNode) {
                        toast.parentNode.removeChild(toast);
                    }
                }, 300);
            }
        }, 5000);
    }
});
</script>
@endpush
@endsection 