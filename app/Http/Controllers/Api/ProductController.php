<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    // GET /api/products
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'data' => $products,
        ], Response::HTTP_OK);
    }

    // POST /api/products
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer|min:0',

            'category_id' => 'nullable|integer|exists:categories,id',
            'brand'       => 'nullable|string|max:25',
            'image'       => 'nullable|string', // atau 'image' jika upload file
            'status'      => 'nullable|string|max:20',
            'is_featured' => 'boolean',
        ]);

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'data'    => $product,
        ], Response::HTTP_CREATED);
    }

    // GET /api/products/{product}
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data'    => $product,
        ], Response::HTTP_OK);
    }

    // PUT/PATCH /api/products/{product}
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'sometimes|required|numeric',
            'stock'       => 'sometimes|required|integer|min:0',

            'category_id' => 'nullable|integer|exists:categories,id',
            'brand'       => 'nullable|string|max:25',
            'image'       => 'nullable|string',
            'status'      => 'nullable|string|max:20',
            'is_featured' => 'boolean',
        ]);

        $product->update($data);

        return response()->json([
            'success' => true,
            'data'    => $product,
        ], Response::HTTP_OK);
    }

    // DELETE /api/products/{product}
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted',
        ], Response::HTTP_OK);
    }
}