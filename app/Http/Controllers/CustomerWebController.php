<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CustomerWebController extends Controller
{
    /**
     * Display customer dashboard with statistics
     */
    public function index(Request $request)
    {
        // Query customers
        $query = Customer::query();

        // Filter by gender if provided
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Get customers
        $customers = $query->orderBy('created_at', 'desc')->get();

        // Calculate statistics
        $totalCustomers = Customer::count();
        $activeCustomers = Customer::whereNotNull('email_verified_at')->count();
        $newCustomers = Customer::whereMonth('created_at', Carbon::now()->month)
                               ->whereYear('created_at', Carbon::now()->year)
                               ->count();
        $verifiedCustomers = Customer::whereNotNull('email_verified_at')->count();

        return view('customers.index', compact(
            'customers',
            'totalCustomers',
            'activeCustomers',
            'newCustomers',
            'verifiedCustomers'
        ));
    }

    /**
     * Bulk delete customers
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:customers,id',
        ]);

        Customer::whereIn('id', $request->ids)->delete();

        return redirect()->route('customers.index')
            ->with('success', count($request->ids) . ' customer(s) deleted successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'nullable|string|in:male,female',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'username' => 'required|string|max:255|unique:customers,username,' . $customer->id,
            'password' => 'nullable|string|min:8',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('customers', 'public');
            $data['profile_image'] = $path;
        } else {
            unset($data['profile_image']);
        }

        $customer->update($data);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}