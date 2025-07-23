@extends('frontend.layout')
@push('style')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}" />
@endpush
@section('content')
    <!-- Banner area start here -->
    <section class="banner-section-two paralax__animation">
     
      <div class="container">
        @foreach($sliders as $slider)
        <div class="row g-0 align-items-center">
          <div class="col-lg-6 content-column">
            <div class="inner-column">
              <div class="content-box">
                
                <h3 class="title wow fadeInUp" data-wow-delay="200ms" data-wow-duration="1500ms" style="width: 90%;">{{$slider->title}}</h3>
                <p class="text wow fadeInUp" data-wow-delay="500ms" data-wow-duration="1500ms">{{$slider->subtitle}} </p>
                <div class="btn-wrp">
                  <a class="btn-two-rounded wow fadeInLeft" data-wow-delay="500ms" data-wow-duration="1500ms" href="{{route('about')}}" 
                  style="  background-color: cornflowerblue;
"> Get started <i class="fa-regular fa-angle-right"></i></a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 image-column">
            <figure class="image">
              <img class=" wow " src="{{asset($slider->image)}}" alt="Image">
            </figure>
          </div>
        </div>
        @endforeach
      </div>
    </section>
    <!-- Banner area end here -->

    <!-- Start Featured Categories Area -->
    <section class="featured-categories section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Featured Categories</h2>
                        <p>Explore our diverse range of product categories and find exactly what you're looking for.</p>
                    </div>
                </div>
            </div>
            <div class="row">
             
                <div class="col-lg-4 col-md-6 col-12">  
                     @foreach($categories as $category)
                    <!-- Start Single Category -->
                    <div class="card mb-3" >
	<div class="row g-0" >
		<div class="col-md-4">
		<img class="img-fluid rounded-start" src="{{ asset($category->image) }}" alt="{{ $category->name }}">
		</div>
		<div class="col-md-8">
		<div class="card-body">
			<h5 class="card-title">{{ $category->name }}</h5>
			<p class="card-text">{{ $category->description }}</p>
		</div>
		</div>
	</div>
