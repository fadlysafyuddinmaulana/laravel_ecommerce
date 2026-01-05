<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string|in:mastercard,paypal,nova',
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

        // Store order data in session (temporary)
        session()->put('last_order', [
            'cart' => $cart,
            'subtotal' => $subtotal,
            'delivery' => $delivery,
            'discount' => $discount,
            'tax' => $tax,
            'total' => $total,
            'shipping_address' => $request->shipping_address,
            'payment_method' => $request->payment_method,
            'card_name' => $request->card_name,
            'card_number' => '****-****-****-' . substr($request->card_number, -4),
            'order_date' => now(),
            'customer' => Auth::user() ? Auth::user()->first_name . ' ' . Auth::user()->last_name : 'Guest',
        ]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('dashboard')->with('success', 'Pesanan berhasil diproses! Total: $' . number_format($total, 2));
    }
}