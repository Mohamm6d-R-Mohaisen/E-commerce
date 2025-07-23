@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Special Offers</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.special-offers.create') }}" class="btn btn-primary">
                            Create New Offer
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($offers as $offer)
                                    <tr>
                                        <td>
                                            {{ $offer->product->name }}
                                        </td>
                                        <td>{{ $offer->start_date->format('Y-m-d H:i') }}</td>
                                        <td>{{ $offer->end_date->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <span class="badge badge-{{ $offer->isActive() ? 'success' : 'danger' }}">
                                                {{ $offer->isActive() ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.special-offers.edit', $offer) }}" 
                                               class="btn btn-sm btn-info">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.special-offers.destroy', $offer) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this offer?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No special offers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 