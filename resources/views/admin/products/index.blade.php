@extends('admin.layouts.master', ['is_active_parent' => 'products', 'is_active' => 'products'])
@section('title', __("products"))

@section('content')
<div class="page-content-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="table-title">{{ __('products Management') }}</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary fw-bold">
            {{ __('Add New Product +') }}
        </a>
    </div>
</div>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-body">
        <form method="get" action="{{URL::current()}}" class="d-flex justify-content-between mb-4">
            <input name="name" type="text" placeholder="{{ __('Name') }}" class="form-control mx-2" value="{{request('name')}}">
            <select class="form-control mx-2" name="status">
                <option value="">{{ __('ALL') }}</option>
                <option value="active"@selected(request('status')=='active')>{{ __('ACTIVE') }}</option>
                <option value="archived"@selected(request('status')=='archived')>{{ __('ARCHIVED') }}</option>
            </select>
            <button type="submit" class="btn btn-outline-primary mx-2">{{ __('Filter') }}</button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ __('Name') }}</th>
                    <th scope="col">{{ __('Category') }}</th>
                    <th scope="col">{{ __('Price') }}</th>
                    <th scope="col">{{ __('Quantity') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Created At') }}</th>
                    <th scope="col" class="text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($products->count() > 0)
                @foreach ($products as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" 
                                class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center me-3" 
                                style="width: 40px; height: 40px;">
                                <span style="font-size: 1.2rem;">📦</span>
                            </div>
                            @endif
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $product->name }}</h6>
                                @if($product->description)
                                <small class="text-muted">{{ Str::limit($product->description, 30) }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($product->category)
                        <span class="badge bg-info">{{ $product->category->name }}</span>
                        @else
                        <span class="badge bg-secondary">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="fw-bold text-success">{{ number_format($product->price, 2) }} {{ __('app.currency') }}</span>
                        @if($product->compare_price)
                        <br><small class="text-muted text-decoration-line-through">{{ number_format($product->compare_price, 2) }} {{ __('app.currency') }}</small>
                        @endif
                    </td>
                    <td>
                        @if($product->quantity == 0)
                        <span class="badge bg-danger">{{ __('Out of Stock') }}</span>
                        @elseif($product->quantity <= 5)
                        <span class="badge bg-warning">{{ __('Low Stock') }} ({{ $product->quantity }})</span>
                        @else
                        <span class="badge bg-success">{{ $product->quantity }}</span>
                        @endif
                    </td>
                    <td>
                        @if($product->status == 'active')
                        <span class="badge bg-success">{{ __('Active') }}</span>
                        @else
                        <span class="badge bg-secondary">{{ __('Archived') }}</span>
                        @endif
                    </td>
                    <td>{{ $product->created_at->format('Y-m-d') }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="btn btn-sm btn-outline-primary" title="{{ __('Edit') }}">
                                ✏️
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-outline-danger deleteBtn"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                title="{{ __('Delete') }}">
                                🗑️
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
                            <h5>{{ __('No products found') }}</h5>
                            <p>{{ __('Start by adding your first product') }}</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                {{ __('Add product +') }}
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
    {{ $products->links() }}
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
                <p class="text-muted">{{ __('You are about to delete product') }} "<span id="productName"></span>". {{ __('This action cannot be undone.') }}</p>
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
            const productId = this.dataset.id;
            const productName = this.dataset.name;
            
            document.getElementById('productName').textContent = productName;
            document.getElementById('deleteForm').action = `/admin/products/${productId}`;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
});
</script>
@endpush