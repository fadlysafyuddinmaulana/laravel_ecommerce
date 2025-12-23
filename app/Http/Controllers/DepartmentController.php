<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use illuminate\http\Response;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Departments = Department::all();

        return response()->json([
            'success' => true,
            'data' => $Departments,
        ], Response::HTTP_OK);
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

        return response()->json([
            'success' => true,
            'data'    => $department,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        return response()->json([
            'success' => true,
            'data'    => $department,
        ], Response::HTTP_OK);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'name'             => 'sometimes|required|string|max:255',
            'description'      => 'nullable|string',
            'department_code'  => 'nullable|string|unique:departments,department_code,' . $department->id,
            'manager_id'       => 'nullable|exists:employees,id',
            'is_active'        => 'boolean',
        ]);

        $department->update($data);

        return response()->json([
            'success' => true,
            'data'    => $department,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return response()->json([
            'success' => true,
            'message' => 'Department deleted successfully.',
        ], Response::HTTP_OK);
    }
}