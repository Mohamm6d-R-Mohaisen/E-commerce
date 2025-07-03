<div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-4">
    <!-- Bootstrap Product Card -->
    <div class="card h-100 shadow-sm border-0 position-relative product-card">
        <!-- Product Image -->
        <div class="position-relative overflow-hidden">
            <a href="{{ route('product.show', $product->slug) }}">
                <img src="{{ $product->image_url }}" 
                     alt="{{ $product->name }}" 
                     class="card-img-top product-image"
                     style="height: 200px; object-fit: cover;">
            </a>
            
            <!-- View Product Button Overlay -->
            <div class="position-absolute bottom-0 start-0 end-0 p-2 product-overlay">
                <a href="{{ route('product.show', $product->slug) }}" class="btn btn-light btn-sm w-100">
                    <i class="lni lni-eye me-1"></i>
                    View Product
                </a>
            </div>
        </div>
        
        <!-- Product Info -->
        <div class="card-body d-flex flex-column p-3">
            <!-- Category -->
            <span class="badge bg-light text-dark mb-2 align-self-start small">
                {{ $product->category->name ?? 'Uncategorized' }}
            </span>
            
            <!-- Product Name -->
            <h6 class="card-title mb-2">
                <a href="{{ route('product.show', $product->slug) }}" 
                   class="text-decoration-none text-dark fw-bold">
                    {{ $product->name }}
                </a>
            </h6>
            
            <!-- Rating -->
            <div class="mb-2">
                <div class="text-warning small">
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <i class="lni lni-star-filled"></i>
                    <span class="text-muted ms-1">(5.0)</span>
                </div>
            </div>
            
            <!-- Price -->
            <div class="mt-auto">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <span class="h6 text-primary mb-0 fw-bold">
                            ${{ number_format($product->price, 2) }}
                        </span>
                        @if($product->compare_price)
                            <span class="text-muted text-decoration-line-through small">
                                ${{ number_format($product->compare_price, 2) }}
                            </span>
                        @endif
                    </div>
                    
                    <!-- Quick View Link -->
                    <a href="{{ route('product.show', $product->slug) }}" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="lni lni-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bootstrap Product Card -->
</div>

@once
@push('style')
<style>
/* Product Card Hover Effects */
.product-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.12) !important;
}

.product-card:hover .product-image {
    transform: scale(1.03);
}

.product-image {
    transition: transform 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-overlay {
    background: linear-gradient(transparent, rgba(0,0,0,0.6));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay .btn {
    transform: translateY(0);
}

.product-overlay .btn {
    transform: translateY(15px);
    transition: transform 0.3s ease;
}

.product-card .card-title a:hover {
    color: #0d6efd !important;
    transition: color 0.3s ease;
}

/* Compact card styling */
.product-card .card-body {
    padding: 12px !important;
}

.product-card .card-title {
    font-size: 0.95rem;
    line-height: 1.3;
}

.product-card .badge {
    font-size: 0.7rem;
}
</style>
@endpush
@endonce
