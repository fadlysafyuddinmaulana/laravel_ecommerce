@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Product</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', 'Samsung Galaxy S24') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', 'Smartphone flagship dengan layar Dynamic AMOLED 6.2 inch, kamera 50MP, chipset Snapdragon 8 Gen 3, RAM 8GB, storage 256GB, baterai 4000mAh') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price *</label>
            <input type="number" step="0.01" name="price" class="form-control"
                   value="{{ old('price', '12999000') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock *</label>
            <input type="number" name="stock" class="form-control"
                   value="{{ old('stock', '50') }}" required min="0">
        </div>

        <div class="mb-3">
            <label class="form-label">Category ID</label>
            <input type="number" name="category_id" class="form-control"
                   value="{{ old('category_id', '1') }}">
            <small class="text-muted">Optional: Enter valid category ID</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Brand</label>
            <input type="text" name="brand" class="form-control" maxlength="25"
                   value="{{ old('brand', 'Samsung') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Select product image (jpg, png, jpeg, gif - max 2MB)</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">-- Select Status --</option>
                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>Discontinued</option>
            </select>
        </div>

        <div class="mb-3 form-check">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="isFeatured"
                   {{ old('is_featured') ? 'checked' : '' }}>
            <label class="form-check-label" for="isFeatured">Featured Product</label>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Create Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
