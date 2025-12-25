<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Untree.co">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/furni-1.0.0/favicon.png') }}">

    <meta name="description" content="" />
    <meta name="keywords" content="bootstrap, bootstrap4" />

    <title>@yield('title', 'Furni') - {{ config('app.name') }}</title>

    <!-- Google Font: Source Sans Pro (optional, bisa dihapus jika tidak dipakai) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

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
</body>
</html>