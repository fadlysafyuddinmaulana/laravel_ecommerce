<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/AdminLTE-3.2.0/dist/img/AdminLTELogo.png') }}" 
             alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('assets/AdminLTE-3.2.0/dist/img/user2-160x160.jpg') }}" 
                     class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::check() ? Auth::user()->name : 'Guest' }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <!-- Products -->
                <li class="nav-item {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('products.*') || request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="{{ route('brands.index') }}" class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Brand</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('reviews.index') }}" class="nav-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reviews</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('stock.index') }}" class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Management</p>
                            </a>
                        </li> --}}
                    </ul>
                </li>
                
                <!-- Customers -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Customers</p>
                    </a>
                </li>
                
                <!-- Employees -->
                <li class="nav-item">
                    <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Employees</p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('employees.index') }}" class="nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                                <i class="fas fa-id-badge nav-icon"></i>
                                <p>All Employees</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('positions.index') }}" class="nav-link {{ request()->routeIs('positions.*') ? 'active' : '' }}">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>Positions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('departments.index') }}" class="nav-link {{ request()->routeIs('departments.*') ? 'active' : '' }}">
                                <i class="fas fa-building nav-icon"></i>
                                <p>Departments</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>