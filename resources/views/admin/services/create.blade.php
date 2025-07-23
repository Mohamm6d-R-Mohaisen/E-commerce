@extends('admin.layouts.master', ['is_active_parent' => 'services', 'is_active' => 'services'])

@section('title', isset($service) ? __("Edit Service") : __("Create Service"))

@section('content')
<div class="page-content-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="table-title">
            {{ isset($service) ? __('Edit Service') : __('Create Service') }}
        </h2>
        <a href="{{ route('admin.services.index') }}" class="btn btn-secondary fw-bold">
            {{ __('← Back to Services') }}
        </a>
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ isset($service) ? route('admin.services.update', $service->id) : route('admin.services.store') }}" 
              method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($service))
                @method('PUT')
            @endif

            <div class="row">
                <!-- Service Name -->
                <div class="col-md-6 mb-3">
                    <label for="name" class="form-label">{{ __('Service Name') }} <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('name') is-invalid @enderror" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $service->name ?? '') }}" 
                           placeholder="{{ __('Enter service name') }}" 
                           required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Icon -->
                <div class="col-md-6 mb-3">
                    <label for="icon" class="form-label">{{ __('Icon Class') }} <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" 
                               class="form-control @error('icon') is-invalid @enderror" 
                               id="icon" 
                               name="icon" 
                               value="{{ old('icon', $service->icon ?? '') }}" 
                               placeholder="{{ __('e.g., lni lni-delivery') }}" 
                               required>
                        <span class="input-group-text">
                            <i id="iconPreview" class="{{ old('icon', $service->icon ?? 'lni lni-delivery') }}"></i>
                        </span>
                    </div>
                    <small class="form-text text-muted">
                        {{ __('Use LineIcons classes. Visit') }} 
                        <a href="https://lineicons.com/" target="_blank">lineicons.com</a> 
                        {{ __('for available icons') }}
                    </small>
                    @error('icon')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="col-12 mb-3">
                    <label for="description" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3" 
                              placeholder="{{ __('Enter service description') }}" 
                              required>{{ old('description', $service->description ?? '') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                        <option value="active" {{ old('status', $service->status ?? 'active') == 'active' ? 'selected' : '' }}>
                            {{ __('Active') }}
                        </option>
                        <option value="inactive" {{ old('status', $service->status ?? '') == 'inactive' ? 'selected' : '' }}>
                            {{ __('Inactive') }}
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div class="col-md-6 mb-3">
                    <label for="sort_order" class="form-label">{{ __('Sort Order') }}</label>
                    <input type="number" 
                           class="form-control @error('sort_order') is-invalid @enderror" 
                           id="sort_order" 
                           name="sort_order" 
                           value="{{ old('sort_order', $service->sort_order ?? '') }}" 
                           placeholder="{{ __('Enter sort order') }}" 
                           min="0">
                    <small class="form-text text-muted">{{ __('Lower numbers appear first') }}</small>
                    @error('sort_order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.services.index') }}" class="btn btn-secondary">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="btn btn-primary">
                    {{ isset($service) ? __('Update Service') : __('Create Service') }}
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Common Icons Reference -->
<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">{{ __('Common Service Icons') }}</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="d-flex align-items-center p-2 border rounded">
                    <i class="lni lni-delivery me-2" style="font-size: 1.2rem;"></i>
                    <code>lni lni-delivery</code>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex align-items-center p-2 border rounded">
                    <i class="lni lni-support me-2" style="font-size: 1.2rem;"></i>
                    <code>lni lni-support</code>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex align-items-center p-2 border rounded">
                    <i class="lni lni-credit-cards me-2" style="font-size: 1.2rem;"></i>
                    <code>lni lni-credit-cards</code>
                </div>
            </div>
            <div class="col-md-3">
                <div class="d-flex align-items-center p-2 border rounded">
                    <i class="lni lni-reload me-2" style="font-size: 1.2rem;"></i>
                    <code>lni lni-reload</code>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Icon preview functionality
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('iconPreview');

    iconInput.addEventListener('input', function() {
        const iconClass = this.value.trim();
        if (iconClass) {
            iconPreview.className = iconClass;
        } else {
            iconPreview.className = 'lni lni-delivery';
        }
    });
});
</script>
@endpush 