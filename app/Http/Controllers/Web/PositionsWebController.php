<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Positions;
use App\Models\Department;
use Illuminate\Http\Request;

class PositionsWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Positions::query();

        $positions = $query->orderBy('created_at', 'desc')->get();

        return view('positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::where('is_active', true)
                                    ->orderBy('name')
                                    ->get();
        return view('positions.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'position_code' => 'required|string|max:50|unique:positions,position_code',
            'position_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'level'         => 'nullable|string|max:50',
            'department_id' => 'nullable|exists:departments,id',
            'status'        => 'required|in:active,inactive',
        ]);

        $position = Positions::create($data);

        return redirect()->route('positions.index')->with('success', 'Position created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Positions $position)
    {
        $departments = Department::where('is_active', true)->get();
        return view('positions.edit', compact('position', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Positions $position)
    {
        $data = $request->validate([
            'position_code' => 'required|string|max:50|unique:positions,position_code,' . $position->id,
            'position_name' => 'required|string|max:255',
            'description'   => 'nullable|string',
            'level'         => 'nullable|string|max:50',
            'department_id' => 'nullable|exists:departments,id',
            'status'        => 'required|in:active,inactive',
        ]);
        
        $position->update($data);

        return redirect()->route('positions.index')->with('success', 'Position updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Positions $position)
    {
        $position->delete();
        return redirect()->route('positions.index')->with('success', 'Position deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:positions,id',
        ]);

        Positions::whereIn('id', $request->ids)->delete();

        return redirect()->route('positions.index')->with('success', 'Selected positions deleted successfully.');
    }
}