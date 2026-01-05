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
     * Get cart dropdown content (for AJAX refresh)
     */
    public function dropdown()
    {
        $cart = session()->get('cart', []);
        $cartCount = count($cart);
        
        // Generate HTML for cart items
        $html = '';
        
        if ($cartCount > 0) {
            foreach ($cart as $id => $item) {
                $imageUrl = asset('storage/' . ($item['image'] ?? 'default.png'));
                $itemName = $item['name'];
                $quantity = $item['quantity'];
                $price = number_format($item['price'], 0, ',', '.');
                $subtotal = number_format($quantity * $item['price'], 0, ',', '.');
                
                $html .= '<div class="cart-item d-flex p-3 border-bottom" data-id="' . $id . '">';
                $html .= '  <div class="cart-item-image me-3">';
                $html .= '    <img src="' . $imageUrl . '" alt="' . $itemName . '" class="rounded" style="width: 60px; height: 60px; object-fit: cover;">';
                $html .= '  </div>';
                $html .= '  <div class="cart-item-details flex-grow-1">';
                $html .= '    <h6 class="mb-1 text-truncate" style="max-width: 200px;">' . $itemName . '</h6>';
                $html .= '    <p class="mb-1 text-muted small">' . $quantity . ' x Rp ' . $price . '</p>';
                $html .= '    <p class="mb-0 fw-bold text-success">Rp ' . $subtotal . '</p>';
                $html .= '  </div>';
                $html .= '  <button class="btn btn-sm btn-link text-danger p-0 ms-2" onclick="removeFromCart(' . $id . ')">';
                $html .= '    <i class="fas fa-trash"></i>';
                $html .= '  </button>';
                $html .= '</div>';
            }
            
            // Add footer with total and button
            $total = collect($cart)->sum(function ($item) {
                return $item['quantity'] * $item['price'];
            });
            $totalFormatted = number_format($total, 0, ',', '.');
        } else {
            $html = '<div class="empty-cart text-center py-5">';
            $html .= '  <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>';
            $html .= '  <p class="text-muted">Keranjang Anda kosong</p>';
            $html .= '</div>';
        }
        
        return response()->json([
            'success' => true,
            'html' => $html,
            'cart_count' => $cartCount,
            'total' => isset($totalFormatted) ? $totalFormatted : '0'
        ]);
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