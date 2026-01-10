@extends('user_page.layouts.app')

@section('title', 'Track Order')

@push('styles')
    <style>
        .track-section {
            background-color: #f8f9fa;
            padding: 80px 0;
            min-height: 80vh;
        }

        .track-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
        }

        .track-form {
            max-width: 500px;
            margin: 0 auto 40px;
        }

        .track-input-group {
            position: relative;
        }

        .track-input-group input {
            padding-right: 120px;
            height: 50px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
        }

        .track-input-group input:focus {
            border-color: #3b5d50;
            box-shadow: 0 0 0 0.2rem rgba(59, 93, 80, 0.25);
        }

        .track-input-group button {
            position: absolute;
            right: 5px;
            top: 5px;
            height: 40px;
            background-color: #3b5d50;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 0 25px;
        }

        .track-input-group button:hover {
            background-color: #2d4940;
        }

        .order-timeline {
            position: relative;
            padding: 30px 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 60px;
            margin-bottom: 40px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 40px;
            height: 40px;
            background-color: #e9ecef;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
        }

        .timeline-item.active .timeline-icon {
            background-color: #3b5d50;
            color: white;
        }

        .timeline-item.completed .timeline-icon {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        .timeline-content h5 {
            color: #2f2f2f;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .timeline-content .date {
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 5px;
        }

        .timeline-content p {
            color: #6c757d;
            margin-bottom: 0;
        }

        .order-info-box {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .order-info-box h4 {
            color: #2f2f2f;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .info-row:last-child {
            border-bottom: none;
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
    </style>
@endpush

@section('content')
    <!-- Breadcrumb Section -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Track Order</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Track Section -->
    <div class="track-section">
        <div class="container">
            <div class="text-center mb-5">
                <h1>Track Your Order</h1>
                <p class="text-muted">Enter your order number to check its status</p>
            </div>

            <div class="track-card">
                <!-- Track Form -->
                <div class="track-form">
                    <form method="GET" action="{{ route('orders.track') }}">
                        <div class="track-input-group mb-3">
                            <input type="text" name="order_number" class="form-control"
                                placeholder="Enter your order number (e.g., ORD001)" value="{{ request('order_number') }}"
                                required>
                            <button type="submit">
                                <i class="fas fa-search me-2"></i>Track
                            </button>
                        </div>
                    </form>
                    <div class="text-center text-muted">
                        <small>Order number can be found in your confirmation email</small>
                    </div>
                </div>

                @if (isset($order))
                    <!-- Order Information -->
                    <div class="order-info-box">
                        <h4>Order Information</h4>
                        <div class="info-row">
                            <span>Order Number</span>
                            <strong>{{ $order->order_number }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Order Date</span>
                            <strong>{{ $order->created_at->format('d M Y, H:i') }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Total Amount</span>
                            <strong>${{ number_format($order->total, 2) }}</strong>
                        </div>
                        <div class="info-row">
                            <span>Status</span>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    <div class="order-timeline">
                        <h4 class="mb-4">Order Progress</h4>

                        <div class="timeline-item {{ $order->created_at ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Order Placed</h5>
                                <p class="date">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                <p>Your order has been received and confirmed</p>
                            </div>
                        </div>

                        <div
                            class="timeline-item {{ in_array($order->status, ['processing', 'completed']) ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Processing</h5>
                                @if ($order->status == 'processing')
                                    <p class="date">In Progress</p>
                                    <p>Your order is being prepared for shipment</p>
                                @else
                                    <p>Pending processing</p>
                                @endif
                            </div>
                        </div>

                        <div class="timeline-item {{ $order->status == 'completed' ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Shipped</h5>
                                @if ($order->status == 'completed')
                                    <p class="date">In Transit</p>
                                    <p>Your order is on its way</p>
                                @else
                                    <p>Awaiting shipment</p>
                                @endif
                            </div>
                        </div>

                        <div class="timeline-item {{ $order->status == 'completed' ? 'completed' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h5>Delivered</h5>
                                @if ($order->status == 'completed')
                                    <p class="date">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                    <p>Order has been delivered successfully</p>
                                @else
                                    <p>Pending delivery</p>
                                @endif
                            </div>
                        </div>

                        @if ($order->status == 'cancelled')
                            <div class="timeline-item active">
                                <div class="timeline-icon bg-danger">
                                    <i class="fas fa-times"></i>
                                </div>
                                <div class="timeline-content">
                                    <h5 class="text-danger">Order Cancelled</h5>
                                    <p class="date">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                                    <p>This order has been cancelled</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="text-center mt-4">
                        <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-primary me-2">
                            <i class="fas fa-eye me-2"></i>View Full Details
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-headset me-2"></i>Contact Support
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
