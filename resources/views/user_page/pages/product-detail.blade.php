@extends('user_page.layouts.app')

@section('title', $product->name)

@section('content')
    <!-- Breadcrumb Section -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shop') }}" class="text-decoration-none">Shop</a></li>
                    @if ($product->category)
                        <li class="breadcrumb-item"><a href="{{ route('shop') }}"
                                class="text-decoration-none">{{ $product->category->name ?? $product->category->category_name }}</a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($product->name, 50) }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Product Detail Section -->
    <div class="product-detail-section py-5">
        <div class="container">
            <div class="row">
                <!-- Product Image -->
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="product-image-container sticky-top" style="top: 20px;">
                        <div class="main-image-wrapper mb-3">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="img-fluid rounded main-product-image" id="mainImage">
                            @else
                                <img src="{{ asset('assets/furni-1.0.0/images/product-1.png') }}" alt="{{ $product->name }}"
                                    class="img-fluid rounded main-product-image" id="mainImage">
                            @endif
                        </div>

                        <!-- Thumbnail Gallery -->
                        <div class="thumbnail-gallery d-flex gap-2">
                            @if ($product->image)
                                <div class="thumbnail-item active">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="img-fluid rounded cursor-pointer">
                                </div>
                            @else
                                <div class="thumbnail-item active">
                                    <img src="{{ asset('assets/furni-1.0.0/images/product-1.png') }}"
                                        alt="{{ $product->name }}" class="img-fluid rounded cursor-pointer">
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-lg-7">
                    <div class="product-detail-content">
                        <!-- Product Title -->
                        <h1 class="product-title mb-3">{{ $product->name }}</h1>

                        <!-- Rating & Sold (Optional - can be added later) -->
                        <div class="product-meta mb-3 d-flex align-items-center gap-3">
                            <div class="rating">
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <i class="fas fa-star text-warning"></i>
                                <span class="ms-1 text-muted">({{ rand(100, 500) }} rating)</span>
                            </div>
                            <span class="text-muted">•</span>
                            <span class="text-muted">Terjual {{ rand(50, 200) }}+</span>
                        </div>

                        <!-- Product Price -->
                        <div class="price-section bg-light p-3 rounded mb-4">
                            <div class="price-wrapper">
                                <h2 class="product-price mb-0">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </h2>
                                @if (rand(0, 1))
                                    <!-- Random discount for demo -->
                                    <div class="original-price mt-1">
                                        <span class="text-muted text-decoration-line-through">Rp
                                            {{ number_format($product->price * 1.3, 0, ',', '.') }}</span>
                                        <span class="badge bg-danger ms-2">23% OFF</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Product Info Table -->
                        <div class="product-info-table mb-4">
                            @if ($product->category)
                                <div class="info-row d-flex py-2 border-bottom">
                                    <div class="info-label text-muted" style="width: 150px;">Category:</div>
                                    <div class="info-value fw-semibold">
                                        {{ $product->category->name ?? $product->category->category_name }}</div>
                                </div>
                            @endif

                            @if ($product->brand)
                                <div class="info-row d-flex py-2 border-bottom">
                                    <div class="info-label text-muted" style="width: 150px;">Brand:</div>
                                    <div class="info-value fw-semibold">{{ $product->brand }}</div>
                                </div>
                            @endif

                            <div class="info-row d-flex py-2 border-bottom">
                                <div class="info-label text-muted" style="width: 150px;">Stock:</div>
                                <div class="info-value">
                                    @if ($product->stock > 0)
                                        <span class="badge bg-success">{{ $product->stock }} Available</span>
                                    @else
                                        <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </div>
                            </div>

                            @if ($product->status)
                                <div class="info-row d-flex py-2 border-bottom">
                                    <div class="info-label text-muted" style="width: 150px;">Status:</div>
                                    <div class="info-value">
                                        <span class="badge bg-info">{{ ucfirst($product->status) }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($product->is_featured)
                                <div class="info-row d-flex py-2">
                                    <div class="info-label text-muted" style="width: 150px;">Featured:</div>
                                    <div class="info-value">
                                        <span class="badge bg-warning text-dark">
                                            <i class="fas fa-star"></i> Featured Product
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Quantity Selector -->
                        <div class="quantity-section mb-4">
                            <label class="form-label fw-semibold mb-2">Quantity</label>
                            <div class="quantity-controls d-flex align-items-center gap-3">
                                <div class="input-group quantity-input-group" style="width: 150px;">
                                    <button class="btn btn-outline-secondary" type="button" id="decreaseQty">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" class="form-control text-center" id="quantity" name="quantity"
                                        value="1" min="1" max="{{ $product->stock }}" readonly
                                        @if ($product->stock <= 0) disabled @endif>
                                    <button class="btn btn-outline-secondary" type="button" id="increaseQty">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <span class="text-muted">Stock: <strong>{{ $product->stock }}</strong></span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="action-buttons mb-4">
                            <div class="row g-2">
                                @if ($product->stock > 0)
                                    <div class="col-12 col-md-6">
                                        <button type="button" class="btn btn-outline-success btn-lg w-100"
                                            id="addToCartBtn">
                                            <i class="fas fa-shopping-cart"></i> Add to Cart
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <button type="button" class="btn btn-success btn-lg w-100" id="buyNowBtn">
                                            <i class="fas fa-bolt"></i> Buy Now
                                        </button>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <button type="button" class="btn btn-secondary btn-lg w-100" disabled>
                                            <i class="fas fa-times"></i> Out of Stock
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Additional Actions -->
                        <div class="additional-actions d-flex gap-2 mb-4">
                            <button class="btn btn-outline-secondary flex-fill" id="chatBtn">
                                <i class="far fa-comment-dots"></i> Chat
                            </button>
                            <button class="btn btn-outline-secondary flex-fill" id="wishlistBtn">
                                <i class="far fa-heart"></i> Wishlist
                            </button>
                            <button class="btn btn-outline-secondary flex-fill" id="shareBtn">
                                <i class="fas fa-share-alt"></i> Share
                            </button>
                        </div>

                        <!-- Back to Shop -->
                        <div class="back-to-shop">
                            <a href="{{ route('shop') }}" class="text-decoration-none text-muted">
                                <i class="fas fa-arrow-left"></i> Back to Shop
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Tabs Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <ul class="nav nav-tabs product-tabs" id="productTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab">
                                Detail Product
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specification-tab" data-bs-toggle="tab"
                                data-bs-target="#specification" type="button" role="tab">
                                Specification
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab">
                                Reviews
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content product-tab-content p-4 bg-white border border-top-0" id="productTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <h5 class="mb-3">Product Description</h5>
                            @if ($product->description)
                                <p style="line-height: 1.8; color: #495057;">{{ $product->description }}</p>
                            @else
                                <p class="text-muted">No description available for this product.</p>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="specification" role="tabpanel">
                            <h5 class="mb-3">Product Specifications</h5>
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="fw-semibold" style="width: 200px;">Product Name</td>
                                        <td>{{ $product->name }}</td>
                                    </tr>
                                    @if ($product->brand)
                                        <tr>
                                            <td class="fw-semibold">Brand</td>
                                            <td>{{ $product->brand }}</td>
                                        </tr>
                                    @endif
                                    @if ($product->category)
                                        <tr>
                                            <td class="fw-semibold">Category</td>
                                            <td>{{ $product->category->name ?? $product->category->category_name }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="fw-semibold">Stock</td>
                                        <td>{{ $product->stock }} units</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Status</td>
                                        <td>{{ ucfirst($product->status ?? 'active') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <h5 class="mb-3">Customer Reviews</h5>
                            <div class="text-center py-5">
                                <i class="fas fa-star fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products Section -->
            @if (isset($relatedProducts) && $relatedProducts->count() > 0)
                <div class="row mt-5 pt-5">
                    <div class="col-12">
                        <h3 class="mb-4">Related Products</h3>
                    </div>

                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="col-12 col-md-4 col-lg-3 mb-5">
                            <a class="product-item" href="{{ route('product.show', $relatedProduct->id) }}">
                                @if ($relatedProduct->image)
                                    <img src="{{ asset('storage/' . $relatedProduct->image) }}"
                                        class="img-fluid product-thumbnail" alt="{{ $relatedProduct->name }}">
                                @else
                                    <img src="{{ asset('assets/furni-1.0.0/images/product-1.png') }}"
                                        class="img-fluid product-thumbnail" alt="{{ $relatedProduct->name }}">
                                @endif
                                <h3 class="product-title">{{ $relatedProduct->name }}</h3>
                                <strong class="product-price">Rp
                                    {{ number_format($relatedProduct->price, 0, ',', '.') }}</strong>

                                <span class="icon-cross">
                                    <img src="{{ asset('assets/furni-1.0.0/images/cross.svg') }}" class="img-fluid">
                                </span>
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <!-- End Product Detail Section -->

    <style>
        /* Product Detail Styling */
        .product-detail-section {
            background-color: #f8f9fa;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
            color: #6c757d;
        }

        .main-image-wrapper {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .main-product-image {
            max-height: 500px;
            object-fit: contain;
            width: 100%;
        }

        .thumbnail-gallery {
            overflow-x: auto;
        }

        .thumbnail-item {
            min-width: 80px;
            height: 80px;
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
        }

        .thumbnail-item.active {
            border-color: #3b5d50;
        }

        .thumbnail-item:hover {
            border-color: #3b5d50;
            opacity: 0.8;
        }

        .thumbnail-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-detail-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .product-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: #212529;
            line-height: 1.4;
        }

        .product-meta {
            font-size: 0.9rem;
        }

        .price-section {
            border-left: 4px solid #3b5d50;
        }

        .product-price {
            font-size: 2rem;
            font-weight: 700;
            color: #3b5d50;
        }

        .original-price {
            font-size: 0.9rem;
        }

        .product-info-table .info-row:last-child {
            border-bottom: none !important;
        }

        .quantity-input-group {
            border-radius: 8px;
            overflow: hidden;
        }

        .quantity-input-group .btn {
            border-radius: 0;
            padding: 0.5rem 1rem;
        }

        .quantity-input-group input {
            border-left: none;
            border-right: none;
            font-weight: 600;
        }

        .action-buttons .btn {
            font-weight: 600;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
        }

        .additional-actions .btn {
            border-radius: 8px;
            font-size: 0.9rem;
        }

        .product-tabs .nav-link {
            color: #6c757d;
            font-weight: 500;
            border: none;
            border-bottom: 3px solid transparent;
            padding: 1rem 1.5rem;
        }

        .product-tabs .nav-link:hover {
            color: #3b5d50;
            border-bottom-color: #3b5d50;
        }

        .product-tabs .nav-link.active {
            color: #3b5d50;
            border-bottom-color: #3b5d50;
            background-color: transparent;
        }

        .product-tab-content {
            min-height: 300px;
            border-radius: 0 0 10px 10px;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .product-title {
                font-size: 1.5rem;
            }

            .product-price {
                font-size: 1.5rem;
            }

            .product-detail-content {
                padding: 20px;
            }

            .main-product-image {
                max-height: 300px;
            }
        }
    </style>

    @push('scripts')
        <script>
            // Function to update cart badge
            function updateCartBadge(count) {
                const cartBadge = document.getElementById('cartCount');
                const cartItemCount = document.getElementById('cartItemCount');

                if (count > 0) {
                    if (cartBadge) {
                        cartBadge.textContent = count;
                        cartBadge.style.display = 'inline-block';
                    } else {
                        // Create badge if it doesn't exist
                        const cartLink = document.getElementById('cartDropdown');
                        if (cartLink) {
                            const newBadge = document.createElement('span');
                            newBadge.className = 'cart-badge';
                            newBadge.id = 'cartCount';
                            newBadge.textContent = count;
                            cartLink.appendChild(newBadge);
                        }
                    }

                    // Update cart item count in dropdown header
                    if (cartItemCount) {
                        cartItemCount.textContent = count;
                    }
                } else {
                    if (cartBadge) {
                        cartBadge.style.display = 'none';
                    }
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Quantity controls
                const quantityInput = document.getElementById('quantity');
                const decreaseBtn = document.getElementById('decreaseQty');
                const increaseBtn = document.getElementById('increaseQty');
                const maxStock = {{ $product->stock }};

                if (decreaseBtn) {
                    decreaseBtn.addEventListener('click', function() {
                        let currentValue = parseInt(quantityInput.value);
                        if (currentValue > 1) {
                            quantityInput.value = currentValue - 1;
                        }
                    });
                }

                if (increaseBtn) {
                    increaseBtn.addEventListener('click', function() {
                        let currentValue = parseInt(quantityInput.value);
                        if (currentValue < maxStock) {
                            quantityInput.value = currentValue + 1;
                        }
                    });
                }

                // Add to Cart
                const addToCartBtn = document.getElementById('addToCartBtn');
                if (addToCartBtn) {
                    addToCartBtn.addEventListener('click', function() {
                        const quantity = parseInt(quantityInput.value);
                        const button = this;
                        const originalText = button.innerHTML;

                        // Disable button and show loading
                        button.disabled = true;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';

                        fetch('{{ route('cart.add') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .content,
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    product_id: {{ $product->id }},
                                    quantity: quantity
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Refresh cart dropdown to show new item
                                    if (typeof refreshCartDropdown === 'function') {
                                        refreshCartDropdown();
                                    }

                                    // Show success message
                                    button.innerHTML = '<i class="fas fa-check"></i> Added!';
                                    button.classList.remove('btn-outline-success');
                                    button.classList.add('btn-success');

                                    // Reset button after 2 seconds
                                    setTimeout(() => {
                                        button.innerHTML = originalText;
                                        button.classList.add('btn-outline-success');
                                        button.classList.remove('btn-success');
                                        button.disabled = false;
                                    }, 2000);

                                    // Show toast notification
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: data.message,
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 3000,
                                        timerProgressBar: true
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: data.message
                                    });
                                    button.innerHTML = originalText;
                                    button.disabled = false;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan!',
                                    text: 'Terjadi kesalahan saat menambahkan ke keranjang'
                                });
                                button.innerHTML = originalText;
                                button.disabled = false;
                            });
                    });
                }

                // Buy Now
                const buyNowBtn = document.getElementById('buyNowBtn');
                if (buyNowBtn) {
                    buyNowBtn.addEventListener('click', function() {
                        const quantity = parseInt(quantityInput.value);
                        const button = this;
                        const originalText = button.innerHTML;

                        // Disable button and show loading
                        button.disabled = true;
                        button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

                        // Add to cart first
                        fetch('{{ route('cart.add') }}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                        .content,
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    product_id: {{ $product->id }},
                                    quantity: quantity
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Redirect to cart page
                                    window.location.href = '{{ route('cart') }}';
                                } else {
                                    alert('Error: ' + data.message);
                                    button.innerHTML = originalText;
                                    button.disabled = false;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Terjadi kesalahan');
                                button.innerHTML = originalText;
                                button.disabled = false;
                            });
                    });
                }

                // Wishlist
                const wishlistBtn = document.getElementById('wishlistBtn');
                if (wishlistBtn) {
                    wishlistBtn.addEventListener('click', function() {
                        const icon = this.querySelector('i');
                        if (icon.classList.contains('far')) {
                            icon.classList.remove('far');
                            icon.classList.add('fas');
                            this.classList.add('btn-success');
                            this.classList.remove('btn-outline-secondary');
                            alert('Added to wishlist!');
                        } else {
                            icon.classList.remove('fas');
                            icon.classList.add('far');
                            this.classList.remove('btn-success');
                            this.classList.add('btn-outline-secondary');
                            alert('Removed from wishlist!');
                        }
                    });
                }

                // Share
                const shareBtn = document.getElementById('shareBtn');
                if (shareBtn) {
                    shareBtn.addEventListener('click', function() {
                        if (navigator.share) {
                            navigator.share({
                                title: '{{ $product->name }}',
                                text: 'Check out this product!',
                                url: window.location.href
                            });
                        } else {
                            // Fallback - copy to clipboard
                            navigator.clipboard.writeText(window.location.href);
                            alert('Product link copied to clipboard!');
                        }
                    });
                }

                // Chat
                const chatBtn = document.getElementById('chatBtn');
                if (chatBtn) {
                    chatBtn.addEventListener('click', function() {
                        Swal.fire({
                            icon: 'info',
                            title: 'Coming Soon!',
                            text: 'Chat feature will be implemented soon!'
                        });
                    });
                }

                // Thumbnail click
                const thumbnails = document.querySelectorAll('.thumbnail-item');
                thumbnails.forEach(thumb => {
                    thumb.addEventListener('click', function() {
                        thumbnails.forEach(t => t.classList.remove('active'));
                        this.classList.add('active');
                        const imgSrc = this.querySelector('img').src;
                        document.getElementById('mainImage').src = imgSrc;
                    });
                });
            });
        </script>
    @endpush

@endsection
