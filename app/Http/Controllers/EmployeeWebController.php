<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Product;
use Illuminate\Http\Request;

class EmployeeWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Employee::query();

        $employees = $query->orderBy('created_at', 'desc')->get();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextEmployeeCode = Employee::generateEmployeeCode();
        return view('employees.create', compact('nextEmployeeCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:employees',
            'phone'         => 'nullable|string|max:20',
            'username'      => 'required|string|max:255|unique:employees',
            'password'      => 'required|string|min:8',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'position'      => 'nullable|string|max:255',
            'department'    => 'nullable|string|max:255',
            'hire_date'     => 'nullable|date',
            'status'        => 'nullable|string|max:20',
        ]);

        // Generate unique employee code
        $data['employee_code'] = Employee::generateEmployeeCode();

        // Hash the password
        $data['password'] = bcrypt($data['password']);

        // Handle file upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('employees', 'public');
            $data['profile_image'] = $path; // simpan path relatif
        }

        $employee = Employee::create($data);

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'employee_code' => 'required|string|max:255',
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
            'phone'         => 'nullable|string|max:20',
            'username'      => 'required|string|max:255|unique:employees,username,' . $employee->id,
            'password'      => 'nullable|string|min:8',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'position'      => 'nullable|string|max:255',
            'department'    => 'nullable|string|max:255',
            'hire_date'     => 'nullable|date',
            'status'        => 'nullable|string|max:20',
        ]);

        // Hash password jika diisi
        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        // Handle file upload
        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('employees', 'public');
            $data['profile_image'] = $path;
        } else {
            unset($data['profile_image']);
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