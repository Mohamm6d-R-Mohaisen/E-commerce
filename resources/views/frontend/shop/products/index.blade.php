@extends('frontend.layout')

@section('title', 'Products')

@push('style')
<style>
    /* Breadcrumbs Only */
    .breadcrumbs {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 60px 0;
        color: white;
    }
    
    .breadcrumb-content {
        text-align: center;
    }
    
    .page-title {
        color: white;
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 20px;
    }
    
    .breadcrumb {
        justify-content: center;
        background: transparent;
        margin: 0;
    }
    
    .breadcrumb-item a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
    }
    
    .breadcrumb-item a:hover {
        color: white;
    }
    
    .breadcrumb-item.active {
        color: white;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.6);
    }

    /* Minimal Custom Styles */
    .product-grids {
        padding: 60px 0;
    }
    
    .category-list {
        list-style: none;
        padding: 0;
    }
    
    .category-list li {
        margin-bottom: 8px;
    }
    
    .category-list a {
        color: #6c757d;
        text-decoration: none;
        font-size: 14px;
        transition: color 0.3s ease;
        display: block;
        padding: 8px 12px;
        border-radius: 4px;
    }
    
    .category-list a:hover,
    .category-list a.active {
        color: #0d6efd;
        background-color: #e7f1ff;
        font-weight: 600;
    }
    
    .no-products i {
        font-size: 48px;
        color: #6c757d;
        margin-bottom: 20px;
        display: block;
    }
</style>
@endpush

@section('content')
<!-- Breadcrumbs -->
<section class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h1 class="page-title">Products</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Products</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="product-grids">
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 col-md-4 col-12 mb-4">
                <!-- Filters Card -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">
                            <i class="lni lni-funnel me-2"></i>
                            Filters
                        </h5>
                    </div>
                    <div class="card-body">
                        
                        <!-- Search Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="lni lni-search-alt me-2"></i>
                                Search
                            </h6>
                            <form method="GET" action="{{ route('products.index') }}">
                                <div class="input-group mb-2">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Search for products..."
                                           class="form-control">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="lni lni-search-alt"></i>
                                    </button>
                                </div>
                                <!-- Preserve other filters -->
                                @foreach(request()->except(['search', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                            </form>
                        </div>

                        <hr>

                        <!-- Categories Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="lni lni-grid-alt me-2"></i>
                                Categories
                            </h6>
                            <ul class="category-list">
                                <li>
                                    <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), [])) }}" 
                                       class="{{ !request('category') ? 'active' : '' }}">
                                        All Categories
                                    </a>
                                </li>
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']), ['category' => $category->id])) }}" 
                                           class="{{ request('category') == $category->id ? 'active' : '' }}">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <hr>

                        <!-- Price Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">
                                <i class="lni lni-wallet me-2"></i>
                                Price Range
                            </h6>
                            <form method="GET" action="{{ route('products.index') }}">
                                <div class="row g-2 mb-2">
                                    <div class="col-6">
                                        <input type="number" 
                                               name="min_price" 
                                               value="{{ request('min_price') }}"
                                               placeholder="Min Price"
                                               class="form-control"
                                               min="0">
                                    </div>
                                    <div class="col-6">
                                        <input type="number" 
                                               name="max_price" 
                                               value="{{ request('max_price') }}"
                                               placeholder="Max Price"
                                               class="form-control"
                                               min="0">
                                    </div>
                                </div>
                                <!-- Preserve other filters -->
                                @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="lni lni-funnel me-1"></i>
                                    Apply Filter
                                </button>
                            </form>
                        </div>

                        <!-- Clear Filters -->
                        @if(request()->hasAny(['search', 'category', 'min_price', 'max_price', 'sort_by']))
                            <hr>
                            <div class="d-grid">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-danger">
                                    <i class="lni lni-trash me-1"></i>
                                    Clear All Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9 col-md-8 col-12">
                
                <!-- Sort Controls -->
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-6 col-12 mb-2 mb-md-0">
                                <div class="text-muted">
                                    <i class="lni lni-list me-1"></i>
                                    Showing {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} 
                                    of {{ $products->total() }} products
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <!-- Sort Controls Form -->
                                <form method="GET" action="{{ route('products.index') }}" class="d-flex gap-2 justify-content-md-end align-items-center">
                                    <div class="d-flex align-items-center">
                                        <label for="sort_by" class="form-label me-2 mb-0 text-nowrap">Sort by:</label>
                                        <select name="sort_by" id="sort_by" class="form-select form-select-sm" onchange="this.form.submit()">
                                            <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Name</option>
                                            <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Price</option>
                                            <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>Newest</option>
                                        </select>
                                    </div>
                                    
                                    <select name="sort_order" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="asc" {{ request('sort_order', 'asc') == 'asc' ? 'selected' : '' }}>Ascending</option>
                                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                                    </select>

                                    <!-- Preserve other filters -->
                                    @foreach(request()->except(['sort_by', 'sort_order', 'page']) as $key => $value)
                                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                    @endforeach
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                @if($products->count() > 0)
                    <div class="row g-4">
                        @foreach($products as $product)
                            <x-frontend.product-card :product="$product"/>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <nav aria-label="Products pagination">
                                {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                @else
                    <!-- No Products Found -->
                    <div class="text-center py-5">
                        <div class="card border-0 bg-light">
                            <div class="card-body py-5">
                                <i class="lni lni-sad"></i>
                                <h4 class="mt-3 mb-3">No Products Found</h4>
                                <p class="text-muted mb-4">Try using different filters or clear the current filters</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary">
                                    <i class="lni lni-reload me-1"></i>
                                    View All Products
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection 