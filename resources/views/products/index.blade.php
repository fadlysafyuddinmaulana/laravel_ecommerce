@extends('layouts.app')

@section('title', 'Products')

@section('page-title', 'Products')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    <div class="row">
            <div class="col-12">
                <form method="GET" action="{{ route('products.index') }}" class="row g-2 mb-3 justify-content-end">
                    <div class="col-md-3">
                        <select name="category_id" class="form-control">
                            <option value="">-- All Categories --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" type="submit">Filter</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary w-100">Reset</a>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('products.create') }}" class="btn btn-success w-100">+ New Product</a>
                    </div>
                </form>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Product List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Brand</th>
                                    <th class="text-center">Category ID</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Featured</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center" width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($products as $product)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>
                                            <strong>{{ $product->name }}</strong><br>
                                            <small>{{ Str::limit($product->description, 40) }}</small>
                                        </td>
                                        <td class="text-center">{{ $product->brand ?? '-' }}</td>
                                        <td>{{ $product->category_name ?? '-' }}</td>
                                        <td class="text-center">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $product->stock }}</td>
                                        <td class="text-center">{{ $product->status ?? 'active' }}</td>
                                        <td class="text-center">{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                                        <td>
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                                    style="max-height: 60px;">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <a href="{{ route('products.destroy', $product) }}" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')"><i class="fa-solid fa-trash-can"></i></a>
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
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
@endsection

@push('styles')
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <!-- DataTables & Plugins -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
    </script>
@endpush
