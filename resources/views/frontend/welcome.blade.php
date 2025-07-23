@extends('frontend.layout')

@section('content')
<!-- Sliders Section -->
<section class="sliders-section">
    <div class="container">
        <div class="row">
            @foreach($sliders as $slider)
                <div class="col-12">
                    <img src="{{ asset('uploads/store/sliders/' . $slider->image) }}" 
                         alt="{{ $slider->title }}" 
                         class="img-fluid">
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section py-5">
    <div class="container">
        <h2 class="section-title text-center mb-4">{{ __('app.categories') }}</h2>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-4 col-sm-6 mb-4">
                    <a href="{{ route('shop.category', $category->slug) }}" class="category-card">
                        <img src="{{ asset('uploads/store/categories/' . $category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="img-fluid">
                        <div class="category-overlay">
                            <h3>{{ $category->name }}</h3>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Special Offers Section -->
@if($specialOfferProducts->isNotEmpty())
<section class="special-offers-section py-5 bg-light">
    <div class="container">
        <h2 class="section-title text-center mb-4">{{ __('app.special_offers') }}</h2>
        <div class="row">
            @foreach($specialOfferProducts as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <x-frontend.product-card :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Banners Section -->
<section class="banners-section py-5">
    <div class="container">
        <div class="row">
            @foreach($banners as $banner)
                <div class="col-md-6 mb-4">
                    <a href="{{ $banner->url }}" class="banner-card">
                        <img src="{{ asset('uploads/store/banners/' . $banner->image) }}" 
                             alt="{{ $banner->title }}" 
                             class="img-fluid">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.section-title {
    font-size: 32px;
    font-weight: bold;
    color: #333;
    margin-bottom: 30px;
}

.category-card {
    position: relative;
    display: block;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.category-card:hover {
    transform: translateY(-5px);
}

.category-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 20px;
    background: linear-gradient(transparent, rgba(0,0,0,0.7));
    color: white;
}

.category-overlay h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 600;
}

.banner-card {
    display: block;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.banner-card:hover {
    transform: translateY(-5px);
}

.banner-card img {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.special-offers-section {
    background-color: #f8f9fa;
}
</style>
@endsection 