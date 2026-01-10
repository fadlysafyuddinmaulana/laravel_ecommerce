@extends('layouts.app')

@section('title', 'Create Product')

@section('page-title', 'Create Product')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    <div class="container">
        <h1 class="mb-4">Create Product</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Create New Product</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Name *</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}"
                            placeholder="Enter product name" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" rows="4"
                            placeholder="Enter product description">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="price">Price *</label>
                        <input type="number" step="0.01" name="price" class="form-control" id="price"
                            value="{{ old('price') }}" placeholder="Enter price" required>
                    </div>

                    <div class="form-group">
                        <label for="stock">Stock *</label>
                        <input type="number" name="stock" class="form-control" id="stock"
                            value="{{ old('stock', '0') }}" placeholder="Enter stock quantity" required min="0">
                    </div>

                    <div class="form-group">
                        <label for="id_category">Category</label>
                        <select name="id_category" class="form-control" id="id_category">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id_category }}"
                                    {{ old('id_category') == $category->id_category ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="id_brand">Brand</label>
                        <select name="id_brand" class="form-control" id="id_brand">
                            <option value="">-- Select Brand --</option>
                            @foreach (\App\Models\Brand::orderBy('name')->get() as $brand)
                                <option value="{{ $brand->id_brand }}"
                                    {{ old('id_brand') == $brand->id_brand ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="image" class="custom-file-input" id="image"
                                    accept="image/*">
                                <label class="custom-file-label" for="image">Choose file</label>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
                            </div>
                        </div>
                        <small class="text-muted">Select product image (jpg, png, jpeg, webp - max 2MB)</small>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" class="form-control" id="status">
                            <option value="">-- Select Status --</option>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="discontinued" {{ old('status') == 'discontinued' ? 'selected' : '' }}>
                                Discontinued</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" class="form-check-input"
                                id="isFeatured" {{ old('is_featured') ? 'checked' : '' }}>
                            <label class="form-check-label" for="isFeatured">Featured Product</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_visible" name="is_visible"
                                value="1" {{ old('is_visible', $product->is_visible ?? 1) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_visible">
                                Show in Frontend
                            </label>
                        </div>
                        <small class="form-text text-muted">
                            Uncheck to hide this product from customers
                        </small>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="hidden" name="has_discount" value="0">
                            <input type="checkbox" name="has_discount" value="1" class="form-check-input"
                                id="hasDiscount" {{ old('has_discount') ? 'checked' : '' }}>
                            <label class="form-check-label" for="hasDiscount">Product Has Discount</label>
                        </div>
                        <small class="text-muted">Enable this to mark product as having a discount (will be shown in
                            discount products section)</small>
                    </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Create Product</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE-3.2.0/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <!-- Select2 -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Page specific script -->
    <script>
        $(function() {
            // Initialize Select2
            $('#id_category').select2({
                theme: 'bootstrap4',
                placeholder: '-- Select Category --',
                allowClear: true
            });

            $('#id_brand').select2({
                theme: 'bootstrap4',
                placeholder: '-- Select Brand --',
                allowClear: true
            });

            $('#status').select2({
                theme: 'bootstrap4',
                placeholder: '-- Select Status --',
                allowClear: true
            });

            bsCustomFileInput.init();
        });
    </script>
@endpush
