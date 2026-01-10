@extends('layouts.app')

@section('title', 'Order Details - ' . $order->order_number)

@section('page-title', 'Order Details')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></li>
    <li class="breadcrumb-item active">{{ $order->order_number }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8">
            <!-- Order Items -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-shopping-cart"></i> Order Items</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->items as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if ($item->product_image)
                                                <img src="{{ asset('storage/' . $item->product_image) }}"
                                                    alt="{{ $item->product_name }}"
                                                    style="width: 50px; height: 50px; object-fit: cover; margin-right: 10px;">
                                            @endif
                                            <div>
                                                <strong>{{ $item->product_name }}</strong>
                                            </div>
                                        </div>
                                    </td>
                                    <td>${{ number_format($item->product_price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No items found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-map-marker-alt"></i> Shipping Address</h3>
                </div>
                <div class="card-body">
                    <address>
                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->province }}<br>
                        {{ $order->country }} {{ $order->postal_code }}<br>
                        <br>
                        <i class="fas fa-envelope"></i> {{ $order->email }}
                    </address>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Order Info -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle"></i> Order Information</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">Order Number:</dt>
                        <dd class="col-sm-7"><strong>{{ $order->order_number }}</strong></dd>

                        <dt class="col-sm-5">Order Date:</dt>
                        <dd class="col-sm-7">{{ date('d M Y H:i', strtotime($order->created_at)) }}</dd>

                        <dt class="col-sm-5">Status:</dt>
                        <dd class="col-sm-7">
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
                        </dd>

                        <dt class="col-sm-5">Payment:</dt>
                        <dd class="col-sm-7">
                            @if ($order->payment_method == 'credit')
                                <i class="fas fa-credit-card"></i> Credit Card<br>
                                <small class="text-muted">**** {{ $order->card_number_last4 }}</small>
                            @else
                                <i class="fab fa-paypal"></i> PayPal
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>

            <!-- Price Summary -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-dollar-sign"></i> Price Summary</h3>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-6">Subtotal:</dt>
                        <dd class="col-sm-6 text-right">${{ number_format($order->subtotal, 2) }}</dd>

                        <dt class="col-sm-6">Delivery:</dt>
                        <dd class="col-sm-6 text-right">${{ number_format($order->delivery, 2) }}</dd>

                        @if ($order->discount > 0)
                            <dt class="col-sm-6 text-success">Discount:</dt>
                            <dd class="col-sm-6 text-right text-success">-${{ number_format($order->discount, 2) }}</dd>
                        @endif

                        <dt class="col-sm-6">Tax:</dt>
                        <dd class="col-sm-6 text-right">${{ number_format($order->tax, 2) }}</dd>

                        <dt class="col-sm-6 border-top pt-2"><strong>Total:</strong></dt>
                        <dd class="col-sm-6 text-right border-top pt-2">
                            <strong>${{ number_format($order->total, 2) }}</strong></dd>
                    </dl>
                </div>
            </div>

            <!-- Actions -->
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-warning btn-block mb-2" data-toggle="modal"
                        data-target="#statusModal">
                        <i class="fas fa-edit"></i> Update Status
                    </button>
                    <button onclick="window.print()" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-print"></i> Print Order
                    </button>
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-block">
                        <i class="fas fa-arrow-left"></i> Back to Orders
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update Order Status</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{ route('admin.orders.updateStatus', $order->order_number) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Current Status:
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
                            </label>
                        </div>
                        <div class="form-group">
                            <label>New Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                    Processing</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped
                                </option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered
                                </option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        @media print {

            .card-header,
            .btn,
            .main-header,
            .main-sidebar,
            .breadcrumb {
                display: none !important;
            }
        }
    </style>
@endpush
