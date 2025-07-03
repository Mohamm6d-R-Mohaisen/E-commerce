@extends('admin.layouts.master', ['is_active_parent' => 'special-offers', 'is_active' => 'special-offers'])

@section('title', __('Special Offers Management'))

@section('content')
<div class="page-content-header mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="table-title">{{ __('Special Offers Management') }}</h2>
        <a href="{{ route('admin.special-offers.create') }}" class="btn btn-primary fw-bold">
            {{ __('Add New Offer +') }}
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
                    <th scope="col">{{ __('Offer') }}</th>
                    <th scope="col">{{ __('Discount') }}</th>
                    <th scope="col">{{ __('Status') }}</th>
                    <th scope="col">{{ __('Period') }}</th>
                    <th scope="col" class="text-center">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if($offers->count() > 0)
                @foreach ($offers as $index => $offer)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($offer->image)
                            <img src="{{ asset($offer->image) }}" alt="{{ $offer->title }}" 
                                class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                            @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center me-3" 
                                style="width: 40px; height: 40px;">
                                <span style="font-size: 1.2rem;">🎁</span>
                            </div>
                            @endif
                            <div>
                                <h6 class="mb-1 fw-bold">{{ $offer->title }}</h6>
                                @if($offer->description)
                                <small class="text-muted">{{ Str::limit($offer->description, 30) }}</small>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-warning text-dark">{{ $offer->discount_percentage ?? 0 }}%</span>
                    </td>
                    <td>
                        @if($offer->status == 'active')
                        <span class="badge bg-success">{{ __('Active') }}</span>
                        @else
                        <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                        @endif
                    </td>
                    <td>
                        <small>
                            {{ $offer->start_date ? $offer->start_date->format('M d') : 'N/A' }} - 
                            {{ $offer->end_date ? $offer->end_date->format('M d') : 'N/A' }}
                        </small>
                    </td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.special-offers.edit', $offer->id) }}"
                                class="btn btn-sm btn-outline-primary" title="{{ __('Edit') }}">
                                ✏️
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-outline-danger deleteBtn"
                                data-id="{{ $offer->id }}"
                                data-name="{{ $offer->title }}"
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
                            <div style="font-size: 3rem; margin-bottom: 1rem;">🎁</div>
                            <h5>{{ __('No offers found') }}</h5>
                            <p>{{ __('Start by adding your first special offer') }}</p>
                            <a href="{{ route('admin.special-offers.create') }}" class="btn btn-primary">
                                {{ __('Add Offer +') }}
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
    {{ $offers->links() }}
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
                <p class="text-muted">{{ __('You are about to delete offer') }} "<span id="offerName"></span>". {{ __('This action cannot be undone.') }}</p>
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
            const offerId = this.dataset.id;
            const offerName = this.dataset.name;
            
            document.getElementById('offerName').textContent = offerName;
            document.getElementById('deleteForm').action = `/admin/special-offers/${offerId}`;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        });
    });
});
</script>
@endpush 