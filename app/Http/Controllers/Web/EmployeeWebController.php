<?php
namespace App\Http\Controllers\Web;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeeWebController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::with(['position','department'])->orderBy('created_at', 'desc')->get();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $nextEmployeeCode = Employee::generateEmployeeCode();
        $positions = \App\Models\Positions::all();
        $departments = \App\Models\Department::all();
        return view('employees.create', compact('nextEmployeeCode', 'positions', 'departments'));
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
            'position_code' => 'required|string',
            'department_code' => 'required|string',
            'hire_date'     => 'nullable|date',
            'status'        => 'nullable|string|max:20',
        ]);

        // Mapping position_code ke position_id
        $position = \App\Models\Positions::where('position_code', $data['position_code'])->first();
        $data['position_id'] = $position ? $position->id : null;

        // Mapping department_code ke department_id
        $department = \App\Models\Department::where('department_code', $data['department_code'])->first();
        $data['department_id'] = $department ? $department->id : null;

        unset($data['position_code'], $data['department_code']);

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
        $positions = \App\Models\Positions::all();
        $departments = \App\Models\Department::all();
        return view('employees.edit', compact('employee', 'positions', 'departments'));
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
            'position_code' => 'required|string',
            'department_code' => 'required|string',
            'hire_date'     => 'nullable|date',
            'status'        => 'nullable|string|max:20',
        ]);

        // Mapping position_code ke position_id
        $position = \App\Models\Positions::where('position_code', $data['position_code'])->first();
        $data['position_id'] = $position ? $position->id : null;

        // Mapping department_code ke department_id
        $department = \App\Models\Department::where('department_code', $data['department_code'])->first();
        $data['department_id'] = $department ? $department->id : null;

        unset($data['position_code'], $data['department_code']);

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