<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify Email - {{ config('app.name') }}</title>

    @if (Auth::user() && Auth::user()->hasVerifiedEmail())
        <meta http-equiv="refresh" content="0;url=/">
    @endif

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/furni-1.0.0/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            padding: 20px;
        }

        .verify-card {
            background-color: #ffffff;
            border-radius: 20px;
            padding: 50px 45px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .email-icon-wrapper {
            margin: 0 auto 30px;
            width: 100px;
            height: 100px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .email-icon-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            animation: pulse 2s ease-in-out infinite;
        }

        .email-icon {
            position: relative;
            z-index: 1;
            width: 50px;
            height: 35px;
            border: 3px solid #fff;
            border-radius: 5px;
            background: transparent;
        }

        .email-icon::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            width: 0;
            height: 0;
            border-left: 28px solid transparent;
            border-right: 28px solid transparent;
            border-top: 20px solid #fff;
        }

        .email-icon::after {
            content: '';
            position: absolute;
            top: -3px;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 0;
            border-left: 28px solid transparent;
            border-right: 28px solid transparent;
            border-top: 20px solid #667eea;
            z-index: 2;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        h1 {
            color: #1f2937;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 16px;
            letter-spacing: -0.5px;
        }

        .verify-text {
            color: #6b7280;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .verify-text .email-address {
            color: #667eea;
            font-weight: 600;
        }

        .btn-resend {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 15px 32px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-bottom: 12px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-resend:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        .btn-update {
            background-color: transparent;
            color: #667eea;
            border: 2px solid #667eea;
            border-radius: 10px;
            padding: 13px 32px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-update:hover {
            background-color: #667eea;
            color: #fff;
        }

        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #10b981;
            border-radius: 10px;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 14px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <div class="verify-card">
        <div class="email-icon-wrapper">
            <div class="email-icon-bg"></div>
            <div class="email-icon"></div>
        </div>

        <h1>Verify your email</h1>

        <p class="verify-text">
            We just sent an email to
            @if (Auth::user())
                <span class="email-address">{{ Auth::user()->email }}</span>.
            @else
                your email address.
            @endif
            <br>
            Click the link in the email to verify your account.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                A new verification link has been sent to your email.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn-resend">
                Resend email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn-update">
                Update email
            </button>
        </form>
    </div>

    <script src="{{ asset('assets/furni-1.0.0/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        // Auto redirect jika sudah verified
        @if (Auth::user() && Auth::user()->hasVerifiedEmail())
            window.location.href = '/';
        @endif
    </script>
</body>

</html>
