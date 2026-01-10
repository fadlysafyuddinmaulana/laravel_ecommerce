<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductWebController extends \App\Http\Controllers\Controller
{
    public function index(Request $request)
    {
        $query = Product::join('categories', 'products.id_category', '=', 'categories.id_category')
        ->leftJoin('brands', 'products.id_brand', '=', 'brands.id_brand')
        ->select('products.*', 'categories.name as category_name', 'brands.name as brand_name');
        
        // filter by category if provided
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('products.id_category', $request->category_id);
        }

        // search by name if provided
        if ($request->has('search')) {
            $query->where('products.name', 'like', '%' . $request->search . '%');
        }

        $products = $query->orderBy('products.created_at', 'desc')->get();
        $categories = Category::orderBy('name')->get();
        
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',

            'id_category' => 'nullable|integer|exists:categories,id_category',
            'id_brand'    => 'nullable|integer|exists:brands,id_brand',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'nullable|string|max:20',
            'is_featured' => 'boolean',
            'has_discount' => 'boolean',
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
        $categories = Category::orderBy('name')->get();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',

            'id_category' => 'nullable|integer|exists:categories,id_category',
            'id_brand'    => 'nullable|integer|exists:brands,id_brand',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status'      => 'nullable|string|max:20',
            'is_featured' => 'boolean',
            'has_discount' => 'boolean',
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

    public function show($id)
    {
        $product = Product::with(['category', 'brand'])->findOrFail($id);
        
        // Get related products from the same category
        $relatedProducts = Product::where('id_category', $product->id_category)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();
        
        return view('user_page.pages.product-detail', compact('product', 'relatedProducts'));
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        
    }

    public function toggleVisibility(Product $product)
    {
        // Toggle antara 'show' dan 'hide'
        $product->is_visible = ($product->is_visible === 'show') ? 'hide' : 'show';
        $product->save();
        
        $status = $product->is_visible === 'show' ? 'visible in' : 'hidden from';
        
        return redirect()->route('products.index')
            ->with('success', "Product successfully {$status} shop page.");
    }

    public function toggleFeatured(Product $product)
    {
        // Toggle featured status
        $product->is_featured = !$product->is_featured;
        $product->save();
        
        $status = $product->is_featured ? 'added to' : 'removed from';
        
        return redirect()->route('products.index')
            ->with('success', "Product successfully {$status} featured section.");
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $count = Product::whereIn('id', $request->ids)->delete();
        
        return redirect()->route('products.index')->with('success', "$count product(s) deleted successfully.");
    }

    public function bulkToggleVisibility(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->ids)->get();
        $count = 0;

        foreach ($products as $product) {
            $product->is_visible = $product->is_visible === 'show' ? 'hide' : 'show';
            $product->save();
            $count++;
        }
        
        return redirect()->route('products.index')->with('success', "$count product(s) visibility toggled successfully.");
    }

    public function bulkToggleFeatured(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->ids)->get();
        $count = 0;

        foreach ($products as $product) {
            $product->is_featured = !$product->is_featured;
            $product->save();
            $count++;
        }
        
        return redirect()->route('products.index')->with('success', "$count product(s) featured status toggled successfully.");
    }
}