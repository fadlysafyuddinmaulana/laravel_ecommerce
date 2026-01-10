<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialWebController extends Controller
{
    /**
     * Display a listing of the testimonials.
     */
    public function index()
    {
        $testimonials = Testimonial::orderBy('display_order')->get();
        return view('testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        return view('testimonials.create');
    }

    /**
     * Store a newly created testimonial in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
            'display_order' => 'nullable|integer',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('testimonials', 'public');
            $data['image'] = $path;
        }

        Testimonial::create($data);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified testimonial in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'company' => 'nullable|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'boolean',
            'display_order' => 'nullable|integer',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $path = $request->file('image')->store('testimonials', 'public');
            $data['image'] = $path;
        } else {
            unset($data['image']); // Don't overwrite existing image
        }

        $testimonial->update($data);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    /**
     * Remove the specified testimonial from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Delete image if exists
        if ($testimonial->image) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }

    /**
     * Toggle the active status of the testimonial.
     */
    public function toggleActive(Testimonial $testimonial)
    {
        $testimonial->is_active = !$testimonial->is_active;
        $testimonial->save();
        
        $status = $testimonial->is_active ? 'activated' : 'deactivated';
        
        return redirect()->route('testimonials.index')
            ->with('success', "Testimonial successfully {$status}.");
    }
}
