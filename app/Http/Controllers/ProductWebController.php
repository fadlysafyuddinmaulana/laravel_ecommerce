<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();
        
        // filter by category if provided
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // search by name if provided
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(10);
        
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',

            'category_id' => 'nullable|integer|exists:categories,id',
            'brand'       => 'nullable|string|max:25',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'nullable|string|max:20',
            'is_featured' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path; // simpan path relatif
        }

        $product = Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        return view('products.edit',compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',

            'category_id' => 'nullable|integer|exists:categories,id',
            'brand'       => 'nullable|string|max:25',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'nullable|string|max:20',
            'is_featured' => 'boolean',
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        } else {
            unset($data['image']); // jangan kosongkan kalau tidak upload baru
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        
    }
}