</div>
                    <!-- End Single Category -->
                    @endforeach
               
               
            </div>
        </div>
    </section>
    <!-- End Features Area -->

    <!-- Start Trending Product Area -->
    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Trending Products</h2>
                        <p>Discover the most popular products that our customers love and recommend.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($featuredProducts as $product)
                    <x-frontend.product-card :product="$product"/>
                @empty
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">No featured products available</h5>
                    <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">View All Products</a>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- End Trending Product Area -->

    <!-- Start Special Offer -->
    <section class="special-offer section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{ __('app.special_offers') }}</h2>
                        <p>{{ __('app.limited_time_offers') }}</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @forelse($specialOffers as $offer)
                    <div class="col-lg-6 col-md-8 col-12 mb-4">
                        <div class="offer-content">
                            <div class="image">
                                @if($offer->product->image)
                                <img src="{{ asset('uploads/store/products/' . $offer->product->image) }}" alt="{{ $offer->product->name }}">
                                @else
                                <img src="https://via.placeholder.com/510x300" alt="{{ $offer->product->name }}">
                                @endif
                            </div>
                            <div class="text">
                                <span class="category">{{ optional($offer->product->category)->name }}</span>
                                <h2>
                                    <a href="{{ route('product.show', $offer->product->id) }}">{{ $offer->product->name }}</a>
                                </h2>
                                <div class="price">
                                    <span class="old-price">{{ number_format($offer->product->price, 2) }} {{ __('app.currency') }}</span>
                                    <span class="new-price">
                                        {{ number_format($offer->product->price * 0.8, 2) }} 
                                        {{ __('app.currency') }}
                                    </span>
                                </div>
                                @if($offer->product->description)
                                <p>{{ Str::limit($offer->product->description, 100) }}</p>
                                @endif
                                <div class="button">
                                    <a href="{{ route('product.show', $offer->product->id) }}" class="btn">
                                        <i class="lni lni-eye"></i> {{ __('app.view_product') }}
                                    </a>
                                </div>
                                <div class="offer-timer small text-muted mt-2">
                                    {{ __('app.offer_ends') }}: {{ $offer->end_date->format('Y-m-d') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="col-lg-6 col-md-8 col-12">
                    <div class="offer-content">
                        <div class="image">
                            <img src="https://via.placeholder.com/510x300" alt="Special Offer">
                            <span class="sale-tag">{{ __('app.coming_soon') }}</span>
                        </div>
                        <div class="text">
                            <h2><a href="{{ route('products.index') }}">{{ __('app.no_offers_available') }}</a></h2>
                            <p>{{ __('app.check_back_later') }}</p>
                            <div class="button">
                                <a href="{{ route('products.index') }}" class="btn">{{ __('app.view_all_products') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- End Special Offer -->

    <!-- Start Home Product List -->
    <section class="home-product-list section">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-4 col-12 custom-responsive-margin">
                    <h4 class="list-title">Best Sellers</h4>
                    @forelse($bestSellers as $product)
                    <!-- Start Single List -->
                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('product.show', $product->id) }}">
                                @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                @else
                                <img src="https://via.placeholder.com/100x100" alt="{{ $product->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('product.show', $product->id) }}">{{ Str::limit($product->name, 30) }}</a>
                            </h3>
                            <span>${{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>
                    <!-- End Single List -->
                    @empty
                    <p class="text-muted">No best sellers available</p>
                    @endforelse
                </div>
                <div class="col-lg-4 col-md-4 col-12 custom-responsive-margin">
                    <h4 class="list-title">New Arrivals</h4>
                    @forelse($newArrivals as $product)
                    <!-- Start Single List -->
                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('product.show', $product->id) }}">
                                @if($product->image)
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                                @else
                                <img src="https://via.placeholder.com/100x100" alt="{{ $product->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('product.show', $product->id) }}">{{ Str::limit($product->name, 30) }}</a>
                            </h3>
                            <span>${{ number_format($product->price, 2) }}</span>
                        </div>
                    </div>
                    <!-- End Single List -->
                    @empty
                    <p class="text-muted">No new arrivals available</p>
                    @endforelse
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <h4 class="list-title">Featured Categories</h4>
                    @forelse($categories->take(3) as $category)
                    <!-- Start Single List -->
                    <div class="single-list">
                        <div class="list-image">
                            <a href="{{ route('products.index', ['category' => $category->id]) }}">
                                @if($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                                @else
                                <img src="https://via.placeholder.com/100x100" alt="{{ $category->name }}">
                                @endif
                            </a>
                        </div>
                        <div class="list-info">
                            <h3>
                                <a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->name }}</a>
                            </h3>
                            <span>{{ $category->products_count }} Products</span>
                        </div>
                    </div>
                    <!-- End Single List -->
                    @empty
                    <p class="text-muted">No categories available</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- End Home Product List -->

    <!-- Start Brands Area -->
    <div class="brands">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-12 col-12">
                    <h2 class="title">Popular Brands</h2>
                </div>
            </div>
            <div class="brands-logo-wrapper">
                <div class="brands-logo-carousel d-flex align-items-center justify-content-between">
                    @forelse($brands as $brand)
                    <div class="brand-logo">
                        @if($brand->logo)
                        <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}">
                        @else
                        <img src="https://via.placeholder.com/220x160" alt="{{ $brand->name }}">
                        @endif
                    </div>
                    @empty
                    <!-- Default brand logos if none found -->
                    @for($i = 1; $i <= 8; $i++)
                    <div class="brand-logo">
                        <img src="https://via.placeholder.com/220x160" alt="Brand {{ $i }}">
                    </div>
                    @endfor
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- End Brands Area -->

    <!-- Start Blog Section Area -->
    <section class="blog-section section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Our Latest News</h2>
                        <p>Stay updated with our latest news, articles, and industry insights.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($latestBlogs as $blog)
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Blog -->
                    <div class="single-blog">
                        <div class="blog-img">
                            <a href="#" onclick="alert('Blog detail page will be created soon')">
                                <img src="{{ $blog->featured_image_url }}" alt="{{ $blog->title }}">
                            </a>
                        </div>
                        <div class="blog-content">
                            <a class="category" href="javascript:void(0)">{{ $blog->category }}</a>
                            <h4>
                                <a href="#" onclick="alert('Blog detail page will be created soon')">{{ $blog->title }}</a>
                            </h4>
                            <p>{{ $blog->excerpt_or_content }}</p>
                            <div class="blog-meta d-flex justify-content-between align-items-center mb-2">
                                <small class="text-muted">{{ $blog->published_date }}</small>
                                <small class="text-muted">{{ $blog->reading_time }}</small>
                            </div>
                            <div class="button">
                                <a href="#" onclick="alert('Blog detail page will be created soon')" class="btn">Read More</a>
                            </div>
                        </div>
                    </div>
                    <!-- End Single Blog -->
                </div>
                @empty
                <!-- Default blogs if none found -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-blog">
                        <div class="blog-img">
                            <a href="#">
                                <img src="https://via.placeholder.com/370x215" alt="Coming Soon">
                            </a>
                        </div>
                        <div class="blog-content">
                            <a class="category" href="javascript:void(0)">General</a>
                            <h4>
                                <a href="#">Blog Posts Coming Soon</a>
                            </h4>
                            <p>We're working on creating amazing content for you. Stay tuned for our latest updates and insights.</p>
                            <div class="button">
                                <a href="#" class="btn">Coming Soon</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- End Blog Section Area -->

    <!-- Start Shipping Info -->
    <section class="shipping-info">
        <div class="container">
            <ul>
                <!-- Free Shipping -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>Free Shipping</h5>
                        <span>On order over $99</span>
                    </div>
                </li>
                <!-- Money Return -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>24/7 Support.</h5>
                        <span>Live Chat Or Call.</span>
                    </div>
                </li>
                <!-- Support 24/7 -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>Online Payment.</h5>
                        <span>Secure Payment Services.</span>
                    </div>
                </li>
                <!-- Safe Payment -->
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>Easy Return.</h5>
                        <span>Hassle Free Shopping.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- End Shipping Info -->
@endsection

@push('script')
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/tiny-slider.js')}}"></script>
    <script src="{{asset('assets/js/glightbox.min.js')}}"></script>
    <script src="{{asset('assets/js/main.js')}}"></script>
    <script type="text/javascript">
        //========= Hero Slider
        tns({
            container: '.hero-slider',
            slideBy: 'page',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 0,
            items: 1,
            nav: false,
            controls: true,
            controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
        });

        //======== Brand Slider
        tns({
            container: '.brands-logo-carousel',
            autoplay: true,
            autoplayButtonOutput: false,
            mouseDrag: true,
            gutter: 15,
            nav: false,
            controls: false,
            responsive: {
                0: {
                    items: 1,
                },
                540: {
                    items: 3,
                },
                768: {
                    items: 5,
                },
                992: {
                    items: 6,
                }
            }
        });
    </script>
@endpush

