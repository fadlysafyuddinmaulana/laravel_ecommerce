<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get featured products for showcase (limit to 3)
        // Hanya filter berdasarkan is_featured, tidak perlu is_visible
        $featuredProducts = Product::where('is_featured', 1)
            ->take(3)
            ->get();

        // Get new products
        $newProducts = Product::newProducts()
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get discount products
        $discountProducts = Product::withDiscount()
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // Get active testimonials (max 3)
        $testimonials = Testimonial::active()
            ->limit(3)
            ->get();

        return view('user_page.pages.index', compact(
            'featuredProducts',
            'newProducts',
            'discountProducts',
            'testimonials'
        ));
    }
    
    /**
     * Display a listing of the resource.
     */
    public function shop(Request $request)
    {
        $query = Product::where('is_visible', 'show'); // Filter hanya produk yang visible

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('brand', function($brandQuery) use ($search) {
                      $brandQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('id_category', $request->category);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Get all categories for filter
        $categories = \App\Models\Category::all();

        // Get min and max price for price range slider
        $minPrice = Product::min('price') ?? 0;
        $maxPrice = Product::max('price') ?? 100000000;

        $products = $query->orderBy('created_at', 'desc')->paginate(12);

        return view('user_page.pages.shop', compact('products', 'categories', 'minPrice', 'maxPrice'));
    }

    /**
     * Display a listing of the resource.
     */
    public function about()
    {
        // Get active testimonials for about page
        $testimonials = Testimonial::active()->limit(3)->get();

        return view('user_page.pages.about', compact('testimonials'));
    }
    
    public function services()
    {
        return view('user_page.pages.services');
    }
    
    public function blog()
    {
        // Paginate blog posts (9 per page)
        // TODO: Create Blog model and migration
        // For now, using products as placeholder
        $blogs = Product::orderBy('created_at', 'desc')->paginate(9);

        return view('user_page.pages.blog', compact('blogs'));
    }

    public function contact()
    {
        return view('user_page.pages.contact');
    }
}