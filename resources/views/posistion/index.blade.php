@extends('layouts.app')

@section('title', 'Products')

@section('page-title', 'Products')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')
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
                        <button type="button" id="bulkDeleteBtn" class="btn btn-danger w-100" disabled>
                            <i class="fa-solid fa-trash-can"></i> Delete Selected
                        </button>
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
                        <form id="bulkDeleteForm" action="{{ route('products.bulk-delete') }}" method="POST">
                            @csrf
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="5%">
                                            <input type="checkbox" id="selectAll">
                                        </th>
                                        <th class="text-center" width="5%">No</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Brand</th>
                                        <th class="text-center">Category</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center" width="180">Actions</th>
                                    </tr>
                                </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($products as $product)
                                    <tr data-description="{{ $product->description ?? '-' }}"
                                        data-status="{{ $product->status ?? 'active' }}"
                                        data-featured="{{ $product->is_featured ? 'Yes' : 'No' }}"
                                        data-created="{{ $product->created_at ? date('M d, Y', strtotime($product->created_at)) : '-' }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="row-checkbox" name="ids[]" value="{{ $product->id }}">
                                        </td>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>
                                            <strong>{{ $product->name }}</strong><br>
                                            <small class="text-muted">{{ Str::limit($product->description, 40) }}</small>
                                        </td>
                                        <td class="text-center">{{ $product->brand ?? '-' }}</td>
                                        <td>{{ $product->category_name ?? '-' }}</td>
                                        <td class="text-center">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="text-center">{{ $product->stock }}</td>
                                        <td class="text-center">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" alt=""
                                                    style="max-height: 60px;">
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <button class="btn btn-sm btn-info details-control">
                                                <i class="fa-regular fa-folder-closed"></i>
                                            </button>
                                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary"><i class="fa-regular fa-pen-to-square"></i></a>
                                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </form>
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
    <style>
        .product-details {
            padding: 15px;
            background-color: #f8f9fa;
            border-left: 3px solid #17a2b8;
        }
        .product-details dl {
            margin-bottom: 0;
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 10px;
        }
        .product-details dt {
            font-weight: 600;
            color: #495057;
        }
        .product-details dd {
            margin-bottom: 0;
            color: #6c757d;
        }
    </style>
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
            // Format function for row details
            function format(rowData) {
                return '<div class="product-details">' +
                    '<dl>' +
                    '<dt>Full Description</dt>' +
                    '<dd>' + rowData.description + '</dd>' +
                    '<dt>Status</dt>' +
                    '<dd>' + rowData.status + '</dd>' +
                    '<dt>Featured</dt>' +
                    '<dd>' + rowData.featured + '</dd>' +
                    '<dt>Created Date</dt>' +
                    '<dd>' + rowData.created + '</dd>' +
                    '</dl>' +
                    '</div>';
            }

            var table = $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
                "columnDefs": [{
                    "orderable": false,
                    "targets": [0, 1, 8],
                    "searchable": false
                }],
                "order": [
                    [2, 'asc']
                ],
                "fnDrawCallback": function(oSettings) {
                    // Auto numbering
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    api.column(1, {
                        order: 'applied'
                    }).nodes().each(function(cell, i) {
                        cell.innerHTML = startIndex + i + 1;
                    });
                }
            });

            // Add event listener for opening and closing details
            $('#example1 tbody').on('click', '.details-control', function(e) {
                e.preventDefault();
                var btn = $(this);
                var tr = btn.closest('tr');
                var row = table.row(tr);

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                    btn.html('<i class="fa-regular fa-folder-closed"></i>');
                } else {
                    // Open this row
                    var rowData = {
                        description: tr.data('description'),
                        status: tr.data('status'),
                        featured: tr.data('featured'),
                        created: tr.data('created')
                    };
                    row.child(format(rowData)).show();
                    tr.addClass('shown');
                    btn.html('<i class="fa-regular fa-folder-open"></i>');
                }
            });
            
            // SweetAlert2 Delete Confirmation
            $('.btn-delete').on('click', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Checkbox functionality
            $('#selectAll').on('click', function() {
                $('.row-checkbox').prop('checked', this.checked);
                toggleBulkDeleteBtn();
            });

            $('.row-checkbox').on('change', function() {
                var allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
                $('#selectAll').prop('checked', allChecked);
                toggleBulkDeleteBtn();
            });

            function toggleBulkDeleteBtn() {
                var checkedCount = $('.row-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#bulkDeleteBtn').prop('disabled', false);
                } else {
                    $('#bulkDeleteBtn').prop('disabled', true);
                }
            }

            // Bulk delete confirmation
            $('#bulkDeleteBtn').on('click', function(e) {
                e.preventDefault();
                var checkedCount = $('.row-checkbox:checked').length;
                
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${checkedCount} product(s)!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#bulkDeleteForm').submit();
                    }
                });
            });
        });
    </script>
@endpush
