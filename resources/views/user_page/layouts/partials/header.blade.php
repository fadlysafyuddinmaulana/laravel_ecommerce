<!-- Start Header/Navigation -->
<nav id="mainHeader" class="custom-navbar navbar navbar-expand-md navbar-dark bg-dark" arial-label="Furni navigation bar">
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
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog') ? 'active' : '' }}" href="{{ route('blog') }}">Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact
                        us</a>
                </li>
            </ul>

            <ul class="custom-navbar-cta navbar-nav mb-2 mb-md-0 ms-5">
                <!-- Cart Dropdown -->
                <li class="nav-item dropdown cart-dropdown">
                    <a class="nav-link position-relative" href="#" id="cartDropdown" role="button">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        @if (session('cart') && count(session('cart')) > 0)
                            <span class="cart-badge" id="cartCount">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-cart dropdown-menu-end" aria-labelledby="cartDropdown">
                        <div class="cart-dropdown-header px-3 py-2 border-bottom">
                            <h6 class="mb-0">Keranjang (<span
                                    id="cartItemCount">{{ session('cart') ? count(session('cart')) : 0 }}</span>)</h6>
                        </div>
                        <div class="cart-dropdown-body" id="cartDropdownBody">
                            @if (session('cart') && count(session('cart')) > 0)
                                @foreach (session('cart') as $id => $item)
                                    <div class="cart-item d-flex p-3 border-bottom" data-id="{{ $id }}">
                                        <div class="cart-item-image me-3">
                                            <img src="{{ asset('storage/' . ($item['image'] ?? 'default.png')) }}"
                                                alt="{{ $item['name'] }}" class="rounded"
                                                style="width: 60px; height: 60px; object-fit: cover;">
                                        </div>
                                        <div class="cart-item-details flex-grow-1">
                                            <h6 class="mb-1 text-truncate" style="max-width: 200px;">
                                                {{ $item['name'] }}</h6>
                                            <p class="mb-1 text-muted small">{{ $item['quantity'] }} x Rp
                                                {{ number_format($item['price'], 0, ',', '.') }}</p>
                                            <p class="mb-0 fw-bold text-success">Rp
                                                {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                                            </p>
                                        </div>
                                        <button class="btn btn-sm btn-link text-danger p-0 ms-2"
                                            onclick="removeFromCart({{ $id }})">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-cart text-center py-5">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Keranjang Anda kosong</p>
                                </div>
                            @endif
                        </div>
                        <div class="cart-dropdown-footer p-3 border-top" id="cartDropdownFooter"
                            style="display: {{ session('cart') && count(session('cart')) > 0 ? 'block' : 'none' }}">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total</span>
                                <strong class="text-success" id="cartTotal">
                                    Rp
                                    {{ number_format(
                                        collect(session('cart'))->sum(function ($item) {
                                            return $item['quantity'] * $item['price'];
                                        }),
                                        0,
                                        ',',
                                        '.',
                                    ) }}
                                </strong>
                            </div>
                            <a href="{{ route('cart') }}" class="btn btn-success w-100">Lihat Keranjang</a>
                        </div>
                    </div>
                </li>

                @if (!Auth::check())
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
                            <form id="logout-link" action="{{ route('logout') }}" method="POST"
                                style="display:none;">
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

        // Cart Dropdown on hover with delay
        var cartDropdown = document.querySelector('.cart-dropdown');
        var cartDropdownTimeout;
        if (window.matchMedia('(min-width: 768px)').matches && cartDropdown) {
            cartDropdown.addEventListener('mouseenter', function() {
                clearTimeout(cartDropdownTimeout);
                var dropdownMenu = this.querySelector('.dropdown-menu-cart');
                this.classList.add('show');
                dropdownMenu.classList.add('show');
            });
            cartDropdown.addEventListener('mouseleave', function() {
                var dropdownMenu = this.querySelector('.dropdown-menu-cart');
                var dropdown = this;
                cartDropdownTimeout = setTimeout(function() {
                    dropdown.classList.remove('show');
                    dropdownMenu.classList.remove('show');
                }, 300); // 300ms delay
            });
        }

        // User Dropdown on hover for desktop
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

    // Refresh cart dropdown function
    function refreshCartDropdown() {
        fetch('/cart/dropdown', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count badge
                    const cartBadge = document.getElementById('cartCount');
                    const cartItemCount = document.getElementById('cartItemCount');

                    if (data.cart_count > 0) {
                        if (cartBadge) {
                            cartBadge.textContent = data.cart_count;
                            cartBadge.style.display = 'inline-block';
                        } else {
                            const cartLink = document.getElementById('cartDropdown');
                            if (cartLink) {
                                const badge = document.createElement('span');
                                badge.className = 'cart-badge';
                                badge.id = 'cartCount';
                                badge.textContent = data.cart_count;
                                cartLink.appendChild(badge);
                            }
                        }
                        if (cartItemCount) {
                            cartItemCount.textContent = data.cart_count;
                        }
                    } else {
                        if (cartBadge) cartBadge.style.display = 'none';
                        if (cartItemCount) cartItemCount.textContent = '0';
                    }

                    // Update dropdown body
                    const cartDropdownBody = document.getElementById('cartDropdownBody');
                    if (cartDropdownBody) {
                        cartDropdownBody.innerHTML = data.html;
                    }

                    // Update total and footer visibility
                    const cartDropdownFooter = document.getElementById('cartDropdownFooter');
                    const cartTotal = document.getElementById('cartTotal');

                    if (data.cart_count > 0) {
                        if (cartDropdownFooter) {
                            cartDropdownFooter.style.display = 'block';
                        }
                        if (cartTotal && data.total) {
                            cartTotal.innerHTML = 'Rp ' + data.total;
                        }
                    } else {
                        if (cartDropdownFooter) {
                            cartDropdownFooter.style.display = 'none';
                        }
                    }
                }
            })
            .catch(error => console.error('Error refreshing cart:', error));
    }

    // Remove from cart function
    function removeFromCart(productId) {
        if (confirm('Hapus item dari keranjang?')) {
            fetch(`/cart/remove/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        refreshCartDropdown();
                    }
                });
        }
    }
</script>

<style>
    /* Cart Badge - Tokopedia Style */
    .cart-badge {
        position: absolute;
        top: -8px;
        right: -10px;
        background-color: #ee4d2d;
        color: white;
        border-radius: 12px;
        padding: 2px 6px;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.4;
        min-width: 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
        z-index: 10;
    }

    .cart-dropdown .nav-link {
        position: relative;
        padding: 0.5rem 1rem;
    }

    .cart-dropdown .nav-link i {
        font-size: 1.3rem;
    }

    /* Cart Dropdown */
    .dropdown-menu-cart {
        width: 380px;
        max-height: 500px;
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        margin-top: 10px;
    }

    .cart-dropdown-header {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .cart-dropdown-body {
        max-height: 300px;
        overflow-y: auto;
    }

    .cart-dropdown-body::-webkit-scrollbar {
        width: 6px;
    }

    .cart-dropdown-body::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .cart-dropdown-body::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .cart-item {
        transition: background-color 0.2s;
    }

    .cart-item:hover {
        background-color: #f8f9fa;
    }

    .cart-item-image img {
        border: 1px solid #e9ecef;
    }

    .empty-cart i {
        opacity: 0.3;
    }

    /* Header scrolled state */
    .header-scrolled .navbar-brand,
    .header-scrolled .nav-link {
        color: #212529 !important;
    }

    @media (max-width: 767px) {
        .dropdown-menu-cart {
            width: 100vw;
            max-width: 100%;
        }
    }

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
