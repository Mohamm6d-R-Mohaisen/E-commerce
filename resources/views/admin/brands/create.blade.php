@extends('admin.layouts.master', ['is_active_parent' => 'brands', 'is_active' => 'brands'])
@section('title', isset($brand) ? __("Brand Edit") : __("Brand Create"))

@section('content')
<form id="kt_form" class="form row d-flex flex-column flex-lg-row addForm"
    action="{{ isset($brand) ? route('admin.brands.update', $brand->id) : route('admin.brands.store') }}"
    method="POST"
    enctype="multipart/form-data">
    @csrf
    @isset($brand)
    @method('PATCH')
    @endisset

    <div class="page-content-header mb-5">
        <h2 class="table-title">{{ isset($brand) ? __("Brand Edit") : __("Brand Create") }}</h2>
    </div>

    <!-- Sidebar: Logo -->
    <div class="col-lg-3 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('Brand Logo') }}</h5>
            </div>
            <div class="card-body py-4 border-bottom bg-light bg-opacity-50">
                <div class="d-flex align-items-center justify-content-between">
                    <span class="fw-bold text-dark fs-6">{{ __('Status') }}</span>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="statusSwitch" name="status" value="active"
                            style="width: 2.5rem; height: 1.3rem;"
                            {{ (isset($brand) && $brand->status == 'active') || !isset($brand) ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                <div class="mb-3 position-relative d-inline-block">
                    @if(isset($brand) && $brand->logo)
                    <img src="{{ asset($brand->logo) }}" class="rounded mx-auto d-block" style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #e9ecef;" alt="{{ __('Brand Logo') }}" id="imagePreview">
                    @else
                    <div class="bg-light border rounded d-flex align-items-center justify-content-center mx-auto position-relative" style="width: 200px; height: 200px; cursor: pointer;" id="imagePreview" onclick="document.getElementById('imageInput').click()">
                        <div class="text-center">
                            <div style="font-size: 3rem; color: #6c757d;">🏷️</div>
                            <p class="text-muted fw-bold mt-2 mb-0">{{ __('Click to upload logo') }}</p>
                            <small class="text-muted">PNG, JPG, JPEG, SVG</small>
                        </div>
                    </div>
                    @endif

                    <!-- Change Logo Button -->
                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px shadow"
                        data-kt-image-input-action="change" title="{{ __('Change logo') }}"
                        style="position: absolute; top: -10px; right: -10px; background: rgba(255,255,255,0.8);">
                        <span class="fs-7">✏️</span>
                        <input type="file" name="logo" accept=".png, .jpg, .jpeg, .svg" id="imageInput" style="display: none;" />
                    </label>

                    <!-- Remove Button -->
                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px shadow"
                        data-kt-image-input-action="remove" title="{{ __('Remove logo') }}"
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
                        <label class="form-label fw-semibold">{{ __('Brand Name') }} <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-control-lg" placeholder="{{ __('Enter brand name') }}" value="{{ isset($brand) ? $brand->name : '' }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Slug') }}</label>
                        <input type="text" name="slug" class="form-control form-control-lg" placeholder="{{ __('Auto-generated from name') }}" value="{{ isset($brand) ? $brand->slug : '' }}">
                        <div class="form-text">{{ __('Leave empty to auto-generate from name') }}</div>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Website URL') }}</label>
                        <input type="url" name="website_url" class="form-control" placeholder="{{ __('https://example.com') }}" value="{{ isset($brand) ? $brand->website_url : '' }}">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="{{ __('Enter brand description') }}">{{ isset($brand) ? $brand->description : '' }}</textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">{{ __('Sort Order') }}</label>
                        <input type="number" name="sort_order" class="form-control" placeholder="0" value="{{ isset($brand) ? $brand->sort_order : 0 }}" min="0">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.brands.index') }}" class="btn btn-light">{{ __('Cancel') }}</a>
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
    // Auto-generate slug from name
    document.querySelector('input[name="name"]').addEventListener('input', function(e) {
        const name = e.target.value;
        const slug = name.toLowerCase()
                        .replace(/[^a-z0-9 -]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .trim('-');
        document.querySelector('input[name="slug"]').value = slug;
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

    // Remove image function
    function removeImage() {
        const preview = document.getElementById('imagePreview');
        if (preview.tagName === 'IMG') {
            preview.outerHTML = '<div class="bg-light border rounded d-flex align-items-center justify-content-center mx-auto position-relative" style="width: 200px; height: 200px; cursor: pointer;" id="imagePreview" onclick="document.getElementById(\'imageInput\').click()"><div class="text-center"><div style="font-size: 3rem; color: #6c757d;">🏷️</div><p class="text-muted fw-bold mt-2 mb-0">{{ __("Click to upload logo") }}</p><small class="text-muted">PNG, JPG, JPEG, SVG</small></div></div>';
        }
        document.getElementById('imageInput').value = '';
    }

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