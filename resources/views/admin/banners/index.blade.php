@extends('admin.layouts.master', ['is_active_parent' => 'banners', 'is_active' => 'banners'])

@section('title', __("Banners Management"))

@section('content')
<div class="page-content-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="table-title">{{ __('Banners Management') }}</h2>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-primary fw-bold">
            {{ __('Add New Banner +') }}
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
                    <th scope="col">{{ __('Title') }}</th>
                    <th scope="col">{{ __('Type') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Sort Order') }}</th>
                    <th scope="col" class="text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($banners->count() > 0)
                @foreach ($banners as $index => $banner)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($banner->background_image)
                            <img src="{{ asset($banner->background_image) }}" alt="{{ $banner->title }}" 
                                class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center me-3" 
                                style="width: 40px; height: 40px;">
                                <span style="font-size: 1.2rem;">🖼️</span>
                            </div>
                            @endif
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $banner->title }}</h6>
                                @if($banner->subtitle)
                                <small class="text-muted">{{ Str::limit($banner->subtitle, 30) }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-secondary">{{ $banner->type_label }}</span>
                    </td>
                    <td>
                        @if($banner->status == 'active')
                        <span class="badge bg-success">{{ __('Active') }}</span>
                        @else
                        <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-info">{{ $banner->sort_order ?? 0 }}</span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.banners.edit', $banner->id) }}"
                                class="btn btn-sm btn-outline-primary" title="{{ __('Edit') }}">
                                ✏️
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-outline-danger deleteBtn"
                                data-id="{{ $banner->id }}"
                                data-name="{{ $banner->title }}"
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
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🖼️</div>
                            <h5>{{ __('No banners found') }}</h5>
                            <p>{{ __('Start by adding your first banner') }}</p>
                            <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">
                                {{ __('Add Banner +') }}
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
    {{ $banners->links() }}
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
                <p class="text-muted">{{ __('You are about to delete banner') }} "<span id="bannerName"></span>". {{ __('This action cannot be undone.') }}</p>
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
            const bannerId = this.dataset.id;
            const bannerName = this.dataset.name;
            
            document.getElementById('bannerName').textContent = bannerName;
            document.getElementById('deleteForm').action = `/admin/banners/${bannerId}`;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
});
</script>
@endpush 