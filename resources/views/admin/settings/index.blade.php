@extends('admin.layouts.master', ['is_active_parent' => 'settings', 'is_active' => 'settings'])
@section('title', __("Settings Management"))

@section('content')
<div class="page-content-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="table-title">{{ __('Settings Management') }}</h2>
        <div class="btn-group">
            <a href="{{ route('admin.settings.initialize') }}" class="btn btn-outline-secondary fw-bold">
                🔄 {{ __('Initialize Defaults') }}
            </a>
            <a href="{{ route('admin.settings.clear-cache') }}" class="btn btn-outline-warning fw-bold">
                🗑️ {{ __('Clear Cache') }}
            </a>
        </div>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if (session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h6 class="alert-heading mb-2">{{ __('Validation Errors') }}</h6>
    <ul class="mb-0">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($settingsGrouped->count() > 0)
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    @foreach($settingsGrouped as $group => $settings)
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                @switch($group)
                    @case('general')
                        🌐 {{ __('General Settings') }}
                        @break
                    @case('contact')
                        📞 {{ __('Contact Information') }}
                        @break
                    @case('social')
                        📱 {{ __('Social Media') }}
                        @break
                    @default
                        ⚙️ {{ ucfirst($group) }} {{ __('Settings') }}
                @endswitch
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($settings as $setting)
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="{{ $setting->key }}" class="form-label fw-bold">
                            {{ $setting->label }}
                            @if(in_array($setting->key, ['site_name', 'contact_email']))
                                <span class="text-danger">*</span>
                            @endif
                        </label>
                        
                        @if($setting->description)
                        <div class="form-text text-muted mb-2">{{ $setting->description }}</div>
                        @endif
                        
                        @switch($setting->type)
                            @case('textarea')
                                <textarea 
                                    name="{{ $setting->key }}" 
                                    id="{{ $setting->key }}" 
                                    class="form-control" 
                                    rows="4"
                                    placeholder="{{ $setting->label }}">{{ old($setting->key, $setting->value) }}</textarea>
                                @break
                                
                            @case('email')
                                <input 
                                    type="email" 
                                    name="{{ $setting->key }}" 
                                    id="{{ $setting->key }}" 
                                    class="form-control" 
                                    value="{{ old($setting->key, $setting->value) }}"
                                    placeholder="{{ $setting->label }}">
                                @break
                                
                            @case('phone')
                                <input 
                                    type="tel" 
                                    name="{{ $setting->key }}" 
                                    id="{{ $setting->key }}" 
                                    class="form-control" 
                                    value="{{ old($setting->key, $setting->value) }}"
                                    placeholder="{{ $setting->label }}">
                                @break
                                
                            @case('url')
                                <input 
                                    type="url" 
                                    name="{{ $setting->key }}" 
                                    id="{{ $setting->key }}" 
                                    class="form-control" 
                                    value="{{ old($setting->key, $setting->value) }}"
                                    placeholder="{{ $setting->label }}">
                                @break
                                
                            @case('image')
                                @if($setting->value)
                                <div class="mb-3">
                                    <img src="{{ asset($setting->value) }}" 
                                         alt="{{ $setting->label }}" 
                                         class="img-thumbnail" 
                                         style="max-width: 150px; max-height: 150px;">
                                    <div class="form-text">{{ __('Current image') }}</div>
                                </div>
                                @endif
                                <input 
                                    type="file" 
                                    name="{{ $setting->key }}" 
                                    id="{{ $setting->key }}" 
                                    class="form-control" 
                                    accept="image/*">
                                <div class="form-text">{{ __('Accepted formats: JPG, PNG, GIF. Max size: 2MB') }}</div>
                                @break
                                
                            @case('checkbox')
                                <div class="form-check form-switch">
                                    <input 
                                        type="checkbox" 
                                        name="{{ $setting->key }}" 
                                        id="{{ $setting->key }}" 
                                        class="form-check-input" 
                                        value="1"
                                        {{ old($setting->key, $setting->value) == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="{{ $setting->key }}">
                                        {{ __('Enable') }} {{ $setting->label }}
                                    </label>
                                </div>
                                @break
                                
                            @case('number')
                                <input 
                                    type="number" 
                                    name="{{ $setting->key }}" 
                                    id="{{ $setting->key }}" 
                                    class="form-control" 
                                    value="{{ old($setting->key, $setting->value) }}"
                                    placeholder="{{ $setting->label }}">
                                @break
                                
                            @default
                                <input 
                                    type="text" 
                                    name="{{ $setting->key }}" 
                                    id="{{ $setting->key }}" 
                                    class="form-control" 
                                    value="{{ old($setting->key, $setting->value) }}"
                                    placeholder="{{ $setting->label }}">
                        @endswitch
                        
                        <div class="form-text">
                            <small class="text-muted">
                                {{ __('Key') }}: <code>{{ $setting->key }}</code> | 
                                {{ __('Type') }}: <span class="badge bg-light text-dark">{{ $setting->type }}</span>
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
    
    <!-- Save Button -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-lg fw-bold">
                    💾 {{ __('Save All Settings') }}
                </button>
            </div>
        </div>
    </div>
</form>
@else
<div class="card">
    <div class="card-body text-center py-5">
        <div class="text-muted">
            <div style="font-size: 3rem; margin-bottom: 1rem;">⚙️</div>
            <h5>{{ __('No settings found') }}</h5>
            <p>{{ __('Initialize default settings to get started') }}</p>
            <a href="{{ route('admin.settings.initialize') }}" class="btn btn-primary">
                🔄 {{ __('Initialize Default Settings') }}
            </a>
        </div>
    </div>
</div>
@endif
@endsection

@push('styles')
<style>
.form-label {
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.form-text {
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

code {
    background-color: #f1f3f4;
    padding: 2px 4px;
    border-radius: 3px;
    font-size: 0.8rem;
}

.card-header h5 {
    color: #495057;
}

.form-check-input:checked {
    background-color: #198754;
    border-color: #198754;
}

.img-thumbnail {
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    padding: 0.25rem;
}

.btn-lg {
    padding: 0.75rem 2rem;
    font-size: 1.1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.text-danger {
    color: #dc3545 !important;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image preview functionality
    const imageInputs = document.querySelectorAll('input[type="file"][accept="image/*"]');
    
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Find existing preview or create new one
                    let preview = input.parentNode.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('div');
                        preview.className = 'image-preview mt-2';
                        input.parentNode.appendChild(preview);
                    }
                    
                    preview.innerHTML = `
                        <img src="${e.target.result}" 
                             class="img-thumbnail" 
                             style="max-width: 150px; max-height: 150px;">
                        <div class="form-text">${file.name} (Preview)</div>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    });
    
    // Form validation
    const form = document.querySelector('form');
    if (form) {
        const requiredFields = form.querySelectorAll('input[name="site_name"], input[name="contact_email"]');
        
        form.addEventListener('submit', function(e) {
            let hasErrors = false;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    hasErrors = true;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
            
            if (hasErrors) {
                e.preventDefault();
                alert('{{ __("Please fill in all required fields") }}');
            }
        });
        
        // Add save confirmation
        form.addEventListener('submit', function(e) {
            if (!confirm('{{ __("Are you sure you want to save all settings?") }}')) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endpush 