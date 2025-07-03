@extends('frontend.layout')

@section('title', __('app.shopping_cart'))

@section('content')
<div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">{{ __('app.shopping_cart') }}</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('app.home') }}</a></li>
                    <li>{{ __('app.shopping_cart') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="shopping-cart section">
    <div class="container">
        <div class="cart-list-head">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($cartItems->count() > 0)
                <div class="cart-list-title">
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-12"></div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <p>{{ __('app.product') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('app.quantity') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('app.price') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ __('app.total') }}</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <p>{{ __('app.delete') }}</p>
                        </div>
                    </div>
                </div>

                @foreach($cartItems as $item)
                <div class="cart-single-list" data-product-id="{{ $item->product_id }}">
                    <div class="row align-items-center">
                        <div class="col-lg-1 col-md-1 col-12">
                            <a href="javascript:void(0)">
                                @if($item->product->image)
                                    <img src="{{ asset($item->product->image) }}" alt="{{ $item->product->name }}">
                                @else
                                    <div class="no-image">📦</div>
                                @endif
                            </a>
                        </div>
                        <div class="col-lg-4 col-md-3 col-12">
                            <h5 class="product-name"><a href="#">{{ $item->product->name }}</a></h5>
                            <p class="product-des">
                                <span><em>{{ $item->product->category->name ?? __('app.category') }}</em></span>
                            </p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <div class="count-input big-count-input" id="quantity-section-{{ $item->product_id }}">
                                <div class="input-group bootstrap-touchspin">
                                    <span class="input-group-btn">
                                        <button class="btn bootstrap-touchspin-down quantity-btn" type="button" 
                                                data-product-id="{{ $item->product_id }}" 
                                                data-action="decrease">-</button>
                                    </span>
                                    <input type="number" class="form-control quantity-input" 
                                           value="{{ $item->quantity }}" 
                                           min="1" 
                                           max="10"
                                           data-product-id="{{ $item->product_id }}"
                                           readonly>
                                    <span class="input-group-btn">
                                        <button class="btn bootstrap-touchspin-up quantity-btn" type="button" 
                                                data-product-id="{{ $item->product_id }}" 
                                                data-action="increase">+</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p>{{ number_format($item->product->price, 2) }} {{ __('app.currency') }}</p>
                        </div>
                        <div class="col-lg-2 col-md-2 col-12">
                            <p class="item-total">{{ number_format($item->quantity * $item->product->price, 2) }} {{ __('app.currency') }}</p>
                        </div>
                        <div class="col-lg-1 col-md-2 col-12">
                            <button class="remove-item" data-product-id="{{ $item->product_id }}">
                                <i class="lni lni-close"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
                
                <div class="row">
                    <div class="col-12">
                        <div class="total-amount">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-12">
                                    <div class="left">
                                        <div class="coupon">
                                            <form action="#" target="_blank">
                                                <input name="Coupon" placeholder="{{ __('Enter discount code') }}">
                                                <div class="button">
                                                    <button class="btn">{{ __('app.apply') }}</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-12">
                                    <div class="right">
                                        <ul>
                                            <li>{{ __('app.subtotal') }}<span id="cart-subtotal">{{ number_format($total, 2) }} {{ __('app.currency') }}</span></li>
                                            <li>{{ __('app.shipping') }}<span>{{ __('app.free') }}</span></li>
                                            <li class="last">{{ __('app.total') }}<span id="cart-total">{{ number_format($total, 2) }} {{ __('app.currency') }}</span></li>
                                        </ul>
                                        <div class="button">
                                            <a href="{{ route('checkout') }}" class="btn">{{ __('app.checkout') }}</a>
                                            <a href="{{ route('home') }}" class="btn btn-alt">{{ __('app.continue_shopping') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="button text-center">
                            <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('auth.cart_clear_confirmation') }}')">
                                    <i class="lni lni-trash"></i>
                                    {{ __('app.clear_cart') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <div class="empty-cart text-center">
                    <div class="empty-cart-icon">
                        <i class="lni lni-cart" style="font-size: 100px; color: #ccc;"></i>
                    </div>
                    <h3>{{ __('app.cart_is_empty') }}</h3>
                    <p>{{ __('app.no_products_in_cart') }}</p>
                    <div class="button">
                        <a href="{{ route('home') }}" class="btn">{{ __('app.start_shopping') }}</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
// Translation variables for JavaScript
const translations = {
    cartClearConfirmation: '{{ __("auth.cart_clear_confirmation") }}',
    cartUpdateError: '{{ __("auth.cart_update_error") }}',
    cartRemoveError: '{{ __("auth.cart_remove_error") }}',
    cartClearError: '{{ __("auth.cart_clear_error") }}',
    currency: '{{ __("app.currency") }}',
    confirmDelete: '{{ __("auth.confirm_delete_product") }}',
    updating: '{{ __("auth.updating") }}',
    removing: '{{ __("auth.removing") }}',
    quantityRangeError: '{{ __("auth.quantity_range_error") }}'
};

// Base URLs for AJAX calls
const cartUpdateUrl = '{{ url("cart") }}';
const cartDestroyUrl = '{{ url("cart") }}';
const cartClearUrl = '{{ route("cart.clear") }}';

document.addEventListener('DOMContentLoaded', function() {
    initializeCartControls();
});

function initializeCartControls() {
    // Quantity update functionality with improved UX
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const action = this.getAttribute('data-action');
            const quantityInput = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
            let currentQuantity = parseInt(quantityInput.value);
            
            // Disable buttons during request
            disableQuantityControls(productId, true);
            
            if (action === 'increase') {
                updateCartQuantity(productId, currentQuantity + 1);
            } else if (action === 'decrease' && currentQuantity > 1) {
                updateCartQuantity(productId, currentQuantity - 1);
            } else if (action === 'decrease' && currentQuantity === 1) {
                // If trying to decrease from 1, ask for confirmation to remove
                if (confirm(translations.confirmDelete)) {
                    removeFromCart(productId);
                } else {
                    disableQuantityControls(productId, false);
                }
            }
        });
    });
    
    // Remove item functionality with confirmation
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            if (confirm(translations.confirmDelete)) {
                removeFromCart(productId);
            }
        });
    });
    
    // Direct quantity input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.getAttribute('data-product-id');
            const newQuantity = parseInt(this.value);
            
            if (newQuantity >= 1 && newQuantity <= 10) {
                disableQuantityControls(productId, true);
                updateCartQuantity(productId, newQuantity);
            } else {
                // Reset to previous value
                this.value = this.getAttribute('data-previous-value') || 1;
                showToast(translations.quantityRangeError, 'error');
            }
        });
        
        // Store previous value for reset
        input.addEventListener('focus', function() {
            this.setAttribute('data-previous-value', this.value);
        });
    });
}

