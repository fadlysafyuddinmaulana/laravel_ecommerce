<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>@yield('title', 'E-Commerce Admin')</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Bootstrap CSS --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        @stack('styles')
    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">E-Commerce</a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarMain" aria-controls="navbarMain"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarMain">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('products*') ? 'active' : '' }}"
                               href="{{ route('products.index') }}">Products</a>
                        </li>
                        {{-- Tambah menu lain di sini (Categories, Orders, Users, dll.) --}}
                    </ul>

                    {{-- Placeholder user / login nanti --}}
                    <span class="navbar-text">
                        Admin Panel
                    </span>
                </div>
            </div>
        </nav>

        <main>
            @yield('content')
        </main>

        <footer class="border-top py-3 mt-4">
            <div class="container text-center text-muted">
                &copy; {{ date('Y') }} E-Commerce Project
            </div>
        </footer>

        {{-- Bootstrap JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        @stack('scripts')
    </body>
</html>
