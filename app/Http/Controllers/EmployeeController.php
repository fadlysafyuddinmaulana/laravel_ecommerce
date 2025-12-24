<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::orderBy('created_at', 'desc')->get();
        return view('employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Generate next employee code for preview
        $nextEmployeeCode = Employee::generateEmployeeCode();
        return view('employee.create', compact('nextEmployeeCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'nullable|string|email|max:150|unique:employees',
            'phone'         => 'nullable|string|max:20',
            'username'      => 'required|string|unique:employees',
            'password'      => 'required|string|min:8',
            'position'      => 'required|string|max:50',
            'department'    => 'required|string|max:50',
            'hire_date'     => 'nullable|date',
            'status'        => 'sometimes|string|in:active,inactive',
        ]);

        // Auto-generate employee code
        $data['employee_code'] = Employee::generateEmployeeCode();
        $data['password'] = Hash::make($data['password']);
        
        Employee::create($data);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return view('employee.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'employee_code' => 'required|string|max:20|unique:employees,employee_code,' . $employee->id,
            'first_name'    => 'required|string|max:100',
            'last_name'     => 'required|string|max:100',
            'email'         => 'nullable|string|email|max:150|unique:employees,email,' . $employee->id,
            'phone'         => 'nullable|string|max:20',
            'username'      => 'required|string|unique:employees,username,' . $employee->id,
            'password'      => 'nullable|string|min:8',
            'position'      => 'required|string|max:50',
            'department'    => 'required|string|max:50',
            'hire_date'     => 'nullable|date',
            'status'        => 'required|string|in:active,inactive',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $employee->update($data);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
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