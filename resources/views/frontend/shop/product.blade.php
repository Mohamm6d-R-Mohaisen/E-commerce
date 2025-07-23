@extends('frontend.layout')

@section('content')
<div class="product-details">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="product-image">
                    <img src="{{ asset('uploads/store/products/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="img-fluid">
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-info">
                    <h1 class="product-title">{{ $product->name }}</h1>
                    
                    <div class="product-category">
                        <a href="{{ route('shop.category', $product->category->slug) }}">
                            {{ $product->category->name }}
                        </a>
                    </div>

                    <div class="product-price">
                        @if($product->special_offer && $product->special_offer->isActive())
                            <div class="special-price">
                                <span class="current-price">{{ number_format($product->price, 2) }} {{ __('app.currency') }}</span>
                            </div>
                            <div class="offer-timer">
                                <span class="offer-badge">{{ __('app.special_offer') }}</span>
                                <p>{{ __('app.offer_ends') }}: {{ $product->special_offer->end_date->format('Y-m-d H:i') }}</p>
                            </div>
                        @else
                            <span class="regular-price">{{ number_format($product->price, 2) }} {{ __('app.currency') }}</span>
                        @endif
                    </div>

                    <div class="product-description">
                        {!! $product->description !!}
                    </div>

                    <div class="product-actions">
                        <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <div class="quantity-selector">
                                <label for="quantity">{{ __('app.quantity') }}:</label>
                                <input type="number" 
                                       name="quantity" 
                                       id="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}" 
                                       class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary add-to-cart">
                                {{ __('app.add_to_cart') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.product-details {
    padding: 40px 0;
}

.product-image {
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 20px;
}

.product-image img {
    width: 100%;
    height: auto;
}

.product-title {
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

.product-category {
    margin-bottom: 20px;
}

.product-category a {
    color: #666;
    text-decoration: none;
}

.product-price {
    margin-bottom: 20px;
}

.special-price .current-price {
    color: #ff4444;
    font-size: 24px;
    font-weight: bold;
}

.regular-price {
    font-size: 24px;
    color: #333;
    font-weight: bold;
}

.offer-timer {
    margin: 15px 0;
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 8px;
}

.offer-badge {
    display: inline-block;
    background-color: #ff4444;
    color: white;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 10px;
}

.offer-timer p {
    margin: 0;
    color: #666;
}

.product-description {
    margin: 20px 0;
    color: #666;
    line-height: 1.6;
}

.quantity-selector {
    margin-bottom: 20px;
}

.quantity-selector label {
    display: block;
    margin-bottom: 5px;
    color: #666;
}

.quantity-selector input {
    width: 100px;
}

.add-to-cart {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    font-weight: 600;
}
</style>
@endsection 