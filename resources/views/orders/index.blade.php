@extends('layouts.app')

@section('title', 'All Orders')

@section('page-title', 'All Orders')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item active">All Orders</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Order Management</h3>
                    <div class="card-tools">
                        <form method="GET" action="{{ route('admin.orders.index') }}" class="form-inline">
                            <div class="input-group input-group-sm mr-2" style="width: 200px;">
                                <select name="status" class="form-control" onchange="this.form.submit()">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>
                                        Processing</option>
                                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped
                                    </option>
                                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>
                                        Delivered</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>
                            <div class="input-group input-group-sm" style="width: 250px;">
                                <input type="text" name="search" class="form-control" placeholder="Search order..."
                                    value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <table id="ordersTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Order Number</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th style="width: 150px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td></td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->order_number) }}"
                                            class="text-primary">
                                            <strong>{{ $order->order_number }}</strong>
                                        </a>
                                    </td>
                                    <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                    <td>{{ $order->email }}</td>
                                    <td>{{ date('d M Y', strtotime($order->created_at)) }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @if ($order->payment_method == 'credit')
                                            <i class="fas fa-credit-card"></i> Credit Card
                                        @else
                                            <i class="fab fa-paypal"></i> PayPal
                                        @endif
                                    </td>
                                    <td>
                                        @if ($order->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($order->status == 'processing')
                                            <span class="badge badge-info">Processing</span>
                                        @elseif($order->status == 'shipped')
                                            <span class="badge badge-primary">Shipped</span>
                                        @elseif($order->status == 'delivered')
                                            <span class="badge badge-success">Delivered</span>
                                        @else
                                            <span class="badge badge-danger">Cancelled</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center" style="gap: 8px;">
                                            <a href="{{ route('admin.orders.show', $order->order_number) }}"
                                                class="btn btn-figma-action" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn btn-figma-action text-warning"
                                                data-toggle="modal" data-target="#statusModal{{ $order->id }}"
                                                title="Update Status">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-figma-action text-danger"
                                                onclick="confirmDelete('{{ $order->order_number }}')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>

                                        <!-- Status Update Modal -->
                                        <div class="modal fade" id="statusModal{{ $order->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Update Order Status</h4>
                                                        <button type="button" class="close"
                                                            data-dismiss="modal">&times;</button>
                                                    </div>
                                                    <form
                                                        action="{{ route('admin.orders.updateStatus', $order->order_number) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <label>Status</label>
                                                                <select name="status" class="form-control" required>
                                                                    <option value="pending"
                                                                        {{ $order->status == 'pending' ? 'selected' : '' }}>
                                                                        Pending</option>
                                                                    <option value="processing"
                                                                        {{ $order->status == 'processing' ? 'selected' : '' }}>
                                                                        Processing</option>
                                                                    <option value="shipped"
                                                                        {{ $order->status == 'shipped' ? 'selected' : '' }}>
                                                                        Shipped</option>
                                                                    <option value="delivered"
                                                                        {{ $order->status == 'delivered' ? 'selected' : '' }}>
                                                                        Delivered</option>
                                                                    <option value="cancelled"
                                                                        {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                                                        Cancelled</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Update
                                                                Status</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No orders found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <form id="deleteForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
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

        .btn-figma-action.text-danger {
            color: #DC2626 !important;
        }

        .btn-figma-action.text-danger:hover {
            background: #FEF2F2 !important;
            color: #DC2626 !important;
        }

        .btn-figma-action.text-warning {
            color: #F59E0B !important;
        }

        .btn-figma-action.text-warning:hover {
            background: #FFFBEB !important;
            color: #F59E0B !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#ordersTable").DataTable({
                responsive: true,
                autoWidth: false,
                order: [
                    [4, 'desc']
                ], // Sort by date column
                columnDefs: [{
                    orderable: false,
                    targets: [0, 8], // No and Actions columns
                    searchable: false,
                }, ],
                fnDrawCallback: function(oSettings) {
                    var api = this.api();
                    var startIndex = api.context[0]._iDisplayStart;
                    api.column(0, {
                            order: 'applied'
                        })
                        .nodes()
                        .each(function(cell, i) {
                            cell.innerHTML = startIndex + i + 1;
                        });
                },
            });
        });

        function confirmDelete(orderNumber) {
            if (confirm('Are you sure you want to delete order ' + orderNumber + '?')) {
                const form = document.getElementById('deleteForm');
                form.action = '/admin/orders/' + orderNumber;
                form.submit();
            }
        }
    </script>
@endpush
