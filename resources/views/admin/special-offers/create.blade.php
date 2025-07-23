@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ isset($specialOffer) ? 'Edit Special Offer' : 'Create Special Offer' }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ isset($specialOffer) ? route('admin.special-offers.update', $specialOffer) : route('admin.special-offers.store') }}" 
                          method="POST">
                        @csrf
                        @if(isset($specialOffer))
                            @method('PUT')
                        @endif

                        <div class="form-group">
                            <label for="product_id">Select Product</label>
                            <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                                <option value="">Select a product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                            {{ old('product_id', $specialOffer->product_id ?? '') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - {{ number_format($product->price, 2) }} {{ __('app.currency') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="datetime-local" 
                                   name="start_date" 
                                   id="start_date" 
                                   class="form-control @error('start_date') is-invalid @enderror"
                                   value="{{ old('start_date', isset($specialOffer) ? $specialOffer->start_date->format('Y-m-d\TH:i') : '') }}"
                                   required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="datetime-local" 
                                   name="end_date" 
                                   id="end_date" 
                                   class="form-control @error('end_date') is-invalid @enderror"
                                   value="{{ old('end_date', isset($specialOffer) ? $specialOffer->end_date->format('Y-m-d\TH:i') : '') }}"
                                   required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" 
                                       class="custom-control-input" 
                                       id="status" 
                                       name="status" 
                                       value="1"
                                       {{ old('status', $specialOffer->status ?? true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($specialOffer) ? 'Update' : 'Create' }} Special Offer
                            </button>
                            <a href="{{ route('admin.special-offers.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 