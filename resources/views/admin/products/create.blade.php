@extends('admin.layouts.master', ['is_active_parent' => 'products', 'is_active' => 'products'])
@section('title', __("products"))

@section('content')
<form id="kt_form" class="form row d-flex flex-column flex-lg-row addForm"
    action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
    method="POST"
    enctype="multipart/form-data">
    @csrf
    @isset($product)
    @method('PATCH')
    @endisset

    <div class="page-content-header mb-5">
        <h2 class="table-title">{{ isset($product) ? __("Product Edit") : __("Product Create") }}</h2>
    </div>
    
    <div class="main-content-wrapper">
    <div class="row">
        <!-- Sidebar: Image -->
        <div class="col-lg-3 mb-4">
        <div class="card product-sidebar">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('Product Image') }}</h5>
            </div>
            <div class="card-body py-4 border-bottom bg-light bg-opacity-50">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-dark fs-6">{{ __('Status') }}</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch" name="status" value="active"
                            style="width: 2.5rem; height: 1.3rem;"
                            {{ (isset($product) && $product->status == 'active') || !isset($product) ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-3">
                    <span class="fw-bold text-dark fs-6">{{ __('Featured') }}</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="featuredSwitch" name="featured" value="1"
                            style="width: 2.5rem; height: 1.3rem;"
                            {{ (isset($product) && $product->featured) ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                <div class="mb-3 position-relative d-inline-block">
                    @if(isset($product) && $product->image)
                    <img src="{{ asset($product->image) }}" class="rounded mx-auto d-block" style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #e9ecef;" alt="{{ __('Product Image') }}" id="imagePreview">
                    @else
                    <div class="bg-light border rounded d-flex align-items-center justify-content-center mx-auto position-relative" style="width: 200px; height: 200px; cursor: pointer;" id="imagePreview" onclick="document.getElementById('imageInput').click()">
                        <div class="text-center">
                            <div style="font-size: 3rem; color: #6c757d;">📷</div>
                            <p class="text-muted fw-bold mt-2 mb-0">{{ __('Click to upload image') }}</p>
                            <small class="text-muted">PNG, JPG, JPEG</small>
                        </div>
                    </div>
                    @endif

                    <!-- Change Image Button -->
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px shadow"
                        data-kt-image-input-action="change" title="{{ __('Change image') }}"
                        style="position: absolute; top: -10px; right: -10px; background: rgba(255,255,255,0.8);">
                        <span class="fs-7">✏️</span>
                        <input type="file" name="image" accept=".png, .jpg, .jpeg" id="imageInput" style="display: none;" />
                    </label>

                    <!-- Remove Button -->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px shadow"
                        data-kt-image-input-action="remove" title="{{ __('Remove image') }}"
                        onclick="removeImage()"
                        style="position: absolute; bottom: -10px; right: -10px; background: rgba(255,255,255,0.8);">
                        <span class="fs-7">🗑️</span>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="col-lg-9">
        <!-- Basic Information Card -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('Basic Information') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-lg" placeholder="{{ __('Enter product name') }}" value="{{ isset($product) ? $product->name : '' }}" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">{{ __('Category Name') }} <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-control form-control-lg" required>
                            <option value="">{{ __('Select Category') }}</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (isset($product) && $product->category_id == $category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold">{{ __('SKU') }}</label>
                        <input type="text" name="sku" class="form-control form-control-lg" placeholder="{{ __('Enter product SKU') }}" value="{{ isset($product) ? $product->details?->sku : '' }}">
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold">{{ __('Price') }} <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" name="price" class="form-control form-control-lg" placeholder="{{ __('Enter product price') }}" value="{{ isset($product) ? $product->price : '' }}" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold">{{ __('Compare Price') }}</label>
                        <input type="number" step="0.01" name="compare_price" class="form-control form-control-lg" placeholder="{{ __('Enter product compare price') }}" value="{{ isset($product) ? $product->compare_price : '' }}">
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold">{{ __('Quantity') }} <span class="text-danger">*</span></label>
                        <input type="number" min="0" name="quantity" class="form-control form-control-lg" placeholder="{{ __('Enter product quantity') }}" value="{{ isset($product) ? $product->quantity : '' }}" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label fw-semibold">{{ __('Weight') }}</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="weight" class="form-control" placeholder="0.00" value="{{ isset($product) ? $product->details?->weight : '' }}">
                            <select name="weight_unit" class="form-select" style="max-width: 80px;">
                                <option value="kg" {{ (isset($product) && $product->details?->weight_unit == 'kg') ? 'selected' : '' }}>kg</option>
                                <option value="g" {{ (isset($product) && $product->details?->weight_unit == 'g') ? 'selected' : '' }}>g</option>
                                <option value="lb" {{ (isset($product) && $product->details?->weight_unit == 'lb') ? 'selected' : '' }}>lb</option>
                                <option value="oz" {{ (isset($product) && $product->details?->weight_unit == 'oz') ? 'selected' : '' }}>oz</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Tags') }}</label>
                        <input type="text" name="tags" class="form-control form-control-lg" placeholder="{{ __('Enter product tags') }}" value="{{ isset($product) ? $product->tags : '' }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Short Description') }}</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="{{ __('Enter short description') }}">{{ isset($product) ? $product->description : '' }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Long Description') }}</label>
                        <textarea name="long_description" class="form-control" rows="5" placeholder="{{ __('Enter detailed description') }}">{{ isset($product) ? $product->details?->long_description : '' }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Colors -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Product Colors') }}</h5>
                <button type="button" class="btn btn-sm btn-primary" onclick="addColor()">
                    <i class="fas fa-plus"></i> Add Color
                </button>
            </div>
            <div class="card-body">
                <div id="colors-container">
                    @if(isset($product) && $product->details?->colors)
                        @foreach($product->details->colors as $index => $color)
                        <div class="color-item border rounded p-3 mb-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-4">
                                    <label class="form-label">Color Name</label>
                                    <input type="text" name="colors[{{ $index }}][name]" class="form-control" value="{{ $color['name'] ?? '' }}" placeholder="Red, Blue, etc.">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Color Value</label>
                                    <input type="color" name="colors[{{ $index }}][value]" class="form-control form-control-color" value="{{ $color['value'] ?? '#000000' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Available</label>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="colors[{{ $index }}][available]" value="1" {{ ($color['available'] ?? true) ? 'checked' : '' }}>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeColor(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-muted text-center py-3">
                        No colors added yet. Click "Add Color" to start.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Variants -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Product Variants') }}</h5>
                <button type="button" class="btn btn-sm btn-primary" onclick="addVariant()">
                    <i class="fas fa-plus"></i> Add Variant
                </button>
            </div>
            <div class="card-body">
                <div id="variants-container">
                    @if(isset($product) && $product->details?->variants)
                        @foreach($product->details->variants as $index => $variant)
                        <div class="variant-item border rounded p-3 mb-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label">Type</label>
                                    <input type="text" name="variants[{{ $index }}][type]" class="form-control" value="{{ $variant['type'] ?? '' }}" placeholder="battery, size, memory">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Label</label>
                                    <input type="text" name="variants[{{ $index }}][label]" class="form-control" value="{{ $variant['label'] ?? '' }}" placeholder="Battery Capacity">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Options (comma separated)</label>
                                    <input type="text" name="variants[{{ $index }}][options]" class="form-control" value="{{ is_array($variant['options'] ?? []) ? implode(', ', $variant['options']) : '' }}" placeholder="5100 mAh, 6200 mAh, 8000 mAh">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeVariant(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-muted text-center py-3">
                        No variants added yet. Click "Add Variant" to start.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Features -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Product Features') }}</h5>
                <button type="button" class="btn btn-sm btn-primary" onclick="addFeature()">
                    <i class="fas fa-plus"></i> Add Feature
                </button>
            </div>
            <div class="card-body">
                <div id="features-container">
                    @if(isset($product) && $product->details?->features)
                        @foreach($product->details->features as $index => $feature)
                        <div class="feature-item d-flex align-items-center mb-2">
                            <input type="text" name="features[]" class="form-control me-2" value="{{ $feature }}" placeholder="Enter feature">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeFeature(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        @endforeach
                    @else
                    <div class="text-muted text-center py-3">
                        No features added yet. Click "Add Feature" to start.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Product Specifications -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Product Specifications') }}</h5>
                <button type="button" class="btn btn-sm btn-primary" onclick="addSpecification()">
                    <i class="fas fa-plus"></i> Add Specification
                </button>
            </div>
            <div class="card-body">
                <div id="specifications-container">
                    @if(isset($product) && $product->details?->specifications)
                        @foreach($product->details->specifications as $key => $value)
                        <div class="specification-item d-flex align-items-center mb-2">
                            <input type="text" name="specifications_keys[]" class="form-control me-2" value="{{ $key }}" placeholder="Weight" style="max-width: 200px;">
                            <input type="text" name="specifications_values[]" class="form-control me-2" value="{{ $value }}" placeholder="35.5oz (1006g)">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeSpecification(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        @endforeach
                    @else
                    <div class="text-muted text-center py-3">
                        No specifications added yet. Click "Add Specification" to start.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Shipping Options -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Shipping Options') }}</h5>
                <button type="button" class="btn btn-sm btn-primary" onclick="addShippingOption()">
                    <i class="fas fa-plus"></i> Add Shipping Option
                </button>
            </div>
            <div class="card-body">
                <div id="shipping-container">
                    @if(isset($product) && $product->details?->shipping_options)
                        @foreach($product->details->shipping_options as $index => $option)
                        <div class="shipping-item border rounded p-3 mb-3">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="shipping[{{ $index }}][name]" class="form-control" value="{{ $option['name'] ?? '' }}" placeholder="Courier">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Time</label>
                                    <input type="text" name="shipping[{{ $index }}][time]" class="form-control" value="{{ $option['time'] ?? '' }}" placeholder="2-4 days">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Price ($)</label>
                                    <input type="number" step="0.01" name="shipping[{{ $index }}][price]" class="form-control" value="{{ $option['price'] ?? '' }}" placeholder="22.50">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeShippingOption(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                    <div class="text-muted text-center py-3">
                        No shipping options added yet. Click "Add Shipping Option" to start.
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Meta Information -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('SEO Meta Information') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Meta Title') }}</label>
                        <input type="text" name="meta_title" class="form-control" placeholder="{{ __('Enter meta title') }}" value="{{ isset($product) ? $product->details?->meta_title : '' }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Meta Description') }}</label>
                        <textarea name="meta_description" class="form-control" rows="3" placeholder="{{ __('Enter meta description') }}">{{ isset($product) ? $product->details?->meta_description : '' }}</textarea>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Meta Keywords') }}</label>
                        <input type="text" name="meta_keywords" class="form-control" placeholder="{{ __('Enter meta keywords (comma separated)') }}" value="{{ isset($product) ? $product->details?->meta_keywords : '' }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex gap-2 justify-content-end">
                <button type="button" class="btn btn-light">{{ __('Cancel') }}</button>
                <button type="submit" id="kt_submit" class="btn btn-primary px-4">
                    <span class="indicator-label">
                        {{ __('Save') }}
                    </span>
                    <span class="indicator-progress" style="display: none;">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        {{ __('Saving...') }}
                    </span>
                </button>
            </div>
        </div>
    </div>
    </div> <!-- End row -->
    </div> <!-- End main-content-wrapper -->
</form>

@endsection
@push('style')
<link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

<style>
.color-item, .variant-item, .shipping-item {
    background: #f8f9fa;
}

.feature-item, .specification-item {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 5px;
}

.form-control-color {
    width: 50px;
    height: 38px;
    padding: 0;
    border: 1px solid #ddd;
}

/* Sidebar Styling */
.product-sidebar {
    position: sticky;
    top: 20px;
    align-self: flex-start;
    max-height: calc(100vh - 40px);
    overflow-y: auto;
}

/* Ensure proper column spacing */
.main-content-wrapper {
    min-height: 100vh;
}

.main-content-wrapper .row {
    margin: 0;
}

.main-content-wrapper .col-lg-3,
.main-content-wrapper .col-lg-9 {
    padding-left: 15px;
    padding-right: 15px;
}

@media (max-width: 991.98px) {
    .product-sidebar {
        position: relative;
        top: auto;
        max-height: none;
        overflow-y: visible;
    }
}
</style>

@endpush
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>

<script>
// Initialize counters for dynamic forms
let colorIndex = 0;
let variantIndex = 0;
let shippingIndex = 0;

// Set initial counters based on existing data
document.addEventListener('DOMContentLoaded', function() {
    colorIndex = document.querySelectorAll('.color-item').length;
    variantIndex = document.querySelectorAll('.variant-item').length;
    shippingIndex = document.querySelectorAll('.shipping-item').length;
});

// Image input handling
    document.getElementById('imageInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                if (preview.tagName === 'IMG') {
                    preview.src = e.target.result;
                } else {
                    preview.outerHTML = '<img src="' + e.target.result + '" class="rounded mx-auto d-block" style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #e9ecef;" alt="Preview" id="imagePreview">';
                }
            };
            reader.readAsDataURL(file);
        }
    });

    function removeImage() {
        const preview = document.getElementById('imagePreview');
        if (preview.tagName === 'IMG') {
            preview.outerHTML = '<div class="bg-light border rounded d-flex align-items-center justify-content-center mx-auto position-relative" style="width: 200px; height: 200px; cursor: pointer;" id="imagePreview" onclick="document.getElementById(\'imageInput\').click()"><div class="text-center"><div style="font-size: 3rem; color: #6c757d;">📷</div><p class="text-muted fw-bold mt-2 mb-0">{{ __('Click to upload image') }}</p><small class="text-muted">PNG, JPG, JPEG</small></div></div>';
        }
        document.getElementById('imageInput').value = '';
    }

// Color functions
function addColor() {
    const container = document.getElementById('colors-container');
    if (container.querySelector('.text-muted')) {
        container.innerHTML = '';
    }
    
    const colorHtml = `
        <div class="color-item border rounded p-3 mb-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label class="form-label">Color Name</label>
                    <input type="text" name="colors[${colorIndex}][name]" class="form-control" placeholder="Red, Blue, etc.">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Color Value</label>
                    <input type="color" name="colors[${colorIndex}][value]" class="form-control form-control-color" value="#000000">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Available</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="colors[${colorIndex}][available]" value="1" checked>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeColor(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', colorHtml);
    colorIndex++;
}

function removeColor(button) {
    button.closest('.color-item').remove();
    checkEmptyContainer('colors-container', 'No colors added yet. Click "Add Color" to start.');
}

// Variant functions
function addVariant() {
    const container = document.getElementById('variants-container');
    if (container.querySelector('.text-muted')) {
        container.innerHTML = '';
    }
    
    const variantHtml = `
        <div class="variant-item border rounded p-3 mb-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <input type="text" name="variants[${variantIndex}][type]" class="form-control" placeholder="battery, size, memory">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Label</label>
                    <input type="text" name="variants[${variantIndex}][label]" class="form-control" placeholder="Battery Capacity">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Options (comma separated)</label>
                    <input type="text" name="variants[${variantIndex}][options]" class="form-control" placeholder="5100 mAh, 6200 mAh, 8000 mAh">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeVariant(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', variantHtml);
    variantIndex++;
}

function removeVariant(button) {
    button.closest('.variant-item').remove();
    checkEmptyContainer('variants-container', 'No variants added yet. Click "Add Variant" to start.');
}

// Feature functions
function addFeature() {
    const container = document.getElementById('features-container');
    if (container.querySelector('.text-muted')) {
        container.innerHTML = '';
    }
    
    const featureHtml = `
        <div class="feature-item d-flex align-items-center mb-2">
            <input type="text" name="features[]" class="form-control me-2" placeholder="Enter feature">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeFeature(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', featureHtml);
}

function removeFeature(button) {
    button.closest('.feature-item').remove();
    checkEmptyContainer('features-container', 'No features added yet. Click "Add Feature" to start.');
}

// Specification functions
function addSpecification() {
    const container = document.getElementById('specifications-container');
    if (container.querySelector('.text-muted')) {
        container.innerHTML = '';
    }
    
    const specHtml = `
        <div class="specification-item d-flex align-items-center mb-2">
            <input type="text" name="specifications_keys[]" class="form-control me-2" placeholder="Weight" style="max-width: 200px;">
            <input type="text" name="specifications_values[]" class="form-control me-2" placeholder="35.5oz (1006g)">
            <button type="button" class="btn btn-sm btn-danger" onclick="removeSpecification(this)">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', specHtml);
}

function removeSpecification(button) {
    button.closest('.specification-item').remove();
    checkEmptyContainer('specifications-container', 'No specifications added yet. Click "Add Specification" to start.');
}

// Shipping functions
function addShippingOption() {
    const container = document.getElementById('shipping-container');
    if (container.querySelector('.text-muted')) {
        container.innerHTML = '';
    }
    
    const shippingHtml = `
        <div class="shipping-item border rounded p-3 mb-3">
            <div class="row g-3 align-items-center">
                <div class="col-md-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="shipping[${shippingIndex}][name]" class="form-control" placeholder="Courier">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Time</label>
                    <input type="text" name="shipping[${shippingIndex}][time]" class="form-control" placeholder="2-4 days">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Price ($)</label>
                    <input type="number" step="0.01" name="shipping[${shippingIndex}][price]" class="form-control" placeholder="22.50">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeShippingOption(this)">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', shippingHtml);
    shippingIndex++;
}

function removeShippingOption(button) {
    button.closest('.shipping-item').remove();
    checkEmptyContainer('shipping-container', 'No shipping options added yet. Click "Add Shipping Option" to start.');
}

// Helper function to check empty containers
function checkEmptyContainer(containerId, message) {
    const container = document.getElementById(containerId);
    if (!container.querySelector('.color-item, .variant-item, .feature-item, .specification-item, .shipping-item')) {
        container.innerHTML = `<div class="text-muted text-center py-3">${message}</div>`;
    }
}

    // Form submission
    document.getElementById('kt_form').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('kt_submit');
        const indicator = submitBtn.querySelector('.indicator-label');
        const progress = submitBtn.querySelector('.indicator-progress');

        // Show loading state
        indicator.style.display = 'none';
        progress.style.display = 'inline-block';
        submitBtn.disabled = true;
    });
</script>

@endpush