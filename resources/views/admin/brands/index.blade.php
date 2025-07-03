@extends('admin.layouts.master', ['is_active_parent' => 'brands', 'is_active' => 'brands'])

@section('title', __('Brands Management'))

@section('content')
<div class="page-content-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="table-title">{{ __('Brands Management') }}</h2>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary fw-bold">
            {{ __('Add New Brand +') }}
        </a>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Brand') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Sort Order') }}</th>
                    <th scope="col">{{ __('Created At') }}</th>
                    <th scope="col" class="text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($brands->count() > 0)
                @foreach ($brands as $index => $brand)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($brand->logo)
                            <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}" 
                                class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center me-3" 
                                style="width: 40px; height: 40px;">
                                <span style="font-size: 1.2rem;">🏷️</span>
                            </div>
                            @endif
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $brand->name }}</h6>
                                @if($brand->website_url)
                                <small class="text-muted">{{ $brand->website_url }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($brand->status == 'active')
                        <span class="badge bg-success">{{ __('Active') }}</span>
                        @else
                        <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $brand->sort_order ?? 0 }}</span>
                    </td>
                    <td>{{ $brand->created_at->format('Y-m-d') }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.brands.edit', $brand->id) }}"
                                class="btn btn-sm btn-outline-primary" title="{{ __('Edit') }}">
                                ✏️
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-outline-danger deleteBtn"
                                data-id="{{ $brand->id }}"
                                data-name="{{ $brand->name }}"
                                title="{{ __('Delete') }}">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🏷️</div>
                            <h5>{{ __('No brands found') }}</h5>
                            <p>{{ __('Start by adding your first brand') }}</p>
                            <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
                                {{ __('Add Brand +') }}
                            </a>
                        </div>
                    </td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $brands->links() }}
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Confirm Delete') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>{{ __('Are you sure?') }}</h6>
                <p class="text-muted">{{ __('You are about to delete brand') }} "<span id="brandName"></span>". {{ __('This action cannot be undone.') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">{{ __('Yes, Delete') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Delete confirmation
    document.querySelectorAll('.deleteBtn').forEach(button => {
        button.addEventListener('click', function() {
            const brandId = this.dataset.id;
            const brandName = this.dataset.name;
            
            document.getElementById('brandName').textContent = brandName;
            document.getElementById('deleteForm').action = `/admin/brands/${brandId}`;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
});
</script>
@endpush 