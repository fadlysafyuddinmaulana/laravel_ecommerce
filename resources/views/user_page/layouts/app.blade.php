<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/e-commerce_ico.png') }}">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <title>@yield('title', 'Furni') - {{ config('app.name') }}</title>

    <!-- Google Font: Source Sans Pro (optional, bisa dihapus jika tidak dipakai) -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome Icons (local & CDN) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/furni-1.0.0/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/furni-1.0.0/css/tiny-slider.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/furni-1.0.0/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <!-- Start Header/Navigation -->

    @include('user_page.layouts.partials.header')

    <!-- Start Hero Section -->
    {{-- @include('user_page.layouts.partials.hero') --}}
    <!-- End Hero Section -->

    <!-- End Header/Navigation -->

    @yield('content')

    <!-- Start Footer Section -->

    @include('user_page.layouts.partials.footer')

    <!-- End Footer Section -->


    <!-- JS Scripts -->
    <script src="{{ asset('assets/furni-1.0.0/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/furni-1.0.0/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/furni-1.0.0/js/custom.js') }}"></script>

    @stack('scripts')

    <script>
        // Auto refresh dan tampilkan success message setelah email verification
        @if (session('email_verified'))
            // Tampilkan alert success
            const message = "{{ session('success') }}";

            // Buat alert element
            const alertDiv = document.createElement('div');
            alertDiv.className =
                'alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            alertDiv.style.zIndex = '9999';
            alertDiv.style.minWidth = '300px';
            alertDiv.innerHTML = `
                <i class="fas fa-check-circle me-2"></i>
                <strong>Berhasil!</strong> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;

            // Tambahkan ke body
            document.body.appendChild(alertDiv);

            // Auto hide setelah 3 detik
            setTimeout(() => {
                alertDiv.remove();
            }, 3000);

            // Refresh halaman setelah 1 detik untuk update UI
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        @endif

        // Tampilkan info message jika ada
        @if (session('info'))
            const infoMessage = "{{ session('info') }}";
            const infoDiv = document.createElement('div');
            infoDiv.className =
                'alert alert-info alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3';
            infoDiv.style.zIndex = '9999';
            infoDiv.style.minWidth = '300px';
            infoDiv.innerHTML = `
                <i class="fas fa-info-circle me-2"></i>
                ${infoMessage}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.appendChild(infoDiv);
            setTimeout(() => infoDiv.remove(), 3000);
        @endif
    </script>
</body>

</html>
