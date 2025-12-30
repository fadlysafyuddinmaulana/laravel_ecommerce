<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthWebController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login', [
            'layout' => 'layouts.auth',
        ]);
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register', [
            'layout' => 'layouts.auth',
        ]);
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
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['customer_code'] = Customer::generateCustomerCode();

        // handle profile_image kalau perlu, set default dsb.

        $customer = Customer::create($data);
        
        Auth::login($customer);
        
        // kirim email verifikasi (pakai SMTP Gmail dari .env)
        $customer->sendEmailVerificationNotification();
        
        return redirect()->route('verification.notice')
            ->with('success', 'Registrasi berhasil. Silakan cek email untuk verifikasi.');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'login'    => ['required', 'string'], // username atau email
            'password' => ['required', 'string'],
            'type'     => ['required', 'in:employee,customer'],
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

        // kalau customer & belum verified → tahan di halaman verify
        if ($data['type'] === 'customer'
            && $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail
            && ! $user->hasVerifiedEmail()) {

            return redirect()->route('verification.notice');
        }

        if ($data['type'] === 'customer') {
            return redirect()->route('landing');
        }

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}