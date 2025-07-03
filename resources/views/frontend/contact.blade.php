@extends('frontend.layout')

@section('title', __('app.contact_us'))

@section('content')
<!-- Start Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="breadcrumbs-content">
                    <h1 class="page-title">{{ __('app.contact_us') }}</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <ul class="breadcrumb-nav">
                    <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> {{ __('app.home') }}</a></li>
                    <li>{{ __('app.contact_us') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Contact Us -->
<section id="contact-us" class="contact-us section">
    <div class="container">
        <div class="contact-head">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>{{ __('app.contact_us') }}</h2>
                        <p>{{ __('app.contact_form_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="contact-info">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="single-info-head">
                            <!-- Start Single Info -->
                            <div class="single-info">
                                <i class="lni lni-map"></i>
                                <h3>{{ __('app.address') }}</h3>
                                <ul>
                                    <li>{!! nl2br(e($contactInfo['address'])) !!}</li>
                                </ul>
                            </div>
                            <!-- End Single Info -->
                            <!-- Start Single Info -->
                            <div class="single-info">
                                <i class="lni lni-phone"></i>
                                <h3>{{ __('app.call_us_on') }}</h3>
                                <ul>
                                    @if($contactInfo['phone_primary'])
                                        <li><a href="tel:{{ str_replace([' ', '-', '(', ')'], '', $contactInfo['phone_primary']) }}">{{ $contactInfo['phone_primary'] }} ({{ __('app.free') }})</a></li>
                                    @endif
                                    @if($contactInfo['phone_secondary'])
                                        <li><a href="tel:{{ str_replace([' ', '-', '(', ')'], '', $contactInfo['phone_secondary']) }}">{{ $contactInfo['phone_secondary'] }}</a></li>
                                    @endif
                                </ul>
                            </div>
                            <!-- End Single Info -->
                            <!-- Start Single Info -->
                            <div class="single-info">
                                <i class="lni lni-envelope"></i>
                                <h3>{{ __('app.mail_at') }}</h3>
                                <ul>
                                    @if($contactInfo['support_email'])
                                        <li><a href="mailto:{{ $contactInfo['support_email'] }}">{{ $contactInfo['support_email'] }}</a></li>
                                    @endif
                                    @if($contactInfo['email'])
                                        <li><a href="mailto:{{ $contactInfo['email'] }}">{{ $contactInfo['email'] }}</a></li>
                                    @endif
                                </ul>
                            </div>
                            <!-- End Single Info -->
                            @if($contactInfo['working_hours'])
                            <!-- Start Single Info -->
                            <div class="single-info">
                                <i class="lni lni-clock"></i>
                                <h3>{{ __('app.working_hours') }}</h3>
                                <ul>
                                    <li>{!! nl2br(e($contactInfo['working_hours'])) !!}</li>
                                </ul>
                            </div>
                            <!-- End Single Info -->
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-12 col-12">
                        <div class="contact-form-head">
                            <!-- Display Success/Error Messages -->
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="lni lni-checkmark"></i> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="lni lni-warning"></i> {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
                                </div>
                            @endif

                            <div class="form-main">
                                <form class="form" method="POST" action="{{ route('contact.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <input name="name" type="text" placeholder="{{ __('app.your_name') }}" 
                                                       value="{{ old('name') }}" required class="@error('name') is-invalid @enderror">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <input name="subject" type="text" placeholder="{{ __('app.subject') }}" 
                                                       value="{{ old('subject') }}" required class="@error('subject') is-invalid @enderror">
                                                @error('subject')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <input name="email" type="email" placeholder="{{ __('app.your_email') }}" 
                                                       value="{{ old('email') }}" required class="@error('email') is-invalid @enderror">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-12">
                                            <div class="form-group">
                                                <input name="phone" type="text" placeholder="{{ __('app.your_phone') }}" 
                                                       value="{{ old('phone') }}" class="@error('phone') is-invalid @enderror">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group message">
                                                <textarea name="message" id="message" placeholder="{{ __('app.enter_message') }}" 
                                                          required class="@error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                                                @error('message')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group button">
                                                <button type="submit" class="btn" id="submit-btn">
                                                    <span class="btn-text">{{ __('app.send_message') }}</span>
                                                    <span class="btn-loading" style="display: none;">
                                                        <i class="lni lni-spinner"></i> {{ __('app.please_wait') }}...
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Contact Us -->


@endsection

@push('style')
<style>
    /* Custom styles for alerts and form enhancements */
    .alert {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 4px;
        border: 1px solid transparent;
    }
    
    .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    
    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
    }
    
    .btn-close {
        background: none;
        border: none;
        font-size: 16px;
        opacity: 0.5;
        cursor: pointer;
        float: right;
    }
    
    .btn-close:hover {
        opacity: 1;
    }
    
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
    }
    
    /* Loading animation */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .btn-loading i {
        animation: spin 1s linear infinite;
        margin-right: 5px;
    }
    
    .contact-us .form-group.button .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }
    
    /* Character counter styles */
    .character-counter {
        text-align: right;
        font-size: 12px;
        color: #666;
        margin-top: 5px;
        transition: color 0.3s ease;
    }
</style>
@endpush

@push('script')
<script>
    // Auto hide alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(function() {
                    if (alert.parentNode) {
                        alert.parentNode.removeChild(alert);
                    }
                }, 500);
            }
        });
    }, 5000);
    
    // Form validation enhancement
    const form = document.querySelector('.form');
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    const submitBtn = document.getElementById('submit-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoading = submitBtn.querySelector('.btn-loading');
    
    inputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim() !== '') {
                this.classList.remove('is-invalid');
            }
        });
    });
    
    // Email validation
    const emailInput = form.querySelector('input[name="email"]');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            if (this.value && !emailRegex.test(this.value)) {
                this.classList.add('is-invalid');
            }
        });
    }
    
    // Form submission with loading state
    form.addEventListener('submit', function(e) {
        // Show loading state
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline-block';
        
        // Remove loading state after 3 seconds (in case form doesn't redirect)
        setTimeout(function() {
            submitBtn.disabled = false;
            btnText.style.display = 'inline-block';
            btnLoading.style.display = 'none';
        }, 3000);
    });
    
    // Character counter for message field
    const messageField = document.getElementById('message');
    const maxLength = 2000;
    
    if (messageField) {
        // Create character counter element
        const counter = document.createElement('div');
        counter.className = 'character-counter';
        messageField.parentNode.appendChild(counter);
        
        function updateCounter() {
            const remaining = maxLength - messageField.value.length;
            counter.textContent = remaining + ' characters remaining';
            
            if (remaining < 100) {
                counter.style.color = '#dc3545';
            } else if (remaining < 200) {
                counter.style.color = '#ffc107';
            } else {
                counter.style.color = '#666';
            }
        }
        
        messageField.addEventListener('input', updateCounter);
        updateCounter(); // Initialize counter
    }
</script>
@endpush 