function updateCartQuantity(productId, quantity) {
    const quantityInput = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
    const originalValue = quantityInput.value;
    
    // Optimistically update UI
    quantityInput.value = quantity;
    
    // Show loading indicator
    showQuantityLoader(productId, true);
    
    fetch(`${cartUpdateUrl}/${productId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: quantity
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update item total
            const itemTotalElement = document.querySelector(`.cart-single-list[data-product-id="${productId}"] .item-total`);
            itemTotalElement.textContent = data.item_total + ' ' + translations.currency;
            
            // Update cart totals with animation
            updateCartTotals(data.cart_total);
            
            // Show success feedback
            showToast(data.message, 'success');
            
            // Add visual feedback
            highlightElement(itemTotalElement);
        } else {
            // Revert UI changes
            quantityInput.value = originalValue;
            showToast(data.message || translations.cartUpdateError, 'error');
        }
    })
    .catch(error => {
        // Revert UI changes
        quantityInput.value = originalValue;
        console.error('Error:', error);
        showToast(translations.cartUpdateError, 'error');
    })
    .finally(() => {
        disableQuantityControls(productId, false);
        showQuantityLoader(productId, false);
    });
}

function removeFromCart(productId) {
    const itemElement = document.querySelector(`.cart-single-list[data-product-id="${productId}"]`);
    
    // Add removing animation
    itemElement.style.opacity = '0.5';
    itemElement.style.pointerEvents = 'none';
    
    // Show loading indicator
    const removeButton = itemElement.querySelector('.remove-item');
    const originalContent = removeButton.innerHTML;
    removeButton.innerHTML = '<i class="lni lni-spinner lni-spin"></i>';
    removeButton.disabled = true;
    
    fetch(`${cartDestroyUrl}/${productId}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Animate item removal
            itemElement.style.transform = 'translateX(-100%)';
            itemElement.style.transition = 'all 0.3s ease';
            
            setTimeout(() => {
                itemElement.remove();
                
                // Update cart totals
                updateCartTotals(data.cart_total);
                
                // Show success message
                showToast(data.message, 'success');
                
                // Check if cart is empty and reload if needed
                if (data.cart_count === 0) {
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                }
            }, 300);
        } else {
            // Revert UI changes
            itemElement.style.opacity = '1';
            itemElement.style.pointerEvents = 'auto';
            removeButton.innerHTML = originalContent;
            removeButton.disabled = false;
            showToast(data.message || translations.cartRemoveError, 'error');
        }
    })
    .catch(error => {
        // Revert UI changes
        itemElement.style.opacity = '1';
        itemElement.style.pointerEvents = 'auto';
        removeButton.innerHTML = originalContent;
        removeButton.disabled = false;
        console.error('Error:', error);
        showToast(translations.cartRemoveError, 'error');
    });
}

