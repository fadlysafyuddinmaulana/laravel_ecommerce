{{-- resources/views/auth/verify-email.blade.php --}}
@extends('auth.layouts.portal')

@section('title', 'Verify Email')

@section('content')
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center bg-dark">
                <span class="h1"><i class="fas fa-envelope-circle-check text-primary"></i></span>
            </div>
            <div class="card-body bg-dark text-white rounded-bottom">
                <h3 class="text-center mb-3">Please verify your email</h3>
                <p class="text-center mb-3">
                    @if (Auth::user())
                        We just sent an email to <span class="font-weight-bold">{{ Auth::user()->email }}</span>.<br>
                    @else
                        We just sent you a verification email.<br>
                    @endif
                    Click the link in the email to verify your account.
                </p>
                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success py-2 text-center" role="alert">
                        A new verification link has been sent to your email.
                    </div>
                @endif
                <form method="POST" action="{{ route('verification.send') }}" class="mb-2">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-paper-plane mr-1"></i> Resend email
                    </button>
                </form>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-block">
                        <i class="fas fa-sign-out-alt mr-1"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
