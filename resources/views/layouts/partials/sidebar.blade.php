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
                <a href="#" class="d-block">{{ Auth::check() ? Auth::user()->first_name . ' ' . Auth::user()->last_name : 'Guest' }}</a>
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
                <li class="nav-item {{ request()->routeIs('products.*') || request()->routeIs('categories.*') || request()->routeIs('brands.*') || request()->routeIs('reviews.*') || request()->routeIs('stock.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('products.*') || request()->routeIs('categories.*') || request()->routeIs('brands.*') || request()->routeIs('reviews.*') || request()->routeIs('stock.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Products
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.index') || request()->routeIs('products.create') || request()->routeIs('products.edit') ? 'active' : '' }}">
                                <i class="fas fa-cubes nav-icon"></i>
                                <p>All Products</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('categories.index') }}" class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <i class="fas fa-layer-group nav-icon"></i>
                                <p>Categories</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('brands.*') ? 'active' : '' }}">
                                <i class="fas fa-tags nav-icon"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                                <i class="fas fa-star nav-icon"></i>
                                <p>Reviews</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('stock.*') ? 'active' : '' }}">
                                <i class="fas fa-warehouse nav-icon"></i>
                                <p>Stock Management</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Customers -->
                <li class="nav-item {{ request()->routeIs('customers.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Customers
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}">
                                <i class="fas fa-user-friends nav-icon"></i>
                                <p>All Customers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('customers.groups.*') ? 'active' : '' }}">
                                <i class="fas fa-users-cog nav-icon"></i>
                                <p>Customer Groups</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Employees -->
                <li class="nav-item {{ request()->routeIs('employees.*') || request()->routeIs('positions.*') || request()->routeIs('departments.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('employees.*') || request()->routeIs('positions.*') || request()->routeIs('departments.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>
                            Employees
                            <i class="right fas fa-angle-left"></i>
                        </p>
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
                <!-- Orders -->
                <li class="nav-item {{ request()->routeIs('orders.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Orders
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                                <i class="fas fa-list nav-icon"></i>
                                <p>All Orders</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('orders.history') ? 'active' : '' }}">
                                <i class="fas fa-history nav-icon"></i>
                                <p>Order History</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Payments -->
                <li class="nav-item {{ request()->routeIs('payments.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                            Payments
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('payments.index') ? 'active' : '' }}">
                                <i class="fas fa-money-check-alt nav-icon"></i>
                                <p>All Payments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('payments.confirmation') ? 'active' : '' }}">
                                <i class="fas fa-check-circle nav-icon"></i>
                                <p>Confirmations</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Shipping/Logistics -->
                <li class="nav-item {{ request()->routeIs('shipping.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('shipping.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-shipping-fast"></i>
                        <p>
                            Shipping
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('shipping.index') ? 'active' : '' }}">
                                <i class="fas fa-truck nav-icon"></i>
                                <p>All Shipments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('shipping.tracking') ? 'active' : '' }}">
                                <i class="fas fa-map-marker-alt nav-icon"></i>
                                <p>Tracking</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Promotions & Coupons -->
                <li class="nav-item {{ request()->routeIs('promotions.*') || request()->routeIs('coupons.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('promotions.*') || request()->routeIs('coupons.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-gift"></i>
                        <p>
                            Promotions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('promotions.index') ? 'active' : '' }}">
                                <i class="fas fa-bullhorn nav-icon"></i>
                                <p>All Promotions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('coupons.index') ? 'active' : '' }}">
                                <i class="fas fa-ticket-alt nav-icon"></i>
                                <p>Coupons</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Reports & Analytics -->
                <li class="nav-item {{ request()->routeIs('reports.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Reports
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('reports.sales') ? 'active' : '' }}">
                                <i class="fas fa-chart-line nav-icon"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('reports.customers') ? 'active' : '' }}">
                                <i class="fas fa-user-chart nav-icon"></i>
                                <p>Customer Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('reports.products') ? 'active' : '' }}">
                                <i class="fas fa-cube nav-icon"></i>
                                <p>Product Report</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Settings -->
                <li class="nav-item {{ request()->routeIs('settings.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Settings
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('settings.store') ? 'active' : '' }}">
                                <i class="fas fa-store nav-icon"></i>
                                <p>Store Settings</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('settings.payment') ? 'active' : '' }}">
                                <i class="fas fa-credit-card nav-icon"></i>
                                <p>Payment Methods</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('settings.shipping') ? 'active' : '' }}">
                                <i class="fas fa-shipping-fast nav-icon"></i>
                                <p>Shipping Methods</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- User Management -->
                <li class="nav-item {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p>
                            User Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                                <i class="fas fa-users nav-icon"></i>
                                <p>All Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                                <i class="fas fa-user-tag nav-icon"></i>
                                <p>Roles & Permissions</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Content Management -->
                <li class="nav-item {{ request()->routeIs('pages.*') || request()->routeIs('banners.*') || request()->routeIs('blogs.*') || request()->routeIs('faqs.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('pages.*') || request()->routeIs('banners.*') || request()->routeIs('blogs.*') || request()->routeIs('faqs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>
                            Content Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('pages.index') ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Pages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('banners.index') ? 'active' : '' }}">
                                <i class="fas fa-image nav-icon"></i>
                                <p>Banners</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('blogs.index') ? 'active' : '' }}">
                                <i class="fas fa-blog nav-icon"></i>
                                <p>Blogs</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->routeIs('faqs.index') ? 'active' : '' }}">
                                <i class="fas fa-question-circle nav-icon"></i>
                                <p>FAQs</p>
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