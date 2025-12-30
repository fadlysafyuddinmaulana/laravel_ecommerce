<?php
namespace App\Http\Controllers\Web;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepartmentWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Department::query();

        $departments = $query->orderBy('created_at', 'desc')->get();

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = \App\Models\Employee::all();
        return view('departments.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'department_code'  => 'nullable|string|unique:departments,department_code',
            'manager_id'       => 'nullable|exists:employees,id',
            'is_active'        => 'boolean',
        ]);

        $department = Department::create($data);

        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        $employees = \App\Models\Employee::all();
        return view('departments.edit', compact('department', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'department_code'  => 'nullable|string|unique:departments,department_code,' . $department->id,
            'manager_id'       => 'nullable|exists:employees,id',
            'is_active'        => 'boolean',
        ]);
        
        $department->update($data);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:departments,id',
        ]);

        Department::whereIn('id', $request->ids)->delete();

        return redirect()->route('departments.index')->with('success', 'Selected departments deleted successfully.');
    }
}