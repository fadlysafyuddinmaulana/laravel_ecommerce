<!-- Start Header/Navigation -->
<nav id="mainHeader" class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark fixed-top transition-bg"
    arial-label="Furni navigation bar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Furni<span>.</span></a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarsFurni"
            aria-controls="navbarsFurni" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsFurni">
            <ul class="custom-navbar-nav navbar-nav ms-auto mb-2 mb-md-0">
                <li class="nav-item {{ request()->routeIs('landing') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item {{ request()->routeIs('shop') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('shop') }}">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="#">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}" href="#">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="#">Contact
                        us</a>
                </li>
            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                @if (!Auth::check())
                    <li>
                        <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i></a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="nav-link">
                            <i class="fas fa-sign-in-alt me-2"></i> Login
                        </a>
                    </li>
                    <li>
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-plus me-2"></i> Register
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown user-dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="far fa-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end" aria-labelledby="userDropdown">
                            <span class="dropdown-header">
                                <i class="fas fa-user mr-2"></i>
                                {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                            </span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item text-danger" style="width:100%;text-align:left;"
                                onclick="event.preventDefault(); document.getElementById('logout-link').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i> Sign out
                            </a>
                            <form id="logout-link" action="{{ route('logout') }}" method="POST" style="display:none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
<!-- End Header/Navigation -->

<script>
    // Change header background on scroll & dropdown hover
    document.addEventListener('DOMContentLoaded', function() {
        var header = document.getElementById('mainHeader');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.remove('bg-dark', 'navbar-dark');
                header.classList.add('bg-white', 'navbar-light', 'shadow-sm', 'header-scrolled');
            } else {
                header.classList.add('bg-dark', 'navbar-dark');
                header.classList.remove('bg-white', 'navbar-light', 'shadow-sm', 'header-scrolled');
            }
        });

        // Dropdown on hover for desktop
        var userDropdown = document.querySelector('.user-dropdown');
        if (window.matchMedia('(min-width: 768px)').matches && userDropdown) {
            userDropdown.addEventListener('mouseenter', function() {
                var dropdownMenu = this.querySelector('.dropdown-menu');
                this.classList.add('show');
                dropdownMenu.classList.add('show');
            });
            userDropdown.addEventListener('mouseleave', function() {
                var dropdownMenu = this.querySelector('.dropdown-menu');
                this.classList.remove('show');
                dropdownMenu.classList.remove('show');
            });
        }
    });
</script>
<style>
    .transition-bg {
        transition: background-color 0.3s, box-shadow 0.3s;
    }

    /* Saat header putih, paksa teks tetap putih */
    .header-scrolled .navbar-nav .nav-link,
    .header-scrolled .navbar-brand,
    .header-scrolled .dropdown-header,
    .header-scrolled .dropdown-item {
        color: #fff !important;
    }

    .header-scrolled .dropdown-menu,
    .dropdown-menu {
        background-color: #fff !important;
        color: #222 !important;
        z-index: 1055 !important;
        border: 1px solid #e0e0e0 !important;
        min-width: 220px;
        margin-top: 0.5rem !important;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
        position: absolute !important;
        right: 0 !important;
        left: auto !important;
    }

    .header-scrolled .dropdown-header,
    .header-scrolled .dropdown-item,
    .dropdown-menu .dropdown-header,
    .dropdown-menu .dropdown-item {
        color: #222 !important;
    }

    .dropdown-menu .dropdown-item:hover,
    .dropdown-menu .dropdown-item:focus {
        background-color: #f5f5f5 !important;
        color: #111 !important;
    }

    /* Dropdown on hover for desktop */
    @media (min-width: 768px) {
        .user-dropdown:hover>.dropdown-menu {
            display: block;
            margin-top: 0;
        }
    }
</style>
