<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderWebController extends Controller
{
    /**
     * Display a listing of all orders (admin view)
     */
    public function index(Request $request)
    {
        $query = Order::query()->orderBy('created_at', 'desc');
        
        // Filter by status if provided
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // Search by order number, customer name, or email
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $orders = $query->get();
        
        return view('orders.index', compact('orders'));
    }
    
    /**
     * Display order history
     */
    public function history()
    {
        // Show completed and cancelled orders
        $orders = Order::whereIn('status', ['delivered', 'cancelled'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('orders.history', compact('orders'));
    }
    
    /**
     * Display the specified order
     */
    public function show($orderNumber)
    {
        $order = Order::with('items.product')
            ->where('order_number', $orderNumber)
            ->firstOrFail();
        
        return view('orders.show', compact('order'));
    }
    
    /**
     * Update order status
     */
    public function updateStatus(Request $request, $orderNumber)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $order->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
    
    /**
     * Delete an order
     */
    public function destroy($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();
        $order->items()->delete(); // Delete order items first
        $order->delete();
        
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }
}
