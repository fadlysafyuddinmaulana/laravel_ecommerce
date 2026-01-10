<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderWebController extends Controller
{
    /**
     * Display list of orders
     */
    public function index(Request $request)
    {
        $query = Order::with('orderItems')->orderBy('created_at', 'desc');

        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $orders = $query->get();

        return view('user_page.pages.orders.index', compact('orders'));
    }

    /**
     * Show order details
     */
    public function show($orderNumber)
    {
        $order = Order::with('orderItems.product')->where('order_number', $orderNumber)->firstOrFail();

        return view('user_page.pages.orders.show', compact('order'));
    }

    /**
     * Show success page after checkout
     */
    public function success($orderNumber)
    {
        $order = Order::with('orderItems.product')->where('order_number', $orderNumber)->firstOrFail();

        return view('user_page.pages.orders.success', compact('order'));
    }

    /**
     * Track order status
     */
    public function track(Request $request)
    {
        if ($request->has('order_number')) {
            $order = Order::with('orderItems.product')
                ->where('order_number', $request->order_number)
                ->first();

            if ($order) {
                return view('user_page.pages.orders.track', compact('order'));
            }
        }

        return view('user_page.pages.orders.track');
    }
}
