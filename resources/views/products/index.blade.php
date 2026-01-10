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
            <form method="GET" action="{{ route('products.index') }}" class="mb-3">
                <div class="row g-2 align-items-center justify-content-end">
                    <div class="col-auto" style="max-width: 300px;">
                        <select name="category_id" class="form-control">
                            <option value="">-- All Categories --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id_category }}"
                                    {{ request('category_id') == $category->id_category ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-filter-primary" type="submit">Filter</button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('products.index') }}" class="btn btn-filter-secondary">Reset</a>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="bulkVisibilityBtn" class="btn btn-filter-visibility" disabled>
                            <i class="fa fa-eye"></i> Visibility
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="bulkFeaturedBtn" class="btn btn-filter-featured" disabled>
                            <i class="fa fa-star"></i> Featured
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="bulkDeleteBtn" class="btn btn-filter-danger" disabled>
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('products.create') }}" class="btn btn-filter-success">+ New Product</a>
                    </div>
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
                    </form>
                    <form id="bulkVisibilityForm" action="{{ route('products.bulk-toggle-visibility') }}" method="POST">
                        @csrf
                    </form>
                    <form id="bulkFeaturedForm" action="{{ route('products.bulk-toggle-featured') }}" method="POST">
                        @csrf
                    </form>
                    <form id="productsTableForm">
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
                                    <th class="text-center" width="150">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse($products as $product)
                                    <tr data-image="{{ $product->image ? asset('storage/' . $product->image) : '' }}"
                                        data-description="{{ $product->description ?? '-' }}"
                                        data-visibility="{{ $product->is_visible ?? 'hide' }}"
                                        data-featured="{{ $product->is_featured ? 'Yes' : 'No' }}"
                                        data-created="{{ $product->created_at ? date('M d, Y', strtotime($product->created_at)) : '-' }}">
                                        <td class="text-center">
                                            <input type="checkbox" class="row-checkbox" name="ids[]"
                                                value="{{ $product->id }}">
                                        </td>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <strong>{{ $product->name }}</strong><br>
                                                    <small
                                                        class="text-muted">{{ Str::limit($product->description, 40) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">{{ $product->brand_name ?? '-' }}</td>
                                        <td class="text-center align-middle">{{ $product->category_name ?? '-' }}</td>
                                        <td class="text-center align-middle">Rp
                                            {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="text-center align-middle">{{ $product->stock }}</td>
                                        <td class="text-center align-middle">
                                            <div class="d-flex justify-content-center align-items-center" style="gap: 8px;">
                                                <!-- View Details Button -->
                                                <button class="btn btn-figma-action details-control" title="View Details">
                                                    <i class="fa-regular fa-folder-closed"></i>
                                                </button>

                                                <!-- Edit Button -->
                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="btn btn-figma-action" title="Edit Product">
                                                    <i class="fa-regular fa-pen-to-square"></i>
                                                </a>

                                                <!-- More Actions Dropdown -->
                                                <div class="dropdown d-inline-block">
                                                    <button type="button" class="btn btn-figma-dropdown dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                                        title="More Actions">
                                                        <i class="fas fa-ellipsis-v" style="font-size: 14px;"></i>
                                                        <i class="fas fa-caret-down dropdown-caret"
                                                            style="font-size: 12px; margin-left: 4px;"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right figma-dropdown-menu">
                                                        <form action="{{ route('products.toggle-visibility', $product) }}"
                                                            method="POST" class="toggle-visibility-form">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="button"
                                                                class="dropdown-item figma-dropdown-item btn-toggle-visibility">
                                                                <div class="figma-item-icon">
                                                                    <i
                                                                        class="fa {{ $product->is_visible === 'show' ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                                                                </div>
                                                                <span
                                                                    class="figma-item-text">{{ $product->is_visible === 'show' ? 'Hide from Shop' : 'Show in Shop' }}</span>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('products.toggle-featured', $product) }}"
                                                            method="POST" class="toggle-featured-form">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="button"
                                                                class="dropdown-item figma-dropdown-item btn-toggle-featured">
                                                                <div class="figma-item-icon">
                                                                    <i
                                                                        class="fa {{ $product->is_featured ? 'fa-star' : 'far fa-star' }}"></i>
                                                                </div>
                                                                <span
                                                                    class="figma-item-text">{{ $product->is_featured ? 'Remove Featured' : 'Add to Featured' }}</span>
                                                            </button>
                                                        </form>
                                                        <div class="dropdown-divider" style="margin: 8px 0;"></div>
                                                        <form action="{{ route('products.destroy', $product) }}"
                                                            method="POST" class="delete-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="dropdown-item figma-dropdown-item figma-dropdown-item-danger btn-delete">
                                                                <div class="figma-item-icon">
                                                                    <i class="fa-solid fa-trash-can"></i>
                                                                </div>
                                                                <span class="figma-item-text">Delete Product</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No products found.</td>
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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Filter Action Buttons */
        .btn-filter-primary,
        .btn-filter-secondary,
        .btn-filter-visibility,
        .btn-filter-featured,
        .btn-filter-danger,
        .btn-filter-success {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 14px;
            font-weight: 500;
            line-height: 20px;
            padding: 10px 20px;
            border-radius: 6px;
            border: 1px solid;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
        }

        /* Primary Button (Filter) */
        .btn-filter-primary {
            background: #2563EB;
            border-color: #2563EB;
            color: #FFFFFF;
        }

        .btn-filter-primary:hover:not(:disabled) {
            background: #1D4ED8;
            border-color: #1D4ED8;
            color: #FFFFFF;
            box-shadow: 0px 2px 6px rgba(37, 99, 235, 0.25);
        }

        .btn-filter-primary:active:not(:disabled) {
            background: #1E40AF;
            border-color: #1E40AF;
        }

        /* Secondary Button (Reset) */
        .btn-filter-secondary {
            background: #6B7280;
            border-color: #6B7280;
            color: #FFFFFF;
        }

        .btn-filter-secondary:hover:not(:disabled) {
            background: #4B5563;
            border-color: #4B5563;
            color: #FFFFFF;
            box-shadow: 0px 2px 6px rgba(107, 114, 128, 0.25);
        }

        .btn-filter-secondary:active:not(:disabled) {
            background: #374151;
            border-color: #374151;
        }

        /* Visibility Button (Teal/Cyan) */
        .btn-filter-visibility {
            background: #14B8A6;
            border-color: #14B8A6;
            color: #FFFFFF;
        }

        .btn-filter-visibility:hover:not(:disabled) {
            background: #0D9488;
            border-color: #0D9488;
            color: #FFFFFF;
            box-shadow: 0px 2px 6px rgba(20, 184, 166, 0.25);
        }

        .btn-filter-visibility:active:not(:disabled) {
            background: #0F766E;
            border-color: #0F766E;
        }

        .btn-filter-visibility:disabled {
            background: #99F6E4;
            border-color: #99F6E4;
            color: #FFFFFF;
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Featured Button (Yellow/Warning) */
        .btn-filter-featured {
            background: #F59E0B;
            border-color: #F59E0B;
            color: #FFFFFF;
        }

        .btn-filter-featured:hover:not(:disabled) {
            background: #D97706;
            border-color: #D97706;
            color: #FFFFFF;
            box-shadow: 0px 2px 6px rgba(245, 158, 11, 0.25);
        }

        .btn-filter-featured:active:not(:disabled) {
            background: #B45309;
            border-color: #B45309;
        }

        .btn-filter-featured:disabled {
            background: #FCD34D;
            border-color: #FCD34D;
            color: #FFFFFF;
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Danger Button (Delete) */
        .btn-filter-danger {
            background: #EF4444;
            border-color: #EF4444;
            color: #FFFFFF;
        }

        .btn-filter-danger:hover:not(:disabled) {
            background: #DC2626;
            border-color: #DC2626;
            color: #FFFFFF;
            box-shadow: 0px 2px 6px rgba(239, 68, 68, 0.25);
        }

        .btn-filter-danger:active:not(:disabled) {
            background: #B91C1C;
            border-color: #B91C1C;
        }

        .btn-filter-danger:disabled {
            background: #FCA5A5;
            border-color: #FCA5A5;
            color: #FFFFFF;
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Success Button (New Product) */
        .btn-filter-success {
            background: #10B981;
            border-color: #10B981;
            color: #FFFFFF;
        }

        .btn-filter-success:hover:not(:disabled) {
            background: #059669;
            border-color: #059669;
            color: #FFFFFF;
            box-shadow: 0px 2px 6px rgba(16, 185, 129, 0.25);
        }

        .btn-filter-success:active:not(:disabled) {
            background: #047857;
            border-color: #047857;
        }

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

        /* Figma Action Buttons */
        .btn-figma-action {
            background: #FDFDFD !important;
            border: 1px solid #DCDCDC !important;
            border-radius: 4px !important;
            padding: 8px 12px !important;
            color: #292929 !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: all 0.2s ease;
            font-size: 14px;
            line-height: 20px;
        }

        .btn-figma-action:hover {
            background: #F5F5F5 !important;
            border-color: #B8B8B8 !important;
            box-shadow: 0px 2px 4px rgba(36, 36, 36, 0.08);
            color: #292929 !important;
        }

        .btn-figma-action:focus,
        .btn-figma-action:active {
            box-shadow: 0px 0px 0px 3px rgba(82, 82, 82, 0.1) !important;
            outline: none !important;
        }

        /* Figma Dropdown Button */
        .btn-figma-dropdown {
            background: #F1F1F1 !important;
            border: 1px solid #DCDCDC !important;
            border-radius: 4px !important;
            padding: 8px 12px !important;
            color: #292929 !important;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            font-size: 14px;
            line-height: 20px;
        }

        .btn-figma-dropdown:hover {
            background: #E8E8E8 !important;
            border-color: #B8B8B8 !important;
            box-shadow: 0px 2px 4px rgba(36, 36, 36, 0.08);
        }

        .btn-figma-dropdown:focus,
        .btn-figma-dropdown:active {
            box-shadow: 0px 0px 0px 3px rgba(82, 82, 82, 0.1) !important;
            outline: none !important;
        }

        /* Remove default Bootstrap dropdown toggle arrow */
        .btn-figma-dropdown.dropdown-toggle::after {
            display: none;
        }

        /* Dropdown Caret Animation */
        .dropdown-caret {
            transition: transform 0.2s ease;
        }

        .dropdown.show .dropdown-caret {
            transform: rotate(180deg);
        }

        /* Figma Dropdown Menu - EmviUI Style */
        .figma-dropdown-menu {
            background: #FDFDFD;
            border: 1px solid #DCDCDC;
            border-radius: 8px;
            box-shadow: 0px 12px 16px -4px rgba(36, 36, 36, 0.08),
                0px 4px 6px -2px rgba(36, 36, 36, 0.03);
            padding: 16px 8px 12px 8px;
            min-width: 220px;
            margin-top: 4px;
        }

        /* Figma Dropdown Item - EmviUI Style */
        .figma-dropdown-item {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 14px;
            font-weight: 400;
            line-height: 20px;
            color: #525252;
            padding: 8px 10px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
            transition: background-color 0.15s ease;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
        }

        .figma-dropdown-item:hover {
            background-color: #F5F5F5;
            color: #525252;
        }

        .figma-dropdown-item:active {
            background-color: #EBEBEB;
        }

        /* Icon wrapper */
        .figma-item-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .figma-item-icon i {
            font-size: 16px;
            color: #525252;
        }

        /* Text wrapper */
        .figma-item-text {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Danger Item */
        .figma-dropdown-item-danger {
            color: #DC2626 !important;
        }

        .figma-dropdown-item-danger:hover {
            background-color: #FEF2F2 !important;
            color: #DC2626 !important;
        }

        .figma-dropdown-item-danger .figma-item-icon i {
            color: #DC2626;
        }

        /* Divider */
        .figma-dropdown-menu .dropdown-divider {
            margin: 8px 0;
            border-top: 1px solid #EBEBEB;
        }
    </style>
@endpush

@push('scripts')
    <!-- DataTables & Plugins -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
    </script>
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
                var imageHtml = rowData.image ?
                    '<img src="' + rowData.image +
                    '" alt="Product" style="max-height: 100px; border-radius: 4px;">' :
                    '<span class="text-muted">No image</span>';

                var visibilityBadge = rowData.visibility === 'show' ?
                    '<span class="badge badge-success"><i class="fa fa-eye"></i> Visible</span>' :
                    '<span class="badge badge-secondary"><i class="fa fa-eye-slash"></i> Hidden</span>';

                var featuredBadge = rowData.featured === 'Yes' ?
                    '<span class="badge badge-primary"><i class="fa fa-star"></i> Featured</span>' :
                    '<span class="badge badge-light"><i class="far fa-star"></i> Normal</span>';

                return '<div class="product-details">' +
                    '<dl>' +
                    '<dt>Product Image</dt>' +
                    '<dd>' + imageHtml + '</dd>' +
                    '<dt>Full Description</dt>' +
                    '<dd>' + rowData.description + '</dd>' +
                    '<dt>Visibility Status</dt>' +
                    '<dd>' + visibilityBadge + '</dd>' +
                    '<dt>Featured Status</dt>' +
                    '<dd>' + featuredBadge + '</dd>' +
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
                    "targets": [0, 1, 6],
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
                        image: tr.data('image'),
                        description: tr.data('description'),
                        visibility: tr.data('visibility'),
                        featured: tr.data('featured'),
                        created: tr.data('created')
                    };
                    row.child(format(rowData)).show();
                    tr.addClass('shown');
                    btn.html('<i class="fa-regular fa-folder-open"></i>');
                }
            });

            // Toggle Visibility Confirmation
            $('.btn-toggle-visibility').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                var form = btn.closest('form');
                var isVisible = btn.hasClass('btn-warning'); // warning = currently visible

                Swal.fire({
                    title: isVisible ? 'Hide from shop?' : 'Show in shop?',
                    text: isVisible ?
                        "Product will be hidden from shop page" :
                        "Product will be visible in shop page",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: isVisible ? '#ffc107' : '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: isVisible ? 'Yes, hide it!' : 'Yes, show it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Toggle Featured Confirmation
            $('.btn-toggle-featured').on('click', function(e) {
                e.preventDefault();
                var btn = $(this);
                var form = btn.closest('form');
                var isFeatured = btn.hasClass('btn-primary') && !btn.hasClass('btn-outline-primary');

                Swal.fire({
                    title: isFeatured ? 'Remove from featured?' : 'Add to featured?',
                    text: isFeatured ?
                        "Product will be removed from homepage featured section" :
                        "Product will be added to homepage featured section",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#007bff',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: isFeatured ? 'Yes, remove it!' : 'Yes, add it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
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
                toggleBulkActionButtons();
            });

            $('.row-checkbox').on('change', function() {
                var allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length;
                $('#selectAll').prop('checked', allChecked);
                toggleBulkActionButtons();
            });

            function toggleBulkActionButtons() {
                var checkedCount = $('.row-checkbox:checked').length;
                var isDisabled = checkedCount === 0;
                $('#bulkDeleteBtn').prop('disabled', isDisabled);
                $('#bulkVisibilityBtn').prop('disabled', isDisabled);
                $('#bulkFeaturedBtn').prop('disabled', isDisabled);
            }

            // Helper function to get selected IDs
            function getSelectedIds() {
                return $('.row-checkbox:checked').map(function() {
                    return $(this).val();
                }).get();
            }

            // Helper function to submit bulk form
            function submitBulkForm(formId, ids) {
                var $form = $(formId);
                // Remove existing hidden inputs
                $form.find('input[name="ids[]"]').remove();
                // Add new hidden inputs for selected IDs
                ids.forEach(function(id) {
                    $form.append('<input type="hidden" name="ids[]" value="' + id + '">');
                });
                $form.submit();
            }

            // Bulk visibility toggle
            $('#bulkVisibilityBtn').on('click', function(e) {
                e.preventDefault();
                var ids = getSelectedIds();

                Swal.fire({
                    title: 'Toggle Visibility?',
                    text: `You are about to toggle visibility for ${ids.length} product(s)!`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#17a2b8',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, toggle!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitBulkForm('#bulkVisibilityForm', ids);
                    }
                });
            });

            // Bulk featured toggle
            $('#bulkFeaturedBtn').on('click', function(e) {
                e.preventDefault();
                var ids = getSelectedIds();

                Swal.fire({
                    title: 'Toggle Featured?',
                    text: `You are about to toggle featured status for ${ids.length} product(s)!`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#ffc107',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, toggle!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitBulkForm('#bulkFeaturedForm', ids);
                    }
                });
            });

            // Bulk delete confirmation
            $('#bulkDeleteBtn').on('click', function(e) {
                e.preventDefault();
                var ids = getSelectedIds();

                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete ${ids.length} product(s)!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete them!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitBulkForm('#bulkDeleteForm', ids);
                    }
                });
            });
        });
    </script>
@endpush
