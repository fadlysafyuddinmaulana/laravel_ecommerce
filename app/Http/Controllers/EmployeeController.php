<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json([
            'success' => true,
            'data' => $employees,
        ], response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_code' => 'required|string|max:20|unique:employees',
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'nullable|string|email|max:150|unique:employees',
            'phone'         => 'nullable|string|max:20',
            'username'      => 'required|string|unique:employees',
            'password'      => 'required|string|min:8',
            'profile_image' => 'nullable|string',
            'position'      => 'required|string|max:50',
            'department'    => 'required|string|max:50',
            'hire_date'     => 'nullable|date',
            'status'        => 'sometimes|string|in:active,inactive',
        ]);

        $employee = Employee::create($data);

        return response()->json([
            'success' => true,
            'data'    => $employee,
        ], response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'success' => true,
            'data'    => $employee,
        ], response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'employee_code' => 'sometimes|string|max:20|unique:employees,employee_code,' . $employee->id,
            'first_name'    => 'sometimes|string|max:100',
            'last_name'     => 'sometimes|string|max:100',
            'email'         => 'nullable|string|email|max:150|unique:employees,email,' . $employee->id,
            'phone'         => 'nullable|string|max:20',
            'username'      => 'sometimes|string|unique:employees,username,' . $employee->id,
            'password'      => 'sometimes|string|min:8',
            'profile_image' => 'nullable|string',
            'position'      => 'sometimes|string|max:50',
            'department'    => 'sometimes|string|max:50',
            'hire_date'     => 'nullable|date',
            'status'        => 'sometimes|string|in:active,inactive',
        ]);

        $employee->update($data);

        return response()->json([
            'success' => true,
            'data'    => $employee,
        ], response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'success' => true,
            'message' => 'Employee deleted successfully.',
        ], response::HTTP_OK);
    }

    /**
     * Bulk delete employees.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:employees,id',
        ]);

        $count = Employee::whereIn('id', $request->ids)->delete();
        
        return redirect()->route('employees.index')->with('success', "$count employee(s) deleted successfully.");
    }
}