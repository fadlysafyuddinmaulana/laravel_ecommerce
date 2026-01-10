@extends('layouts.app')

@section('title', 'Order History')

@section('page-title', 'Order History')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">Order History</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Completed & Cancelled Orders</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left"></i> Back to All Orders
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="historyTable" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">No</th>
                                <th>Order Number</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th style="width: 100px">Actions</th>
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
                                    <td>{{ date('d M Y H:i', strtotime($order->created_at)) }}</td>
                                    <td>${{ number_format($order->total, 2) }}</td>
                                    <td>
                                        @if ($order->status == 'delivered')
                                            <span class="badge badge-success">
                                                <i class="fas fa-check-circle"></i> Delivered
                                            </span>
                                        @else
                                            <span class="badge badge-danger">
                                                <i class="fas fa-times-circle"></i> Cancelled
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.orders.show', $order->order_number) }}"
                                            class="btn btn-sm btn-info" title="View Details">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        <div class="py-4">
                                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">No order history found</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $("#historyTable").DataTable({
                responsive: true,
                autoWidth: false,
                order: [
                    [3, 'desc']
                ], // Sort by date column
                columnDefs: [{
                    orderable: false,
                    targets: [0, 6], // No and Actions columns
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
    </script>
@endpush
