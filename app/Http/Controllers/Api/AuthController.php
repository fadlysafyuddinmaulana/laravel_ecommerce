<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    // POST /api/auth/register/customer
    public function registerCustomer(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'username'   => 'required|string|max:255|unique:customers,username',
            'email'      => 'required|email|unique:customers,email',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        $customer = Customer::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'username'   => $data['username'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
            'role'       => 'customer',
        ]);

        $token = $customer->createToken('auth_token', ['customer'])->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Customer registered',
            'data' => [
                'type' => 'customer',
                'role' => $customer->role,
                'user' => $customer,
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], Response::HTTP_CREATED);
    }

    // POST /api/auth/login
    public function login(Request $request)
    {
        $data = $request->validate([
            'type'     => 'required|in:customer,employee',
            'login'    => 'required|string', // username atau email
            'password' => 'required|string',
        ]);

        $user = null;

        if ($data['type'] === 'customer') {
            $user = Customer::where('email', $data['login'])
                ->orWhere('username', $data['login'])
                ->first();
        } else {
            $user = Employee::where('email', $data['login'])
                ->orWhere('username', $data['login'])
                ->first();
        }

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }

        // optional: hapus token lama
        $user->tokens()->delete();

        $abilities = [$user->role]; // ability = role dari tabel masing-masing
        $token = $user->createToken('auth_token', $abilities)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Logged in',
            'data' => [
                'type' => $data['type'],
                'role' => $user->role,
                'user' => $user,
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], Response::HTTP_OK);
    }
}