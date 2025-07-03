@extends('admin.layouts.master', ['is_active_parent' => 'categories', 'is_active' => 'categories'])
@section('title', __("Categories"))

@section('content')
<div class="page-content-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="table-title">{{ __('Categories') }}</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary fw-bold">
            {{ __('Add New Category +') }}
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
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Created At') }}</th>
                    <th scope="col">{{ __('Products Count') }}</th>
                    <th scope="col" class="text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($categories->count() > 0)
                @foreach ($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($category->image)
                            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" 
                                class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center me-3" 
                                style="width: 40px; height: 40px;">
                                <span style="font-size: 1.2rem;">📁</span>
                            </div>
                            @endif
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $category->name }}</h6>
                                @if($category->description)
                                <small class="text-muted">{{ Str::limit($category->description, 30) }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($category->status == 'active')
                        <span class="badge bg-success">{{ __('Active') }}</span>
                        @else
                        <span class="badge bg-secondary">{{ __('Archived') }}</span>
                        @endif
                    </td>
                    <td>{{ $category->created_at->format('Y-m-d') }}</td>
                    <td>
                        <span class="badge bg-info">{{ $category->products_count }}</span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                class="btn btn-sm btn-outline-primary" title="{{ __('Edit') }}">
                                ✏️
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-outline-danger deleteBtn"
                                data-id="{{ $category->id }}"
                                data-name="{{ $category->name }}"
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
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📁</div>
                            <h5>{{ __('No categories found') }}</h5>
                            <p>{{ __('Start by adding your first category') }}</p>
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                {{ __('Add Category +') }}
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
    {{ $categories->links() }}
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
                <p class="text-muted">{{ __('You are about to delete category') }} "<span id="categoryName"></span>". {{ __('This action cannot be undone.') }}</p>
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
            const categoryId = this.dataset.id;
            const categoryName = this.dataset.name;
            
            document.getElementById('categoryName').textContent = categoryName;
            document.getElementById('deleteForm').action = `/admin/categories/${categoryId}`;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
});
</script>
@endpush


