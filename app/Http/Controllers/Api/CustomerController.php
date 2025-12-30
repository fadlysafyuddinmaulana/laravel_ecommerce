<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        
        return response()->json([
            'success' => true,
            'data' => $customers,
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_code'  => 'required|string|max:20|unique:customers',
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'gender'          => 'nullable|string|in:male,female',
            'phone'           => 'nullable|string|max:20',
            'username'        => 'required|string|max:255|unique:customers',
            'email'           => 'required|string|email|max:255|unique:customers',
            'password'        => 'required|string|min:8',
            'profile_image'   => 'nullable|string|max:255',
            'date_of_birth'   => 'nullable|date',
            'address'         => 'nullable|string|max:255',
            'city'            => 'nullable|string|max:255',
            'state'           => 'nullable|string|max:255',
            'zip_code'        => 'nullable|string|max:255',
            'role'            => 'sometimes|string|in:customer,admin',
        ]);

        $data['password'] = bcrypt($data['password']);
        $customer = Customer::create($data);

        return response()->json([
            'success' => true,
            'data'    => $customer,
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'success' => true,
            'data'    => $customer,
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'first_name'      => 'sometimes|string|max:255',
            'last_name'       => 'sometimes|string|max:255',
            'gender'          => 'nullable|string|in:male,female',
            'phone'           => 'nullable|string|max:20',
            'username'        => 'sometimes|string|max:255|unique:customers,username,' . $customer->id,
            'email'           => 'sometimes|string|email|max:255|unique:customers,email,' . $customer->id,
            'password'        => 'sometimes|string|min:8',
            'profile_image'   => 'nullable|string|max:255',
            'date_of_birth'   => 'nullable|date',
            'address'         => 'nullable|string|max:255',
            'city'            => 'nullable|string|max:255',
            'state'           => 'nullable|string|max:255',
            'zip_code'        => 'nullable|string|max:255',
            'role'            => 'sometimes|string|in:customer,admin',
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $customer->update($data);

        return response()->json([
            'success' => true,
            'data'    => $customer,
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully.',
        ], Response::HTTP_OK);
    }
}