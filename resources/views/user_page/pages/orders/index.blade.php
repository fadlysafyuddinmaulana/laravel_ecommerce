@extends('user_page.layouts.app')

@section('title', 'My Orders')

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <style>
        .orders-section {
            background-color: #f8f9fa;
            padding: 60px 0;
            min-height: 80vh;
        }

        .page-header {
            margin-bottom: 40px;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 300;
            color: #2f2f2f;
        }

        .orders-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
        }

        .filter-section {
            margin-bottom: 25px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background-color: #cfe2ff;
            color: #084298;
        }

        .status-completed {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #842029;
        }

        .table thead th {
            background-color: #3b5d50;
            color: white;
            font-weight: 600;
            border: none;
        }

        .table tbody tr {
            transition: background-color 0.2s;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .btn-view-order {
            background-color: #3b5d50;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .btn-view-order:hover {
            background-color: #2d4940;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 5rem;
            color: #ddd;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #adb5bd;
        }
    </style>
@endpush

@section('content')
    <!-- Breadcrumb Section -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">My Orders</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Orders Section -->
    <div class="orders-section">
        <div class="container">
            <div class="page-header text-center">
                <h1>My Orders</h1>
                <p class="text-muted">Track and manage your orders</p>
            </div>

            <div class="orders-card">
                <!-- Filter Section -->
                <div class="filter-section">
                    <form method="GET" action="{{ route('orders.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <select name="status" class="form-select" onchange="this.form.submit()">
                                <option value="">All Orders</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>
                        <div class="col-md-8 text-end">
                            <a href="{{ route('orders.track') }}" class="btn btn-outline-primary">
                                <i class="fas fa-search me-2"></i>Track Order
                            </a>
                        </div>
                    </form>
                </div>

                @if ($orders->count() > 0)
                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table id="ordersTable" class="table table-hover">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Order Number</th>
                                    <th width="15%">Date</th>
                                    <th width="10%">Items</th>
                                    <th width="15%">Total</th>
                                    <th width="15%">Status</th>
                                    <th width="15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $index => $order)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            <strong>{{ $order->order_number }}</strong>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y, H:i') }}</td>
                                        <td>{{ $order->orderItems->count() }} items</td>
                                        <td>
                                            <strong class="text-success">
                                                ${{ number_format($order->total, 2) }}
                                            </strong>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $order->status }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->order_number) }}"
                                                class="btn btn-sm btn-view-order">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="empty-state">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>No Orders Found</h3>
                        <p>You haven't placed any orders yet.</p>
                        <a href="{{ route('shop') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-shopping-cart me-2"></i>Start Shopping
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- DataTables JS -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}">
    </script>

    <script>
        $(function() {
            @if ($orders->count() > 0)
                $('#ordersTable').DataTable({
                    responsive: true,
                    autoWidth: false,
                    order: [
                        [2, 'desc']
                    ], // Sort by date descending
                    columnDefs: [{
                        orderable: false,
                        targets: [0, 6], // No and Actions columns
                        searchable: false
                    }],
                    language: {
                        search: "Search orders:",
                        lengthMenu: "Show _MENU_ orders per page",
                        info: "Showing _START_ to _END_ of _TOTAL_ orders",
                        infoEmpty: "No orders available",
                        infoFiltered: "(filtered from _MAX_ total orders)",
                        zeroRecords: "No matching orders found",
                        emptyTable: "No orders available"
                    }
                });
            @endif
        });
    </script>
@endpush
