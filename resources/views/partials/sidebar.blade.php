<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <img src="{{ asset('assets/AdminLTE-4.0.0-rc4/dist/assets/img/AdminLTELogo.png') }}" 
                 alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">{{ config('app.name') }}</span>
        </a>
    </div>
    
    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="navigation">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                
                <!-- Products -->
                <li class="nav-item {{ request()->routeIs('products.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>
                            Products
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>All Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('products.create') }}" class="nav-link {{ request()->routeIs('products.create') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Add Product</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Customers -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Customers</p>
                    </a>
                </li>
                
                <!-- Employees -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Employees</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>