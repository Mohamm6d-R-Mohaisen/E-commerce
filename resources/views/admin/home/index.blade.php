@extends('admin.layouts.master', ['is_active_parent' => 'dashboard', 'is_active' => 'dashboard'])
@section('title', __('Dashboard'))

@section('content')
<div class="page-content-header mb-5">
    <h2 class="table-title">{{ __('Dashboard') }}</h2>
    <p class="text-muted">{{ __('Overview') }}</p>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Statistics Cards -->
<div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">{{ __('Total Products') }}</h6>
                        <h3 class="text-primary">{{ $stats['products'] ?? 0 }}</h3>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">📦</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">{{ __('Total Categories') }}</h6>
                        <h3 class="text-success">{{ $stats['categories'] ?? 0 }}</h3>
                    </div>
                    <div class="text-success" style="font-size: 2.5rem;">📁</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">{{ __('Total Users') }}</h6>
                        <h3 class="text-info">{{ $stats['users'] ?? 0 }}</h3>
                    </div>
                    <div class="text-info" style="font-size: 2.5rem;">👥</div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="card-title text-muted">{{ __('Total Orders') }}</h6>
                        <h3 class="text-warning">{{ $stats['orders'] ?? 0 }}</h3>
                    </div>
                    <div class="text-warning" style="font-size: 2.5rem;">🛒</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">{{ __('Quick Actions') }}</h5>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📦</div>
                            <h6 class="mb-0">{{ __('Add Product') }}</h6>
                        </a>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">📁</div>
                            <h6 class="mb-0">{{ __('Add Category') }}</h6>
                        </a>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <a href="#" class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">🛒</div>
                            <h6 class="mb-0">{{ __('View Orders') }}</h6>
                        </a>
                    </div>
                    
                    <div class="col-lg-3 col-md-6">
                        <a href="#" class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center p-4">
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">👥</div>
                            <h6 class="mb-0">{{ __('View Users') }}</h6>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Charts & Maps Scripts - فقط لصفحة Dashboard -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/map.js"></script> 
<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<script src="{{ asset('admin/vendors/apexcharts/dist/apexcharts.min.js') }}"></script>

<!-- Dashboard Data - مع فحص وجود العناصر -->
<script>
// فحص وجود العناصر قبل تشغيل charts
document.addEventListener('DOMContentLoaded', function() {
    // بدلاً من تضمين dashboard-data.js كاملة، سنضع فقط ما نحتاجه
    console.log('Dashboard loaded successfully');
    
    // يمكن إضافة charts هنا إذا لزم الأمر في المستقبل
});
</script>
@endpush
