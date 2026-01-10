<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutWebController extends Controller
{
    /**
     * Display checkout page
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $delivery = 15.99; // Fixed delivery fee
        $discount = 0;
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $delivery - $discount + $tax;

        return view('user_page.pages.checkout', compact('cart', 'subtotal', 'delivery', 'discount', 'tax', 'total'));
    }

    /**
     * Process checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:500',
            'address2' => 'nullable|string|max:500',
            'country' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'paymentMethod' => 'required|string',
            'card_name' => 'required|string|max:255',
            'card_number' => 'required|string|max:19',
            'card_expiry' => 'required|string|max:5',
            'card_cvv' => 'required|string|max:4',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Keranjang Anda kosong');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $delivery = 15.99;
        $discount = 0;
        $tax = $subtotal * 0.1;
        $total = $subtotal + $delivery - $discount + $tax;

        // Save order to database
        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'address' => $request->address,
                'address2' => $request->address2,
                'country' => $request->country,
                'province' => $request->province,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'subtotal' => $subtotal,
                'delivery' => $delivery,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $request->paymentMethod,
                'card_name' => $request->card_name,
                'card_number_last4' => substr(str_replace(' ', '', $request->card_number), -4),
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $id,
                    'product_name' => $item['name'],
                    'product_image' => $item['image'] ?? null,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            DB::commit();

            // Store order data in session for success page
            session()->put('last_order', [
                'order_number' => $order->order_number,
                'cart' => $cart,
                'subtotal' => $subtotal,
                'delivery' => $delivery,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'order_date' => $order->created_at,
                'customer' => $request->first_name . ' ' . $request->last_name,
            ]);

            // Clear cart
            session()->forget('cart');

            return redirect()->route('orders.success', $order->order_number)->with('success', 'Pesanan berhasil diproses! Order Number: ' . $order->order_number . ' - Total: $' . number_format($total, 2));
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pesanan: ' . $e->getMessage())->withInput();
        }
    }
}