@extends('frontend.layout')
@section('content')
    <x-slot:breadcrumb>
    <div class="breadcrumbs">
       <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="breadcrumbs-content">
                       <h1 class="page-title">{{$product->name}}</h1>
                   </div>
               </div>
           <div class="col-lg-6 col-md-6 col-12">
                    <ul class="breadcrumb-nav">
                       <li><a href="{{route('home')}}"><i class="lni lni-home"></i> Home</a></li>
                       <li><a href="{{route('products.index')}}"><i class="lni lni-grid-alt"></i> Products</a></li>
                     <li>{{$product->name}}</li>
                   </ul>
               </div>
           </div>
       </div>
   </div>
    </x-slot:breadcrumb>
 <!-- Start Item Details -->
 <section class="item-details section">
    <div class="container">
        <div class="top-area">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="product-images">
                        <main id="gallery">
                            <div class="main-img">
                                <img src="{{$product->image_url}}" id="current" alt="#">
                            </div>
                            <div class="images">
                                <img src="https://via.placeholder.com/1000x670" class="img" alt="#">
                                <img src="https://via.placeholder.com/1000x670" class="img" alt="#">
                                <img src="https://via.placeholder.com/1000x670" class="img" alt="#">
                                <img src="https://via.placeholder.com/1000x670" class="img" alt="#">
                                <img src="https://via.placeholder.com/1000x670" class="img" alt="#">
                            </div>
                        </main>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                    <div class="product-info">
                        <h2 class="title">{{$product->name}}</h2>
                        <p class="category"><i class="lni lni-tag"></i> Category: <a href="javascript:void(0)">{{$product->category->name ?? 'Uncategorized'}}</a></p>
                        <h3 class="price">${{ number_format($product->price, 2) }} @if($product->compare_price )<span>${{ number_format($product->compare_price, 2) }}</span>@endif </h3>
                        <p class="info-text">{{$product->description}}.</p>
                        <form action="{{route('cart.store')}} " method="post">
                            @csrf
                            <input type="hidden" name="product_id" value="{{$product->id}}">

                        <div class="row">
                            <!-- Product Colors -->
                            @if($product->details && $product->details->colors && count($product->details->colors) > 0)
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group color-option">
                                    <label class="title-label">Choose Color</label>
                                    @foreach($product->details->available_colors as $index => $color)
                                    <div class="single-checkbox" style="background-color: {{ $color['value'] ?? '#000000' }};">
                                        <input type="radio" id="color-{{ $index }}" name="product_color" value="{{ $color['name'] ?? '' }}" {{ $index === 0 ? 'checked' : '' }}>
                                        <label for="color-{{ $index }}" title="{{ $color['name'] ?? '' }}"><span></span></label>
                                    </div>
                                    @endforeach
                                    </div>
                                    </div>
                            @endif
                            
                            <!-- Product Variants -->
                            @if($product->details && $product->details->variants && count($product->details->variants) > 0)
                                @foreach($product->details->variants as $variant)
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="variant-{{ $variant['type'] ?? '' }}">{{ $variant['label'] ?? $variant['type'] ?? '' }}</label>
                                        <select class="form-control" id="variant-{{ $variant['type'] ?? '' }}" name="variants[{{ $variant['type'] ?? '' }}]">
                                            @if(isset($variant['options']) && is_array($variant['options']))
                                                @foreach($variant['options'] as $option)
                                                <option value="{{ $option }}">{{ $option }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                @endforeach
                            @else
                            <!-- Default variant if no variants are set -->
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group">
                                    <label for="default_variant">Options</label>
                                    <select class="form-control" id="default_variant">
                                        <option>Standard</option>
                                    </select>
                                </div>
                            </div>
                            @endif
                            <div class="col-lg-4 col-md-4 col-12">
                                <div class="form-group quantity">
                                    <label for="color">Quantity</label>
                                    <select class="form-control" name="quantity" >
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="bottom-content">
                            <div class="row align-items-end">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="button cart-button">
                                        <button class="btn" type="submit" style="width: 100%;">Add to Cart</button>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="wish-button">
                                        <button class="btn"><i class="lni lni-reload"></i> Compare</button>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="wish-button">
                                        <button class="btn"><i class="lni lni-heart"></i> Add to Wishlist</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-details-info">
            <div class="single-block">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="info-body custom-responsive-margin">
                            <h4>Details</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat.</p>
                            <h4>Features</h4>
                            <ul class="features">
                                @if($product->details && $product->details->features && count($product->details->features) > 0)
                                    @foreach($product->details->features as $feature)
                                    <li>{{ $feature }}</li>
                                    @endforeach
                                @else
                                <li>Capture 4K30 Video and 12MP Photos</li>
                                <li>Game-Style Controller with Touchscreen</li>
                                <li>View Live Camera Feed</li>
                                <li>Full Control of HERO6 Black</li>
                                <li>Use App for Dedicated Camera Operation</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="info-body">
                            <h4>Specifications</h4>
                            <ul class="normal-list">
                                @if($product->details && $product->details->specifications && count($product->details->specifications) > 0)
                                    @foreach($product->details->specifications as $key => $value)
                                    <li><span>{{ $key }}:</span> {{ $value }}</li>
                                    @endforeach
                                @else
                                    <li><span>Weight:</span> 35.5oz (1006g)</li>
                                    <li><span>Maximum Speed:</span> 35 mph (15 m/s)</li>
                                    <li><span>Maximum Distance:</span> Up to 9,840ft (3,000m)</li>
                                    <li><span>Operating Frequency:</span> 2.4GHz</li>
                                    <li><span>Manufacturer:</span> GoPro, USA</li>
                                @endif
                            </ul>
                            <h4>Shipping Options:</h4>
                            <ul class="normal-list">
                                @if($product->details && $product->details->shipping_options && count($product->details->shipping_options) > 0)
                                    @foreach($product->details->formatted_shipping_options as $option)
                                    <li><span>{{ $option['name'] ?? '' }}:</span> {{ $option['time'] ?? '' }}{{ isset($option['formatted_price']) ? ', ' . $option['formatted_price'] : '' }}</li>
                                    @endforeach
                                @else
                                    <li><span>Courier:</span> 2 - 4 days, $22.50</li>
                                    <li><span>Local Shipping:</span> up to one week, $10.00</li>
                                    <li><span>UPS Ground Shipping:</span> 4 - 6 days, $18.00</li>
                                    <li><span>Global Export:</span> 3 - 4 days, $25.00</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- End Item Details -->


@push('script')
<script type="text/javascript">
    const current = document.getElementById("current");
    const opacity = 0.6;
    const imgs = document.querySelectorAll(".img");
    imgs.forEach(img => {
        img.addEventListener("click", (e) => {
            //reset opacity
            imgs.forEach(img => {
                img.style.opacity = 1;
            });
            current.src = e.target.src;
            //adding class
            //current.classList.add("fade-in");
            //opacity
            e.target.style.opacity = opacity;
        });
    });
</script>
@endpush
@endsection
