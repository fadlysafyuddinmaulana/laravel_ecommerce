@extends('user_page.layouts.app')

@section('title', 'Order Details - ' . $order->order_number)

@push('styles')
    <style>
        .order-details-section {
            background-color: #f8f9fa;
            padding: 60px 0;
            min-height: 80vh;
        }

        .order-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin-bottom: 20px;
        }

        .order-header {
            border-bottom: 2px solid #3b5d50;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .order-header h2 {
            color: #2f2f2f;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .order-info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .info-item {
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 6px;
        }

        .info-item label {
            font-weight: 600;
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 5px;
            display: block;
            text-transform: uppercase;
        }

        .info-item .value {
            color: #2f2f2f;
            font-size: 1.1rem;
        }

        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
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

        .order-items-table {
            width: 100%;
            margin-bottom: 30px;
        }

        .order-items-table thead {
            background-color: #3b5d50;
            color: white;
        }

        .order-items-table th,
        .order-items-table td {
            padding: 15px;
            text-align: left;
        }

        .order-items-table tbody tr {
            border-bottom: 1px solid #dee2e6;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .order-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.2rem;
            color: #3b5d50;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.2s;
        }

        .btn-back:hover {
            background-color: #5a6268;
            color: white;
        }

        .btn-print {
            background-color: #3b5d50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .btn-print:hover {
            background-color: #2d4940;
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
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">My Orders</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $order->order_number }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Order Details Section -->
    <div class="order-details-section">
        <div class="container">
            <!-- Order Header -->
            <div class="order-card">
                <div class="order-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2>Order #{{ $order->order_number }}</h2>
                            <p class="text-muted mb-0">
                                Placed on {{ $order->created_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                        <div>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Order Info Grid -->
                <div class="order-info-grid">
                    <div class="info-item">
                        <label>Customer Name</label>
                        <div class="value">{{ $order->first_name }} {{ $order->last_name }}</div>
                    </div>
                    <div class="info-item">
                        <label>Email</label>
                        <div class="value">{{ $order->email ?? '-' }}</div>
                    </div>
                    <div class="info-item">
                        <label>Payment Method</label>
                        <div class="value">{{ ucfirst($order->payment_method) }}</div>
                    </div>
                    <div class="info-item">
                        <label>Card (Last 4 digits)</label>
                        <div class="value">**** **** **** {{ $order->card_number_last4 }}</div>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div class="mb-4">
                    <h5 class="mb-3">Shipping Address</h5>
                    <div class="info-item">
                        <div class="value">
                            {{ $order->address }}<br>
                            @if ($order->address2)
                                {{ $order->address2 }}<br>
                            @endif
                            {{ $order->city }}, {{ $order->province }}<br>
                            {{ $order->country }} {{ $order->postal_code }}
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <h5 class="mb-3">Order Items</h5>
                <table class="order-items-table">
                    <thead>
                        <tr>
                            <th width="10%">Image</th>
                            <th width="40%">Product</th>
                            <th width="15%">Price</th>
                            <th width="15%">Quantity</th>
                            <th width="20%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td>
                                    @if ($item->product_image)
                                        <img src="{{ asset('storage/' . $item->product_image) }}"
                                            alt="{{ $item->product_name }}" class="product-image">
                                    @else
                                        <img src="{{ asset('assets/furni-1.0.0/images/product-1.png') }}"
                                            alt="{{ $item->product_name }}" class="product-image">
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $item->product_name }}</strong>
                                </td>
                                <td>${{ number_format($item->price, 2) }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td><strong>${{ number_format($item->subtotal, 2) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Order Summary -->
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <div class="order-summary">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span>${{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Delivery Fee</span>
                                <span>${{ number_format($order->delivery, 2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Tax (10%)</span>
                                <span>${{ number_format($order->tax, 2) }}</span>
                            </div>
                            @if ($order->discount > 0)
                                <div class="summary-row text-success">
                                    <span>Discount</span>
                                    <span>-${{ number_format($order->discount, 2) }}</span>
                                </div>
                            @endif
                            <div class="summary-row">
                                <span>Total</span>
                                <span>${{ number_format($order->total, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 text-end">
                    <a href="{{ route('orders.index') }}" class="btn btn-back me-2">
                        <i class="fas fa-arrow-left me-2"></i>Back to Orders
                    </a>
                    <button onclick="window.print()" class="btn btn-print">
                        <i class="fas fa-print me-2"></i>Print Order
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
