@extends('user_page.layouts.app')

@section('title', 'Order Success')

@push('styles')
    <style>
        .success-section {
            background-color: #f8f9fa;
            padding: 80px 0;
            min-height: 80vh;
        }

        .success-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 50px;
            text-align: center;
            max-width: 700px;
            margin: 0 auto;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background-color: #d1e7dd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
        }

        .success-icon i {
            font-size: 50px;
            color: #0f5132;
        }

        .success-card h1 {
            color: #0f5132;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .success-card .lead {
            color: #6c757d;
            margin-bottom: 30px;
        }

        .order-number {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
        }

        .order-number h3 {
            color: #2f2f2f;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .order-number .number {
            font-size: 1.5rem;
            color: #3b5d50;
            font-weight: 700;
        }

        .order-summary {
            text-align: left;
            background-color: #f8f9fa;
            padding: 25px;
            border-radius: 8px;
            margin: 30px 0;
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
            padding-top: 15px;
        }

        .action-buttons {
            margin-top: 40px;
        }

        .action-buttons .btn {
            margin: 5px;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
        }

        .btn-view-order {
            background-color: #3b5d50;
            color: white;
            border: none;
        }

        .btn-view-order:hover {
            background-color: #2d4940;
            color: white;
        }

        .btn-continue-shopping {
            background-color: white;
            color: #3b5d50;
            border: 2px solid #3b5d50;
        }

        .btn-continue-shopping:hover {
            background-color: #3b5d50;
            color: white;
        }

        .next-steps {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #dee2e6;
            text-align: left;
        }

        .next-steps h5 {
            color: #2f2f2f;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .next-steps ul {
            list-style: none;
            padding: 0;
        }

        .next-steps li {
            padding: 10px 0;
            padding-left: 30px;
            position: relative;
        }

        .next-steps li:before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #0f5132;
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
@endpush

@section('content')
    <!-- Success Section -->
    <div class="success-section">
        <div class="container">
            <div class="success-card">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>

                <h1>Order Placed Successfully!</h1>
                <p class="lead">Thank you for your purchase. Your order has been received and is being processed.</p>

                <!-- Order Number -->
                <div class="order-number">
                    <h3>Your Order Number</h3>
                    <div class="number">{{ $order->order_number }}</div>
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <h5 class="mb-3">Order Summary</h5>
                    <div class="summary-row">
                        <span>Items ({{ $order->orderItems->count() }})</span>
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
                        <span>Total Paid</span>
                        <span>${{ number_format($order->total, 2) }}</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('orders.show', $order->order_number) }}" class="btn btn-view-order">
                        <i class="fas fa-eye me-2"></i>View Order Details
                    </a>
                    <a href="{{ route('shop') }}" class="btn btn-continue-shopping">
                        <i class="fas fa-shopping-cart me-2"></i>Continue Shopping
                    </a>
                </div>

                <!-- Next Steps -->
                <div class="next-steps">
                    <h5>What happens next?</h5>
                    <ul>
                        <li>We've sent an order confirmation email to {{ $order->email ?? 'your registered email' }}</li>
                        <li>Your order will be processed within 1-2 business days</li>
                        <li>You'll receive a shipping confirmation with tracking details</li>
                        <li>Expected delivery: 5-7 business days</li>
                    </ul>
                </div>

                <div class="mt-4 text-muted">
                    <small>Need help? <a href="{{ route('contact') }}">Contact our support team</a></small>
                </div>
            </div>
        </div>
    </div>
@endsection
