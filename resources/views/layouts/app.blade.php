<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - {{ config('app.name') }}</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous">
    
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous">
    
    <!-- AdminLTE -->
    <link rel="stylesheet" href="{{ asset('assets/AdminLTE-4.0.0-rc4/dist/css/adminlte.css') }}">
    
    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <!-- Header -->
        @include('layouts.partials.header')
        
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        
        <!-- Main Content -->
        <main class="app-main">
            <!-- Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@yield('page-title', 'Dashboard')</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                @yield('breadcrumb')
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Content -->
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        @include('layouts.partials.footer')
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/AdminLTE-4.0.0-rc4/dist/js/adminlte.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector('.sidebar-wrapper');
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: 'os-theme-light',
                        autoHide: 'leave',
                        clickScroll: true
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>