@extends('layouts.app')

@section('title', 'Edit Product')

@section('page-title', 'Edit Product')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Product #{{ $product->id }}</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $product->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price *</label>
            <input type="number" step="0.01" name="price" class="form-control"
                   value="{{ old('price', $product->price) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock *</label>
            <input type="number" name="stock" class="form-control"
                   value="{{ old('stock', $product->stock) }}" required min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-control">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->category_name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Optional: Select product category</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control" maxlength="25"
                   value="{{ old('brand', $product->brand) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" style="max-width: 200px; max-height: 200px;" class="img-thumbnail">
                    <p class="text-muted small">Current image</p>
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Select new image to replace (jpg, png, jpeg, gif - max 2MB) - Leave empty to keep current image</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">-- Select Status --</option>
                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="discontinued" {{ old('status', $product->status) == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
            </select>
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured"
                   {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Featured Product</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('styles')
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<style>
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(2.25rem + 2px) !important;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
        line-height: calc(2.25rem) !important;
    }
    .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
        height: calc(2.25rem) !important;
    }
</style>
@endpush

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('assets/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(function () {
    // Initialize Select2
    $('#category_id').select2({
        theme: 'bootstrap4',
        placeholder: '-- Select Category --',
        allowClear: true
    });
    
    $('#status').select2({
        theme: 'bootstrap4',
        placeholder: '-- Select Status --',
        allowClear: true
    });
});
</script>
@endpush
