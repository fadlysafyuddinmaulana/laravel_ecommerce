<?php

namespace App\Http\Controllers;

use App\Models\PageContent;
use Illuminate\Http\Request;

class PageContentWebController extends Controller
{
    /**
     * Display a listing of the page contents.
     */
    public function index()
    {
        $pageContents = PageContent::orderBy('page_name')
            ->orderBy('display_order')
            ->get();
        return view('page-contents.index', compact('pageContents'));
    }

    /**
     * Show the form for creating a new page content.
     */
    public function create()
    {
        return view('page-contents.create');
    }

    /**
     * Store a newly created page content in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_name' => 'required|string|max:255',
            'section_key' => 'required|string|max:255',
            'content' => 'required|string',
            'content_type' => 'required|string|in:text,html,image,url',
            'display_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');

        PageContent::create($data);

        return redirect()->route('page-contents.index')
            ->with('success', 'Page content created successfully.');
    }

    /**
     * Show the form for editing the specified page content.
     */
    public function edit(PageContent $pageContent)
    {
        return view('page-contents.edit', compact('pageContent'));
    }

    /**
     * Update the specified page content in storage.
     */
    public function update(Request $request, PageContent $pageContent)
    {
        $validated = $request->validate([
            'page_name' => 'required|string|max:255',
            'section_key' => 'required|string|max:255',
            'content' => 'required|string',
            'content_type' => 'required|string|in:text,html,image,url',
            'display_order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = $validated;
        $data['is_active'] = $request->has('is_active');

        $pageContent->update($data);

        return redirect()->route('page-contents.index')
            ->with('success', 'Page content updated successfully.');
    }

    /**
     * Remove the specified page content from storage.
     */
    public function destroy(PageContent $pageContent)
    {
        $pageContent->delete();

        return redirect()->route('page-contents.index')
            ->with('success', 'Page content deleted successfully.');
    }
}