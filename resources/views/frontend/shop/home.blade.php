@extends('frontend.layout')

@section('content')
    <!-- Start Hero Area -->
    <section class="hero-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="slider-head">
                        <!-- Start Hero Slider -->
                        <div class="hero-slider">
                            @forelse($sliders as $slider)
                            <!-- Start Single Slider -->
                            <div class="single-slider"
                                 @if($slider->background_image) 
                                     style="background-image: url('{{ asset($slider->background_image) }}');"
                                 @else 
                                     style="background-image: url('https://via.placeholder.com/1200x500');"
                                 @endif>
                                <div class="content">
                                    <h2>
                                        @if($slider->subtitle)
                                        <span>{{ $slider->subtitle }}</span>
                                        @endif
                                        {{ $slider->title }}
                                    </h2>
                                    @if($slider->description)
                                    <p>{{ $slider->description }}</p>
                                    @endif
                                    @if($slider->button_text && $slider->button_url)
                                    <div class="button">
                                        <a href="{{ $slider->button_url }}" class="btn">{{ $slider->button_text }}</a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <!-- End Single Slider -->
                            @empty
                            <!-- Default Slider if no sliders found -->
                            <div class="single-slider"
                                 style="background-image: url('https://via.placeholder.com/1200x500');">
                                <div class="content">
                                    <h2><span>Welcome to</span>
                                        Our Store
                                    </h2>
                                    <p>Discover amazing products at great prices</p>
                                    <div class="button">
                                        <a href="{{ route('products.index') }}" class="btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                            @endforelse
                        </div>
                        <!-- End Hero Slider -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero Area -->

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
                @forelse($categories as $category)
                <div class="col-lg-4 col-md-6 col-12">
                    <!-- Start Single Category -->
                    <div class="single-category">
                        <h3 class="heading">{{ $category->name }}</h3>
                        <ul>
                            @if($category->description)
                            <li>{{ Str::limit($category->description, 50) }}</li>
                            @endif
                            <li><span class="text-muted">{{ $category->products_count }} Products</span></li>
                            <li><a href="{{ route('products.index', ['category' => $category->id]) }}">View All Products</a></li>
                        </ul>
                        <div class="images">
                            @if($category->image)
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                            @else
                            <img src="https://via.placeholder.com/180x180" alt="{{ $category->name }}">
                            @endif
                        </div>
                    </div>
                    <!-- End Single Category -->
                </div>
                @empty
                <!-- Default categories if none found -->
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="single-category">
                        <h3 class="heading">All Products</h3>
                        <ul>
                            <li>Browse our collection</li>
                            <li>Great deals available</li>
                            <li><a href="{{ route('products.index') }}">View All Products</a></li>
                        </ul>
                        <div class="images">
                            <img src="https://via.placeholder.com/180x180" alt="Products">
                        </div>
                    </div>
                </div>
                @endforelse
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
                        <h2>Special Offers</h2>
                        <p>Don't miss out on our limited-time special offers and exclusive deals.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                @forelse($specialOffers as $offer)
                <div class="col-lg-6 col-md-8 col-12 mb-4">
                    <div class="offer-content">
                        <div class="image">
                            @if($offer->image)
                            <img src="{{ asset($offer->image) }}" alt="{{ $offer->title }}">
                            @else
                            <img src="https://via.placeholder.com/510x300" alt="{{ $offer->title }}">
                            @endif
                            <span class="sale-tag">-{{ $offer->discount_percentage }}%</span>
                        </div>
                        <div class="text">
                            <h2><a href="{{ $offer->button_url ?? route('products.index') }}">{{ $offer->title }}</a></h2>
                            @if($offer->description)
                            <p>{{ $offer->description }}</p>
                            @endif
                            @if($offer->button_text && $offer->button_url)
                            <div class="button">
                                <a href="{{ $offer->button_url }}" class="btn">{{ $offer->button_text }}</a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-lg-6 col-md-8 col-12">
                    <div class="offer-content">
                        <div class="image">
                            <img src="https://via.placeholder.com/510x300" alt="Special Offer">
                            <span class="sale-tag">Coming Soon</span>
                        </div>
                        <div class="text">
                            <h2><a href="{{ route('products.index') }}">Special Offers Coming Soon</a></h2>
                            <p>Stay tuned for amazing deals and special offers on our products.</p>
                            <div class="button">
                                <a href="{{ route('products.index') }}" class="btn">View Products</a>
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

