<div class="cart-items">
    <a href="javascript:void(0)" class="main-btn">
        <i class="lni lni-cart"></i>
        <span class="total-items" id="cart-count">{{$cartItems->count()}}</span>
    </a>
    <!-- Shopping Item -->
    <div class="shopping-item">
        <div class="dropdown-cart-header">
            <span>{{ __('app.items') }} ({{$cartItems->count()}})</span>
            <a href="{{route('cart.index')}}">{{ __('app.view_cart') }}</a>
        </div>
        <ul class="shopping-list" id="cart-items-list">
            @forelse($cartItems as $item)
            <li data-product-id="{{$item->product_id}}">
                <a href="javascript:void(0)" class="remove remove-cart-item" 
                   title="{{ __('Delete this item') }}" 
                   data-product-id="{{$item->product_id}}">
                    <i class="lni lni-close"></i>
                </a>
                <div class="cart-img-head">
                    <a class="cart-img" href="#">
                        @if($item->product->image)
                            <img src="{{asset($item->product->image)}}" alt="{{$item->product->name}}">
                        @else
                            <div class="no-image">📦</div>
                        @endif
                    </a>
                </div>

                <div class="content">
                    <h4>
                        <a href="#">
                            {{$item->product->name}}
                        </a>
                    </h4>
                    <p class="quantity">
                        <span class="item-quantity">{{$item->quantity}}</span>x - 
                        <span class="amount">{{ number_format($item->product->price, 2) }} {{ __('app.currency') }}</span>
                    </p>
                </div>
            </li>
            @empty
            <li class="empty-cart-message" style="text-align: center; padding: 20px;">
                <p>{{ __('app.cart_is_empty') }}</p>
            </li>
            @endforelse
        </ul>
        <div class="bottom">
            <div class="total">
                <span>{{ __('app.total') }}</span>
                <span class="total-amount" id="cart-total">{{ number_format($total, 2) }} {{ __('app.currency') }}</span>
            </div>
            @if($cartItems->count() > 0)
            <div class="button">
                <a href="{{route('checkout')}}" class="btn animate">{{ __('app.checkout') }}</a>
            </div>
            @else
            <div class="button">
                <a href="{{route('home')}}" class="btn animate">{{ __('app.start_shopping') }}</a>
            </div>
            @endif
        </div>
    </div>
    <!--/ End Shopping Item -->
</div>

<script>
// Translation variables
const translations = {
    emptyCart: "{{ __('app.cart_is_empty') }}",
    items: "{{ __('app.items') }}",
    startShopping: "{{ __('app.start_shopping') }}",
    deleteError: "{{ __('auth.cart_remove_error') }}"
};

// URL variables
const homeUrl = "{{ route('home') }}";

document.addEventListener('DOMContentLoaded', function() {
    // Remove item from cart in dropdown menu
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-cart-item')) {
            e.preventDefault();
            const removeButton = e.target.closest('.remove-cart-item');
            const productId = removeButton.getAttribute('data-product-id');
            const cartItem = removeButton.closest('li');
            
            removeFromCartMenu(productId, cartItem);
        }
    });

    function removeFromCartMenu(productId, cartItem) {
        fetch('/cart/' + productId, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove item from dropdown
                cartItem.style.opacity = '0';
                setTimeout(function() {
                    cartItem.remove();
                    
                    // Update cart count and total
                    document.getElementById('cart-count').textContent = data.cart_count;
                    document.getElementById('cart-total').textContent = formatCurrency(data.cart_total);
                    
                    // Show empty message if no items
                    if (data.cart_count === 0) {
                        document.getElementById('cart-items-list').innerHTML = 
                            '<li class="empty-cart-message" style="text-align: center; padding: 20px;">' +
                                '<p>' + translations.emptyCart + '</p>' +
                            '</li>';
                        document.querySelector('.dropdown-cart-header span').textContent = translations.items + ' (0)';
                        document.querySelector('.button').innerHTML = '<a href="' + homeUrl + '" class="btn animate">' + translations.startShopping + '</a>';
                    } else {
                        document.querySelector('.dropdown-cart-header span').textContent = translations.items + ' (' + data.cart_count + ')';
                    }
                }, 300);
                
                showCartToast(data.message, 'success');
            }
        })
        .catch(error => {
            showCartToast(translations.deleteError, 'error');
        });
    }

    function formatCurrency(amount) {
        return '$' + parseFloat(amount).toFixed(2);
    }

    function showCartToast(message, type) {
        const toastClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const toast = document.createElement('div');
        toast.className = 'alert ' + toastClass + ' alert-dismissible fade show cart-toast';
        toast.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = message + '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        
        document.body.appendChild(toast);
        
        // Auto remove after 3 seconds
        setTimeout(function() {
            toast.style.opacity = '0';
            setTimeout(function() {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 300);
        }, 3000);
    }
});
</script>

