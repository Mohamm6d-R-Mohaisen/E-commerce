<!DOCTYPE html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="{{ $siteSettings['site_description'] ?? 'Your trusted e-commerce partner' }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="shortcut icon" type="image/x-icon" href="frontend/assets/images/favicon.svg" />
    
    <title>@yield('title', $siteSettings['site_name'])</title>

    <!-- ========================= CSS here ========================= -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/LineIcons.3.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/enhanced-style.css') }}" />
    @stack('style')

</head>

<body>


<!-- Preloader -->
<div class="preloader">
    <div class="preloader-inner">
        <div class="preloader-icon">
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- /End Preloader -->

<!-- Start Header Area -->
<header class="header navbar-area">
    <!-- Start Topbar -->
    <div class="topbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="top-left">
                        <ul class="menu-top-link">
                            <li>
                                <div class="select-position">
                                    <select id="select4">
                                        <option value="0" selected>$ USD</option>
                                        <option value="1">€ EURO</option>
                                        <option value="2">$ CAD</option>
                                        <option value="3">₹ INR</option>
                                        <option value="4">¥ CNY</option>
                                        <option value="5">৳ BDT</option>
                                    </select>
                                </div>
                            </li>
                            <li>
                                <div class="select-position">
                                    <form action="{{ URL::current() }}" method="get">
                                        <select id="languageSwitcher">
                                            @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                <option value="{{ $localeCode }}" @selected($localeCode == App::currentLocale())>
                                                    {{ $properties['native'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="top-middle">
                        <ul class="useful-links">
                            <li><a href="{{ route('home') }}">{{ __('app.home') }}</a></li>
                            <li><a href="{{ route('about') }}">{{ __('app.about') }}</a></li>
                            <li><a href="{{ route('contact') }}">{{ __('app.contact') }}</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-12">
                    <div class="top-end">
                        @auth()

                        <div class="user">
                            <i class="lni lni-user"></i>
                        </div>
                        <ul class="user-login">
                                                    <li> {{Auth::guard('web')->user()->name}}</li>
                        <li>
                            <a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout').submit()">{{ __('app.logout') }}</a>
                            <form action="{{route('logout')}}" method="post" id="logout" style="display:none">
                                @csrf
                            </form>
                        </li>

                        </ul>
                        @else
                            <div class="user">
                                <i class="lni lni-user"></i>
                                Hello
                            </div>
                            <ul class="user-login">
                                                            <li>
                                <a href="{{route('login')}}">{{ __('app.signin') }}</a>
                            </li>
                            <li>
                                <a href="{{route('register')}}">{{ __('app.register') }}</a>
                            </li>
                            </ul>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Topbar -->
    @stack('topbar')
    <!-- Start Header Middle -->
    <div class="header-middle">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-3 col-7">
                    <!-- Start Header Logo -->
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <img src="{{ $siteSettings['site_logo'] }}" alt="{{ $siteSettings['site_name'] }}">
                    </a>
                    <!-- End Header Logo -->
                </div>
                <div class="col-lg-5 col-md-7 d-xs-none">
                    <!-- Start Main Menu Search -->
                    <div class="main-menu-search">
                        <!-- navbar search start -->
                        <form action="{{ route('products.index') }}" method="GET" class="navbar-search search-style-5">
                            <div class="search-select">
                                <div class="select-position">
                                    <select name="category" id="searchCategory">
                                        <option value="">{{ __('app.all') }}</option>
                                        @isset($headerCategories)
                                            @foreach($headerCategories as $category)
                                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                            </div>
                            <div class="search-input">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('app.search_products') }}">
                            </div>
                            <div class="search-btn">
                                <button type="submit"><i class="lni lni-search-alt"></i></button>
                            </div>
                        </form>
                        <!-- navbar search Ends -->
                    </div>
                    <!-- End Main Menu Search -->
                </div>
                <div class="col-lg-4 col-md-2 col-5">
                    <div class="middle-right-area">
                        <div class="nav-hotline">
                            <i class="lni lni-phone"></i>
                            <h3>Hotline:
                                <span>{{ $contactInfo['phone_primary'] }}</span>
                            </h3>
                        </div>
                        <div class="navbar-cart">
                            <div class="wishlist">
                                <a href="javascript:void(0)">
                                    <i class="lni lni-heart"></i>
                                    <span class="total-items">0</span>
                                </a>
                            </div>




<x-frontend.cart-menu />




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Middle -->
    <!-- Start Header Bottom -->
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 col-md-6 col-12">
                <div class="nav-inner">
                    <!-- Start Mega Category Menu -->
                    <div class="mega-category-menu">
                        <span class="cat-button"><i class="lni lni-menu"></i>{{ __('app.all_categories') }}</span>
                        <ul class="sub-category">
                            @forelse($headerCategories as $category)
                            <li>
                                <a href="{{ route('products.index', ['category' => $category->id]) }}">
                                    {{ $category->name }}
                                    @if($category->products_count > 0)
                                    <span class="category-count">({{ $category->products_count }})</span>
                                    @endif
                                </a>
                            </li>
                            @empty
                            <li><a href="{{ route('products.index') }}">{{ __('app.all_products') }}</a></li>
                            @endforelse
                            
                            <!-- Additional static links if needed -->
                            <li><a href="{{ route('products.index') }}">{{ __('app.view_all_products') }}</a></li>
                        </ul>
                    </div>
                    <!-- End Mega Category Menu -->
                    <!-- Start Navbar -->
                    <nav class="navbar navbar-expand-lg">
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                            <span class="toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                            <ul id="nav" class="navbar-nav ms-auto">
                                <li class="nav-item">
                                    <a href="{{ route('home') }}" aria-label="Home">{{ __('app.home') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('about') }}" aria-label="About">{{ __('app.about') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="dd-menu collapsed" href="javascript:void(0)"
                                       data-bs-toggle="collapse" data-bs-target="#submenu-1-3"
                                       aria-controls="navbarSupportedContent" aria-expanded="false"
                                       aria-label="Toggle navigation">{{ __('app.products') }}</a>
                                    <ul class="sub-menu collapse" id="submenu-1-3">
                                        <li class="nav-item"><a href="{{ route('products.index') }}">{{ __('app.all_products') }}</a></li>
                                        @isset($headerCategories)
                                            @foreach($headerCategories->take(5) as $category)
                                                <li class="nav-item">
                                                    <a href="{{ route('products.index', ['category' => $category->id]) }}">
                                                        {{ $category->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endisset
                                        <li class="nav-item"><a href="{{ route('cart.index') }}">{{ __('app.shopping_cart') }}</a></li>
                                        @auth
                                        <li class="nav-item"><a href="{{ route('checkout') }}">{{ __('app.checkout') }}</a></li>
                                        @endauth
                                    </ul>
                                </li>
                                @auth
                                <li class="nav-item">
                                    <a class="dd-menu collapsed" href="javascript:void(0)"
                                       data-bs-toggle="collapse" data-bs-target="#submenu-1-4"
                                       aria-controls="navbarSupportedContent" aria-expanded="false"
                                       aria-label="Toggle navigation">{{ __('app.my_account') }}</a>
                                    <ul class="sub-menu collapse" id="submenu-1-4">
                                        <li class="nav-item"><a href="{{ route('orders.index') }}">{{ __('app.orders') }}</a></li>
                                        <li class="nav-item"><a href="{{ route('cart.index') }}">{{ __('app.shopping_cart') }}</a></li>
                                    </ul>
                                </li>
                                @endauth
                                <li class="nav-item">
                                    <a href="{{ route('contact') }}" aria-label="Contact">{{ __('app.contact') }}</a>
                                </li>
                            </ul>
                        </div> <!-- navbar collapse -->
                    </nav>
                    <!-- End Navbar -->
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-12">
                <!-- Start Nav Social -->
                <div class="nav-social">
                    <h5 class="title">Follow Us:</h5>
                    <ul>
                        @if($socialLinks['facebook'])
                        <li>
                            <a href="{{ $socialLinks['facebook'] }}" target="_blank"><i class="lni lni-facebook-filled"></i></a>
                        </li>
                        @endif
                        @if($socialLinks['twitter'])
                        <li>
                            <a href="{{ $socialLinks['twitter'] }}" target="_blank"><i class="lni lni-twitter-original"></i></a>
                        </li>
                        @endif
                        @if($socialLinks['instagram'])
                        <li>
                            <a href="{{ $socialLinks['instagram'] }}" target="_blank"><i class="lni lni-instagram"></i></a>
                        </li>
                        @endif
                        @if($socialLinks['linkedin'])
                        <li>
                            <a href="{{ $socialLinks['linkedin'] }}" target="_blank"><i class="lni lni-linkedin"></i></a>
                        </li>
                        @endif
                    </ul>
                </div>
                <!-- End Nav Social -->
            </div>
        </div>
    </div>
    <!-- End Header Bottom -->
</header>
<!-- End Header Area -->

<!-- Start Breadcrumbs -->
{{$breadcrumb ?? ''}}
@yield('content')

<!-- End Breadcrumbs -->

<!-- Start Footer Area -->
<footer class="footer">
    <!-- Start Footer Top -->
    <div class="footer-top">
        <div class="container">
            <div class="inner-content">
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-12">
                        <div class="footer-logo">
                            <a href="{{ route('home') }}">
                                <img src="{{ $siteSettings['site_logo_white'] }}" alt="{{ $siteSettings['site_name'] }}">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-8 col-12">
                        <div class="footer-newsletter">
                            <h4 class="title">
                                Subscribe to our Newsletter
                                <span>Get all the latest information, Sales and Offers.</span>
                            </h4>
                            <div class="newsletter-form-head">
                                <form action="#" method="get" target="_blank" class="newsletter-form">
                                    <input name="EMAIL" placeholder="Email address here..." type="email">
                                    <div class="button">
                                        <button class="btn">Subscribe<span class="dir-part"></span></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Top -->
    <!-- Start Footer Middle -->
    <div class="footer-middle">
        <div class="container">
            <div class="bottom-inner">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer f-contact">
                            <h3>Get In Touch With Us</h3>
                            @if($contactInfo['phone_primary'])
                            <p class="phone">Phone: {{ $contactInfo['phone_primary'] }}</p>
                            @endif
                            @if($contactInfo['working_hours'])
                            <ul>
                                {!! str_replace(',', '</li><li>', '<li>' . nl2br(e($contactInfo['working_hours']))) !!}</li>
                            </ul>
                            @endif
                            @if($contactInfo['support_email'])
                            <p class="mail">
                                <a href="mailto:{{ $contactInfo['support_email'] }}">{{ $contactInfo['support_email'] }}</a>
                            </p>
                            @endif
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer our-app">
                            <h3>Our Mobile App</h3>
                            <ul class="app-btn">
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="lni lni-apple"></i>
                                        <span class="small-title">Download on the</span>
                                        <span class="big-title">App Store</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="lni lni-play-store"></i>
                                        <span class="small-title">Download on the</span>
                                        <span class="big-title">Google Play</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer f-link">
                            <h3>Information</h3>
                            <ul>
                                <li><a href="{{ route('about') }}">About Us</a></li>
                                <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                <li><a href="javascript:void(0)">Downloads</a></li>
                                <li><a href="javascript:void(0)">Sitemap</a></li>
                                <li><a href="javascript:void(0)">FAQs Page</a></li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <!-- Single Widget -->
                        <div class="single-footer f-link">
                            <h3>{{ __('app.categories') }}</h3>
                            <ul>
                                @isset($headerCategories)
                                    @foreach($headerCategories->take(5) as $category)
                                        <li><a href="{{ route('products.index', ['category' => $category->id]) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                @endisset
                                <li><a href="{{ route('products.index') }}">{{ __('app.all_products') }}</a></li>
                            </ul>
                        </div>
                        <!-- End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Middle -->
    <!-- Start Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="inner-content">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-12">
                        <div class="payment-gateway">
                            <span>We Accept:</span>
                            <img src="{{ asset('frontend/assets/images/footer/credit-cards-footer.png')}}" alt="#">
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <div class="copyright">
                            <p>&copy; {{ date('Y') }} {{ $siteSettings['site_name'] }}. {{ __('app.all_rights_reserved') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
                        <ul class="socila">
                            <li>
                                <span>Follow Us On:</span>
                            </li>
                            @if($socialLinks['facebook'])
                            <li><a href="{{ $socialLinks['facebook'] }}" target="_blank"><i class="lni lni-facebook-filled"></i></a></li>
                            @endif
                            @if($socialLinks['twitter'])
                            <li><a href="{{ $socialLinks['twitter'] }}" target="_blank"><i class="lni lni-twitter-original"></i></a></li>
                            @endif
                            @if($socialLinks['instagram'])
                            <li><a href="{{ $socialLinks['instagram'] }}" target="_blank"><i class="lni lni-instagram"></i></a></li>
                            @endif
                            @if($socialLinks['youtube'])
                            <li><a href="{{ $socialLinks['youtube'] }}" target="_blank"><i class="lni lni-youtube"></i></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Footer Bottom -->
</footer>
<!--/ End Footer Area -->

<!-- ========================= scroll-top ========================= -->
<a href="#" class="scroll-top">
    <i class="lni lni-chevron-up"></i>
</a>

<!-- ========================= JS here ========================= -->
<script src="{{ asset('frontend/assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('frontend/assets/js/tiny-slider.js')}}"></script>
<script src="{{ asset('frontend/assets/js/glightbox.min.js')}}"></script>
<script src="{{ asset('frontend/assets/js/main.js')}}"></script>
<script>
    // جلب اللغات المدعومة من Laravel
    const supportedLocales = @json(array_keys(LaravelLocalization::getSupportedLocales()));
    
    document.getElementById('languageSwitcher').addEventListener('change', function () {
        const selectedLocale = this.value;
        const currentPath = window.location.pathname;

        // استخراج باقي الرابط بدون اللغة الحالية (إذا كانت موجودة)
        const pathSegments = currentPath.split('/').filter(Boolean);
        
        // التحقق إذا كانت اللغة موجودة في الرابط بالفعل
        if (pathSegments[0] && supportedLocales.includes(pathSegments[0])) {
            pathSegments[0] = selectedLocale; // استبدال اللغة
        } else {
            // إضافة اللغة في أول الرابط
            pathSegments.unshift(selectedLocale);
        }

        // إعادة بناء الرابط
        const newPath = '/' + pathSegments.join('/');
        window.location.href = newPath;
    });
</script>
@stack('script')
</body>

</html>
