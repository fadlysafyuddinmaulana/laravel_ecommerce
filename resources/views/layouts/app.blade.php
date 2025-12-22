<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    
    <!-- Font Awesome Icons v7.1.0 (Latest) -->
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-7.1.0-web/css/all.min.css') }}">
    
    <!-- DataTables -->
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/AdminLTE-3.2.0/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
    
    @stack('styles')
</head>
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Header -->
        @include('layouts.partials.header')
        
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        
        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Content Header -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        @include('layouts.partials.footer')
    </div>
    
    <!-- Scripts -->
    <!-- jQuery -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/AdminLTE-3.2.0/dist/js/adminlte.min.js') }}"></script>
    
    @stack('scripts')
</body>
</html>