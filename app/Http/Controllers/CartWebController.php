<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartWebController extends Controller
{
    /**
     * Display cart page
     */
    public function index()
    {
        return view('user_page.pages.cart');
    }

    /**
     * Add product to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Stock tidak mencukupi'
            ], 400);
        }

        $cart = session()->get('cart', []);

        // If product already in cart, update quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
                'image' => $product->image,
                'stock' => $product->stock,
            ];
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => count($cart)
        ]);
    }

    /**
     * Update cart quantity
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->id])) {
            $cart[$request->id]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil diupdate'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan di keranjang'
        ], 404);
    }

    /**
     * Remove product from cart
     */
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari keranjang'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Produk tidak ditemukan di keranjang'
        ], 404);
    }

    /**
     * Clear cart
     */
    public function clear()
    {
        session()->forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }
}