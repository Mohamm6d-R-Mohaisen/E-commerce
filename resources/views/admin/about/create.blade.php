@extends('admin.layouts.master')

@section('title', isset($about) ? 'Edit About Us Content' : 'Create About Us Content')

@section('content')
<div class="container-xxl">
    <div class="hk-pg-header pt-7">
        <div class="d-flex">
            <div class="flex-1">
                <h1 class="pg-title">{{ isset($about) ? 'Edit About Us Content' : 'Create About Us Content' }}</h1>
                <p>{{ isset($about) ? 'Update your About Us page content' : 'Add new content for your About Us page' }}</p>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-xl-12">
            <section class="hk-sec-wrapper">
                <div class="row">
                    <div class="col-sm">
                        <form action="{{ isset($about) ? route('admin.about.update', $about) : route('admin.about.store') }}" 
                              method="POST" enctype="multipart/form-data">
                            @csrf
                            @isset($about)
                                @method('PUT')
                            @endisset
                            
                            <div class="form-group">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                       name="title" value="{{ isset($about) ? $about->title : old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          name="description" rows="3" required>{{ isset($about) ? $about->description : old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          name="content" rows="8" required>{{ isset($about) ? $about->content : old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Image</label>
                                @if(isset($about) && $about->image)
                                    <div class="mb-2">
                                        <img src="{{ $about->image }}" alt="Current Image" 
                                             class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                        <p class="text-muted small">Current image</p>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                       name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Leave empty to keep current image</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Video URL</label>
                                <input type="url" class="form-control @error('video_url') is-invalid @enderror" 
                                       name="video_url" value="{{ isset($about) ? $about->video_url : old('video_url') }}">
                                @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" 
                                           name="is_active" value="1" 
                                           {{ (isset($about) && $about->is_active) || (!isset($about) && old('is_active', 1)) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.about.index') }}" class="btn btn-secondary me-2">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($about) ? 'Update Content' : 'Save Content' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
