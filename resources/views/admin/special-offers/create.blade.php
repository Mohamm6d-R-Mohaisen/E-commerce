@extends('admin.layouts.master', ['is_active_parent' => 'special-offers', 'is_active' => 'special-offers'])
@section('title', isset($offer) ? __("Special Offer Edit") : __("Special Offer Create"))

@section('content')
<form id="kt_form" class="form row d-flex flex-column flex-lg-row addForm"
    action="{{ isset($offer) ? route('admin.special-offers.update', $offer->id) : route('admin.special-offers.store') }}"
    method="POST"
    enctype="multipart/form-data">
    @csrf
    @isset($offer)
    @method('PATCH')
    @endisset

    <div class="page-content-header mb-5">
        <h2 class="table-title">{{ isset($offer) ? __("Special Offer Edit") : __("Special Offer Create") }}</h2>
    </div>

    <!-- Sidebar: Image -->
    <div class="col-lg-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('Offer Image') }}</h5>
            </div>
            <div class="card-body py-4 border-bottom bg-light bg-opacity-50">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-dark fs-6">{{ __('Status') }}</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch" name="status" value="active"
                            style="width: 2.5rem; height: 1.3rem;"
                            {{ (isset($offer) && $offer->status == 'active') || !isset($offer) ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                <div class="mb-3 position-relative d-inline-block">
                    @if(isset($offer) && $offer->image)
                    <img src="{{ asset($offer->image) }}" class="rounded mx-auto d-block" style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #e9ecef;" alt="{{ __('Offer Image') }}" id="imagePreview">
                    @else
                    <div class="bg-light border rounded d-flex align-items-center justify-content-center mx-auto position-relative" style="width: 200px; height: 200px; cursor: pointer;" id="imagePreview" onclick="document.getElementById('imageInput').click()">
                        <div class="text-center">
                            <div style="font-size: 3rem; color: #6c757d;">🎁</div>
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
        <div class="card">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Title') }} <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg" placeholder="{{ __('Enter offer title') }}" value="{{ isset($offer) ? $offer->title : '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Select Product') }} <span class="text-danger">*</span></label>
                        <select name="product_id" class="form-select form-select-lg" required>
                            <option value="">{{ __('Choose a product...') }}</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" 
                                    {{ (isset($offer) && $offer->product_id == $product->id) ? 'selected' : '' }}>
                                    {{ $product->name }} - ${{ number_format($product->price, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Discount Percentage') }} <span class="text-danger">*</span></label>
                        <input type="number" name="discount_percentage" class="form-control form-control-lg" placeholder="50" value="{{ isset($offer) ? $offer->discount_percentage : '' }}" min="1" max="100" required>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="{{ __('Enter offer description') }}">{{ isset($offer) ? $offer->description : '' }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Start Date') }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="start_date" class="form-control" value="{{ isset($offer) && $offer->start_date ? $offer->start_date->format('Y-m-d\TH:i') : '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('End Date') }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="end_date" class="form-control" value="{{ isset($offer) && $offer->end_date ? $offer->end_date->format('Y-m-d\TH:i') : '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Button Text') }}</label>
                        <input type="text" name="button_text" class="form-control" placeholder="{{ __('Shop Now') }}" value="{{ isset($offer) ? $offer->button_text : '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Button URL') }}</label>
                        <input type="url" name="button_url" class="form-control" placeholder="{{ __('https://example.com') }}" value="{{ isset($offer) ? $offer->button_url : '' }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Sort Order') }}</label>
                        <input type="number" name="sort_order" class="form-control" placeholder="0" value="{{ isset($offer) ? $offer->sort_order : 0 }}" min="0">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Featured') }}</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" role="switch" name="is_featured" value="1"
                                {{ (isset($offer) && $offer->is_featured) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ __('Mark as Featured') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.special-offers.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
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
</form>
@endsection

@push('scripts')
<script>
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

    // Remove image function
    function removeImage() {
        const preview = document.getElementById('imagePreview');
        if (preview.tagName === 'IMG') {
            preview.outerHTML = '<div class="bg-light border rounded d-flex align-items-center justify-content-center mx-auto position-relative" style="width: 200px; height: 200px; cursor: pointer;" id="imagePreview" onclick="document.getElementById(\'imageInput\').click()"><div class="text-center"><div style="font-size: 3rem; color: #6c757d;">🎁</div><p class="text-muted fw-bold mt-2 mb-0">{{ __("Click to upload image") }}</p><small class="text-muted">PNG, JPG, JPEG</small></div></div>';
        }
        document.getElementById('imageInput').value = '';
    }

    // Date validation
    document.querySelector('input[name="end_date"]').addEventListener('change', function() {
        const startDate = document.querySelector('input[name="start_date"]').value;
        const endDate = this.value;
        
        if (startDate && endDate && new Date(endDate) <= new Date(startDate)) {
            alert('{{ __("End date must be after start date") }}');
            this.value = '';
        }
    });

    // Form submission
    document.getElementById('kt_form').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('kt_submit');
        const indicator = submitBtn.querySelector('.indicator-label');
        const progress = submitBtn.querySelector('.indicator-progress');

        indicator.style.display = 'none';
        progress.style.display = 'inline-block';
        submitBtn.disabled = true;
    });
</script>
@endpush 