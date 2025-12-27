<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthWebController extends Controller
{
    /**
     * Display the login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login', [ 'layout' => 'layouts.auth',]);
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register', [ 'layout' => 'layouts.auth',]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'gender'        => 'nullable|string|in:male,female',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'required|string|email|max:255|unique:customers',
            'username'      => 'required|string|max:255|unique:customers',
            'password'      => 'required|string|min:8|confirmed',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'date_of_birth' => 'nullable|date',
            'address'       => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'state'         => 'nullable|string|max:255',
            'zip_code'      => 'nullable|string|max:255',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['customer_code'] = Customer::generateCustomerCode();
        
        $customer = Customer::create($data);
        Auth::login($customer);
        $customer->sendEmailVerificationNotification();
        return redirect()->route('verification.notice');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'login'    => 'required|string', // username atau email
            'password' => 'required|string',
            'type'     => 'required|in:employee,customer',
        ]);

        if ($data['type'] === 'employee') {
            $user = Employee::where('username', $data['login'])
                ->orWhere('email', $data['login'])
                ->first();
        } else {
            $user = Customer::where('username', $data['login'])
                ->orWhere('email', $data['login'])
                ->first();
        }

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()
                ->withInput($request->only('login', 'type'))
                ->withErrors(['login' => 'Invalid credentials provided.']);
        }

        Auth::login($user, $request->boolean('remember'));

        // Redirect sesuai role/type
        if ($data['type'] === 'customer' || (isset($user->role) && $user->role === 'customer')) {
            return redirect()->route('landing');
        }

        return redirect()->route('dashboard');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login');
    }
    
}