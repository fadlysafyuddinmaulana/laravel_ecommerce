<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Employee;
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

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'login'    => 'required|string', // username atau email
            'password' => 'required|string',
        ]);

        $employee = Employee::where('username', $data['login'])
            ->orWhere('email', $data['login'])
            ->first();

        if (! $employee || ! Hash::check($data['password'], $employee->password)) {
            return back()
                ->withInput($request->only('login'))
                ->withErrors(['login' => 'Invalid credentials provided.']);
        }

        Auth::login($employee, $request->boolean('remember'));

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