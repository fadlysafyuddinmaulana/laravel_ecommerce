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
                            <!-- Product Item -->
                            <div class="col-12 col-md-6 col-lg-4 mb-4">
                                <a class="product-item" href="{{ route('product.show', $product->id) }}">
                                    <div class="product-image-wrapper">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                class="img-fluid product-thumbnail" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('assets/furni-1.0.0/images/product-3.png') }}"
                                                class="img-fluid product-thumbnail" alt="{{ $product->name }}">
                                        @endif

                                        @if ($product->is_featured)
                                            <span class="badge-featured">Featured</span>
                                        @endif

                                        @if ($product->stock < 10 && $product->stock > 0)
                                            <span class="badge-stock">Only {{ $product->stock }} left</span>
                                        @elseif($product->stock == 0)
                                            <span class="badge-stock out-of-stock">Out of Stock</span>
                                        @endif
                                    </div>

                                    <div class="product-details">
                                        @if ($product->category)
                                            <span
                                                class="product-category">{{ $product->category->category_name ?? $product->category->name }}</span>
                                        @endif
                                        <h3 class="product-title">{{ Str::limit($product->name ?? '-', 50) }}</h3>
                                        <strong
                                            class="product-price">{{ 'Rp ' . number_format($product->price ?? 0, 0, ',', '.') }}</strong>
                                    </div>

                                    <span class="icon-cross">
                                        <img src="{{ asset('assets/furni-1.0.0/images/cross.svg') }}" class="img-fluid">
                                    </span>
                                </a>
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

        /* Product Item Styling */
        .product-item {
            display: block;
            text-decoration: none;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            height: 100%;
        }

        .product-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
            text-decoration: none;
        }

        .product-image-wrapper {
            position: relative;
            overflow: hidden;
            background: #f9fafb;
            aspect-ratio: 1;
        }

        .product-thumbnail {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-item:hover .product-thumbnail {
            transform: scale(1.05);
        }

        .badge-featured,
        .badge-stock {
            position: absolute;
            top: 10px;
            left: 10px;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            background-color: #3b5d50;
            color: white;
            z-index: 1;
        }

        .badge-stock {
            left: auto;
            right: 10px;
            background-color: #f59e0b;
        }

        .badge-stock.out-of-stock {
            background-color: #ef4444;
        }

        .product-details {
            padding: 15px;
        }

        .product-category {
            display: inline-block;
            font-size: 11px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .product-title {
            font-size: 16px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .product-price {
            display: block;
            font-size: 18px;
            font-weight: 700;
            color: #3b5d50;
        }

        .icon-cross {
            position: absolute;
            bottom: 15px;
            right: 15px;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(59, 93, 80, 0.1);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .product-item:hover .icon-cross {
            background: #3b5d50;
        }

        .icon-cross img {
            width: 20px;
            height: 20px;
            filter: brightness(0) invert(0.3);
        }

        .product-item:hover .icon-cross img {
            filter: brightness(0) invert(1);
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
