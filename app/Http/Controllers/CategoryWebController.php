<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryWebController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        
        // search by name if provided
        if ($request->has('search')) {
            $query->where('category_name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->orderBy('created_at', 'desc')->get();
        
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
        ]);

        $category = Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'category_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
        ]);

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id',
        ]);

        $count = Category::whereIn('id', $request->ids)->delete();
        
        return redirect()->route('categories.index')->with('success', "$count categor(y|ies) deleted successfully.");
    }
}
