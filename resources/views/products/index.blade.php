@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container">
    <h1 class="mb-4">Products</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter dan search --}}
    <form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" value="{{ request('search') }}"
                   class="form-control" placeholder="Search name...">
        </div>
        <div class="col-md-3">
            <input type="number" name="category_id" value="{{ request('category_id') }}"
                   class="form-control" placeholder="Category ID">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" type="submit">Filter</button>
        </div>
        <div class="col-md-2">
            <a href="{{ route('products.index') }}" class="btn btn-secondary w-100">Reset</a>
        </div>
        <div class="col-md-2 text-end">
            <a href="{{ route('products.create') }}" class="btn btn-success w-100">+ New Product</a>
        </div>
    </form>

    {{-- Tabel produk --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Brand</th>
                    <th>Category ID</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th>Image</th>
                    <th width="150">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>
                        <strong>{{ $product->name }}</strong><br>
                        <small>{{ Str::limit($product->description, 40) }}</small>
                    </td>
                    <td>{{ $product->brand ?? '-' }}</td>
                    <td>{{ $product->category_id ?? '-' }}</td>
                    <td>{{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>{{ $product->status ?? 'active' }}</td>
                    <td>{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" alt="" style="max-height: 60px;">
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}"
                           class="btn btn-sm btn-primary mb-1">Edit</a>

                        <form action="{{ route('products.destroy', $product) }}"
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center">No products found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{ $products->withQueryString()->links() }}
</div>
@endsection
