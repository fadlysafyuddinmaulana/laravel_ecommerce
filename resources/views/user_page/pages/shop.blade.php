@extends('user_page.layouts.app')

@section('title', 'Shop')

@section('content')

    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Shop</h1>
                        <p class="mb-4">Temukan produk berkualitas dengan harga terbaik</p>
                    </div>
                </div>
                <div class="col-lg-7">
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <div class="untree_co-section product-section before-footer-section">
        <div class="container">
            <div class="row">
                <!-- Sidebar Filter -->
                <div class="col-lg-3 mb-5">
                    <div class="filter-sidebar">
                        <!-- Search Box -->
                        <div class="filter-box mb-4">
                            <h5 class="filter-title">Search Products</h5>
                            <form action="{{ route('shop') }}" method="GET" id="searchForm">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search"
                                        placeholder="Search products..." value="{{ request('search') }}">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                <!-- Hidden inputs to preserve other filters -->
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                <input type="hidden" name="min_price" id="search_min_price"
                                    value="{{ request('min_price') }}">
                                <input type="hidden" name="max_price" id="search_max_price"
                                    value="{{ request('max_price') }}">
                            </form>
                        </div>

                        <!-- Category Filter -->
                        <div class="filter-box mb-4">
                            <h5 class="filter-title d-flex justify-content-between align-items-center">
                                <span>Product Categories</span>
                                <i class="fas fa-chevron-up toggle-icon"></i>
                            </h5>
                            <div class="filter-content">
                                <form action="{{ route('shop') }}" method="GET" id="categoryForm">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="min_price" id="cat_min_price"
                                        value="{{ request('min_price') }}">
                                    <input type="hidden" name="max_price" id="cat_max_price"
                                        value="{{ request('max_price') }}">

                                    <div class="form-check mb-2">
                                        <input class="form-check-input category-filter" type="radio" name="category"
                                            id="categoryAll" value="" {{ !request('category') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="categoryAll">
                                            All Categories
                                        </label>
                                    </div>
                                    @foreach ($categories as $category)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input category-filter" type="radio" name="category"
                                                id="category{{ $category->id }}" value="{{ $category->id }}"
                                                {{ request('category') == $category->id ? 'checked' : '' }}>
                                            <label class="form-check-label" for="category{{ $category->id }}">
                                                {{ $category->category_name ?? $category->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </form>
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="filter-box mb-4">
                            <h5 class="filter-title d-flex justify-content-between align-items-center">
                                <span>Filter by Price</span>
                                <i class="fas fa-chevron-up toggle-icon"></i>
                            </h5>
                            <div class="filter-content">
                                <form action="{{ route('shop') }}" method="GET" id="priceForm">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <input type="hidden" name="category" value="{{ request('category') }}">

                                    <div class="price-range-slider mb-3">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="price-label">Min:</span>
                                            <span class="price-value" id="minPriceDisplay">Rp
                                                {{ number_format(request('min_price', $minPrice), 0, ',', '.') }}</span>
                                        </div>
                                        <input type="range" class="form-range" id="minPriceRange" name="min_price"
                                            min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                            value="{{ request('min_price', $minPrice) }}" step="10000">

                                        <div class="d-flex justify-content-between mb-2 mt-3">
                                            <span class="price-label">Max:</span>
                                            <span class="price-value" id="maxPriceDisplay">Rp
                                                {{ number_format(request('max_price', $maxPrice), 0, ',', '.') }}</span>
                                        </div>
                                        <input type="range" class="form-range" id="maxPriceRange" name="max_price"
                                            min="{{ $minPrice }}" max="{{ $maxPrice }}"
                                            value="{{ request('max_price', $maxPrice) }}" step="10000">
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100 btn-sm">Apply Filter</button>
                                </form>
                            </div>
                        </div>

                        <!-- Clear Filters -->
                        @if (request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                            <div class="text-center">
                                <a href="{{ route('shop') }}" class="btn btn-outline-secondary btn-sm w-100">
                                    <i class="fas fa-times-circle"></i> Clear All Filters
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="col-lg-9">
                    <!-- Products Header -->
                    <div class="products-header mb-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <div class="results-info mb-2 mb-md-0">
                                <p class="mb-0 text-muted">
                                    Showing <strong>{{ $products->firstItem() ?? 0 }}</strong> -
                                    <strong>{{ $products->lastItem() ?? 0 }}</strong> of
                                    <strong>{{ $products->total() }}</strong> products
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="row">
                        @forelse ($products as $product)
                            <!-- Product Item - Bootstrap Card Style -->
                            <div class="col-12 col-md-6 col-lg-4 mb-3">
                                <div class="card h-100 border shadow-sm">
                                    <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none">
                                        <div class="position-relative">
                                            {{-- Product Image --}}
                                            <div class="ratio ratio-1x1">
                                                @if ($product->image)
                                                    <img src="{{ asset('assets/furni-1.0.0/images/product-3.png') }}"
                                                        alt="{{ $product->name }}" class="w-100 h-100">
                                                @else
                                                    <img src="{{ asset('assets/furni-1.0.0/images/product-3.png') }}"
                                                        class="card-img-top" alt="{{ $product->name }}">
                                                @endif
                                            </div>

                                            {{-- Discount Badge --}}
                                            @if ($product->is_featured)
                                                <span
                                                    class="badge bg-danger position-absolute top-0 start-0 m-2">HOT</span>
                                            @endif

                                            {{-- Stock Badge --}}
                                            @if ($product->stock == 0)
                                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                                    style="background: rgba(0,0,0,0.5);">
                                                    <span class="badge bg-danger">Stok Habis</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="card-body p-2">
                                            {{-- Product Name --}}
                                            <h6 class="card-title mb-1 text-dark"
                                                style="font-size: 13px; line-height: 1.3; height: 34px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                {{ Str::limit($product->name ?? '-', 60) }}
                                            </h6>

                                            {{-- Price --}}
                                            <p class="fw-bold mb-1 text-dark" style="font-size: 16px;">
                                                {{ 'Rp' . number_format($product->price ?? 0, 0, ',', '.') }}
                                            </p>

                                            {{-- Category Tag --}}
                                            @if ($product->category)
                                                <span class="badge bg-light text-secondary mb-1" style="font-size: 10px;">
                                                    <i class="fas fa-tag"></i>
                                                    {{ $product->category->category_name ?? $product->category->name }}
                                                </span>
                                            @endif

                                            {{-- Rating & Stock --}}
                                            <div class="d-flex align-items-center text-muted mb-1"
                                                style="font-size: 11px;">
                                                <i class="fas fa-star text-warning me-1"></i>
                                                <span class="me-1">4.5</span>
                                                <span class="me-1">|</span>
                                                <span>{{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}</span>
                                            </div>

                                            {{-- Store Info --}}
                                            <div class="d-flex align-items-center border-top pt-1 mt-1 text-muted"
                                                style="font-size: 10px;">
                                                <i class="fas fa-store me-1"></i>
                                                <span class="flex-grow-1">Official Store</span>
                                                @if ($product->is_featured)
                                                    <i class="fas fa-check-circle text-primary"></i>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                                    <h4 class="text-muted">No Products Found</h4>
                                    <p class="text-muted">Try adjusting your filters or search terms</p>
                                    @if (request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                                        <a href="{{ route('shop') }}" class="btn btn-primary mt-3">
                                            <i class="fas fa-redo"></i> Clear Filters
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if ($products->hasPages())
                        <div class="d-flex justify-content-center mt-5">
                            <nav aria-label="Product pagination">
                                <ul class="pagination modern-pagination">
                                    {{-- Previous Page Link --}}
                                    @if ($products->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                <i class="fas fa-chevron-left"></i> Previous
                                            </span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $products->appends(request()->query())->previousPageUrl() }}"
                                                rel="prev">
                                                <i class="fas fa-chevron-left"></i> Previous
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pagination Elements --}}
                                    @php
                                        $currentPage = $products->currentPage();
                                        $lastPage = $products->lastPage();
                                        $range = 2; // Show 2 pages before and after current
                                    @endphp

                                    @for ($i = 1; $i <= $lastPage; $i++)
                                        @if ($i == 1 || $i == $lastPage || ($i >= $currentPage - $range && $i <= $currentPage + $range))
                                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $products->appends(request()->query())->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @elseif ($i == $currentPage - $range - 1 || $i == $currentPage + $range + 1)
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        @endif
                                    @endfor

                                    {{-- Next Page Link --}}
                                    @if ($products->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $products->appends(request()->query())->nextPageUrl() }}"
                                                rel="next">
                                                Next <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link">
                                                Next <i class="fas fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Filter Sidebar Styling */
        .filter-sidebar {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .filter-box {
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .filter-box:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .filter-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 15px;
            cursor: pointer;
            user-select: none;
        }

        .filter-title .toggle-icon {
            font-size: 12px;
            transition: transform 0.3s ease;
        }

        .filter-title.collapsed .toggle-icon {
            transform: rotate(180deg);
        }

        .filter-content {
            transition: all 0.3s ease;
        }

        .form-check-label {
            font-size: 14px;
            color: #374151;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: #3b5d50;
            border-color: #3b5d50;
        }

        .form-check-input:focus {
            border-color: #3b5d50;
            box-shadow: 0 0 0 0.2rem rgba(59, 93, 80, 0.25);
        }

        /* Search Box Styling */
        .input-group .form-control {
            border-radius: 8px 0 0 8px;
            border: 1px solid #e5e7eb;
        }

        .input-group .form-control:focus {
            border-color: #3b5d50;
            box-shadow: none;
        }

        .input-group .btn {
            border-radius: 0 8px 8px 0;
            background-color: #3b5d50;
            border-color: #3b5d50;
        }

        .input-group .btn:hover {
            background-color: #2d4a3e;
            border-color: #2d4a3e;
        }

        /* Price Range Styling */
        .price-label {
            font-size: 14px;
            font-weight: 500;
            color: #374151;
        }

        .price-value {
            font-size: 14px;
            font-weight: 600;
            color: #3b5d50;
        }

        .form-range {
            height: 6px;
        }

        .form-range::-webkit-slider-thumb {
            background: #3b5d50;
            width: 16px;
            height: 16px;
        }

        .form-range::-moz-range-thumb {
            background: #3b5d50;
            width: 16px;
            height: 16px;
        }

        .form-range::-webkit-slider-runnable-track {
            background: #e5e7eb;
        }

        /* Products Header */
        .products-header {
            padding: 15px 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .results-info {
            font-size: 14px;
        }

        /* Minimal Custom CSS for Bootstrap Cards */
        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transition: all 0.3s ease;
        }

        .card-img-top {
            transition: transform 0.3s ease;
        }

        .card:hover .card-img-top {
            transform: scale(1.05);
        }

        /* Empty State */
        .empty-state {
            padding: 40px 20px;
        }

        .empty-state i {
            opacity: 0.3;
        }

        /* Pagination Styling */
        .modern-pagination {
            gap: 8px;
            margin-bottom: 0;
        }

        .modern-pagination .page-item {
            margin: 0;
        }

        .modern-pagination .page-link {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #374151;
            font-weight: 500;
            padding: 10px 16px;
            transition: all 0.2s;
            background-color: white;
        }

        .modern-pagination .page-link:hover {
            background-color: #f3f4f6;
            border-color: #d1d5db;
            color: #111827;
        }

        .modern-pagination .page-item.active .page-link {
            background-color: #3b5d50;
            border-color: #3b5d50;
            color: white;
            font-weight: 600;
        }

        .modern-pagination .page-item.disabled .page-link {
            background-color: #f9fafb;
            border-color: #e5e7eb;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .modern-pagination .page-link i {
            font-size: 12px;
        }

        /* Button Styling */
        .btn-primary {
            background-color: #3b5d50;
            border-color: #3b5d50;
        }

        .btn-primary:hover {
            background-color: #2d4a3e;
            border-color: #2d4a3e;
        }

        .btn-outline-secondary {
            color: #6b7280;
            border-color: #d1d5db;
        }

        .btn-outline-secondary:hover {
            background-color: #f3f4f6;
            color: #374151;
            border-color: #9ca3af;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .filter-sidebar {
                margin-bottom: 30px;
            }
        }

        @media (max-width: 576px) {
            .product-title {
                font-size: 14px;
            }

            .product-price {
                font-size: 16px;
            }

            .products-header {
                padding: 10px 15px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Price Range Sliders
            const minPriceRange = document.getElementById('minPriceRange');
            const maxPriceRange = document.getElementById('maxPriceRange');
            const minPriceDisplay = document.getElementById('minPriceDisplay');
            const maxPriceDisplay = document.getElementById('maxPriceDisplay');

            if (minPriceRange && maxPriceRange) {
                minPriceRange.addEventListener('input', function() {
                    const minValue = parseInt(this.value);
                    const maxValue = parseInt(maxPriceRange.value);

                    if (minValue > maxValue) {
                        this.value = maxValue;
                    }

                    minPriceDisplay.textContent = 'Rp ' + parseInt(this.value).toLocaleString('id-ID');

                    // Update hidden inputs in other forms
                    document.getElementById('search_min_price').value = this.value;
                    document.getElementById('cat_min_price').value = this.value;
                });

                maxPriceRange.addEventListener('input', function() {
                    const minValue = parseInt(minPriceRange.value);
                    const maxValue = parseInt(this.value);

                    if (maxValue < minValue) {
                        this.value = minValue;
                    }

                    maxPriceDisplay.textContent = 'Rp ' + parseInt(this.value).toLocaleString('id-ID');

                    // Update hidden inputs in other forms
                    document.getElementById('search_max_price').value = this.value;
                    document.getElementById('cat_max_price').value = this.value;
                });
            }

            // Auto-submit category filter
            const categoryFilters = document.querySelectorAll('.category-filter');
            categoryFilters.forEach(filter => {
                filter.addEventListener('change', function() {
                    document.getElementById('categoryForm').submit();
                });
            });

            // Toggle filter sections
            const filterTitles = document.querySelectorAll('.filter-title');
            filterTitles.forEach(title => {
                title.addEventListener('click', function() {
                    const content = this.nextElementSibling;
                    this.classList.toggle('collapsed');

                    if (this.classList.contains('collapsed')) {
                        content.style.display = 'none';
                    } else {
                        content.style.display = 'block';
                    }
                });
            });

            // Search form enter key handling
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput) {
                searchInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        document.getElementById('searchForm').submit();
                    }
                });
            }
        });
    </script>
@endpush