function updateCartTotals(newTotal) {
    const subtotalElement = document.getElementById('cart-subtotal');
    const totalElement = document.getElementById('cart-total');
    
    if (subtotalElement && totalElement) {
        // Add animation class
        subtotalElement.classList.add('updating-total');
        totalElement.classList.add('updating-total');
        
        setTimeout(() => {
            subtotalElement.textContent = newTotal + ' ' + translations.currency;
            totalElement.textContent = newTotal + ' ' + translations.currency;
            
            // Remove animation class
            subtotalElement.classList.remove('updating-total');
            totalElement.classList.remove('updating-total');
            
            // Highlight updated totals
            highlightElement(subtotalElement);
            highlightElement(totalElement);
        }, 150);
    }
}

function disableQuantityControls(productId, disabled) {
    const controls = document.querySelectorAll(`[data-product-id="${productId}"]`);
    controls.forEach(control => {
        control.disabled = disabled;
        if (disabled) {
            control.style.opacity = '0.6';
            control.style.pointerEvents = 'none';
        } else {
            control.style.opacity = '1';
            control.style.pointerEvents = 'auto';
        }
    });
}

function showQuantityLoader(productId, show) {
    const quantitySection = document.getElementById(`quantity-section-${productId}`);
    if (quantitySection) {
        if (show) {
            quantitySection.classList.add('loading');
        } else {
            quantitySection.classList.remove('loading');
        }
    }
}

function highlightElement(element) {
    element.style.transition = 'all 0.3s ease';
    element.style.backgroundColor = '#d4edda';
    element.style.color = '#155724';
    
    setTimeout(() => {
        element.style.backgroundColor = '';
        element.style.color = '';
    }, 1000);
}

function showToast(message, type) {
    // Remove existing toasts
    document.querySelectorAll('.cart-toast').forEach(toast => toast.remove());
    
    const toastClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? '✓' : '✗';
    
    const toast = document.createElement('div');
    toast.className = `alert ${toastClass} alert-dismissible fade show cart-toast`;
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
    
    // Auto remove after 4 seconds
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
    }, 4000);
}

// Add CSS for animations
const style = document.createElement('style');
style.textContent = `
    .updating-total {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }
    
    .loading {
        position: relative;
    }
    
    .loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }
    
    .cart-toast {
        animation: slideInRight 0.3s ease;
    }
    
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    .lni-spin {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
</script>
@endpush
@endsection 