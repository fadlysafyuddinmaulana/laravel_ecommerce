@extends('user_page.layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
    <!-- Breadcrumb Section -->
    <div class="bg-light py-3">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('landing') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Keranjang</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- End Breadcrumb -->

    <!-- Start Cart Section -->
    <div class="cart-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="mb-4">Keranjang ({{ session('cart') ? count(session('cart')) : 0 }})</h2>
                </div>
            </div>

            @if (session('cart') && count(session('cart')) > 0)
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8 mb-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-0">
                                <!-- Select All -->
                                <div class="select-all-section p-3 border-bottom bg-light">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                        <label class="form-check-label fw-semibold" for="selectAll">
                                            Pilih Semua ({{ count(session('cart')) }})
                                        </label>
                                    </div>
                                </div>

                                <!-- Cart Items List -->
                                <div class="cart-items-list">
                                    @foreach (session('cart') as $id => $item)
                                        <div class="cart-item-row border-bottom p-3" data-id="{{ $id }}"
                                            data-price="{{ $item['price'] }}">
                                            <div class="row align-items-center">
                                                <!-- Checkbox -->
                                                <div class="col-auto">
                                                    <div class="form-check">
                                                        <input class="form-check-input item-checkbox" type="checkbox"
                                                            value="{{ $id }}" id="item{{ $id }}">
                                                    </div>
                                                </div>

                                                <!-- Product Image & Info -->
                                                <div class="col">
                                                    <div class="d-flex align-items-center">
                                                        <div class="product-image me-3">
                                                            @if (isset($item['image']))
                                                                <img src="{{ asset('storage/' . $item['image']) }}"
                                                                    alt="{{ $item['name'] }}" class="rounded"
                                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                                            @else
                                                                <img src="{{ asset('assets/furni-1.0.0/images/product-1.png') }}"
                                                                    alt="{{ $item['name'] }}" class="rounded"
                                                                    style="width: 80px; height: 80px; object-fit: cover;">
                                                            @endif
                                                        </div>
                                                        <div class="product-details">
                                                            <h6 class="mb-1">{{ $item['name'] }}</h6>
                                                            @if (isset($item['variant']))
                                                                <p class="text-muted small mb-0">Variant:
                                                                    {{ $item['variant'] }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Price -->
                                                <div class="col-auto text-center" style="min-width: 120px;">
                                                    <p class="mb-0 fw-semibold">Rp
                                                        {{ number_format($item['price'], 0, ',', '.') }}</p>
                                                </div>

                                                <!-- Quantity -->
                                                <div class="col-auto">
                                                    <div class="quantity-controls d-flex align-items-center">
                                                        <button class="btn btn-sm btn-outline-secondary qty-decrease"
                                                            data-id="{{ $id }}">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input type="number"
                                                            class="form-control form-control-sm text-center mx-2 quantity-input"
                                                            value="{{ $item['quantity'] }}" min="1"
                                                            max="{{ $item['stock'] ?? 99 }}" readonly style="width: 60px;"
                                                            data-id="{{ $id }}">
                                                        <button class="btn btn-sm btn-outline-secondary qty-increase"
                                                            data-id="{{ $id }}">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Subtotal -->
                                                <div class="col-auto text-end" style="min-width: 150px;">
                                                    <p class="mb-0 fw-bold text-success item-subtotal">
                                                        Rp
                                                        {{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                                                    </p>
                                                </div>

                                                <!-- Delete -->
                                                <div class="col-auto">
                                                    <button class="btn btn-sm btn-link text-danger delete-item"
                                                        data-id="{{ $id }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm sticky-top" style="top: 20px;">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="mb-0">Ringkasan Belanja</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Total Harga (<span id="selectedCount">0</span> barang)</span>
                                    <span class="fw-semibold" id="subtotalAmount">Rp 0</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="fw-bold">Total</span>
                                    <strong class="text-success fs-5" id="totalAmount">Rp 0</strong>
                                </div>

                                <div class="promo-section mb-3 p-3 bg-warning bg-opacity-10 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-gift text-warning me-2"></i>
                                        <small class="text-muted">Pilih barang dulu sebelum pakai promo</small>
                                    </div>
                                </div>

                                <button class="btn btn-success btn-lg w-100 mb-2" id="checkoutBtn" disabled>
                                    Beli (<span id="checkoutCount">0</span>)
                                </button>
                                <a href="{{ route('shop') }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-arrow-left me-2"></i> Lanjut Belanja
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="row">
                    <div class="col-12">
                        <div class="empty-cart-section text-center py-5">
                            <i class="fas fa-shopping-cart fa-5x text-muted mb-4" style="opacity: 0.3;"></i>
                            <h4 class="mb-3">Keranjang Anda Kosong</h4>
                            <p class="text-muted mb-4">Yuk, isi dengan barang-barang pilihan Anda!</p>
                            <a href="{{ route('shop') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-shopping-bag me-2"></i> Mulai Belanja
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- End Cart Section -->

    <style>
        .cart-section {
            background-color: #f8f9fa;
            min-height: 60vh;
        }

        .cart-item-row {
            transition: background-color 0.2s;
        }

        .cart-item-row:hover {
            background-color: #f8f9fa;
        }

        .cart-item-row:last-child {
            border-bottom: none !important;
        }

        .quantity-controls .btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .quantity-controls input {
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }

        .select-all-section {
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .product-image img {
            border: 1px solid #e9ecef;
        }

        .delete-item {
            opacity: 0.6;
            transition: opacity 0.2s;
        }

        .delete-item:hover {
            opacity: 1;
        }

        @media (max-width: 991px) {
            .cart-item-row .row {
                flex-wrap: wrap;
            }

            .cart-item-row .col {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 1rem;
            }

            .cart-item-row .col-auto {
                margin-bottom: 0.5rem;
            }
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const selectAll = document.getElementById('selectAll');
                const itemCheckboxes = document.querySelectorAll('.item-checkbox');
                const checkoutBtn = document.getElementById('checkoutBtn');

                // Select All functionality
                if (selectAll) {
                    selectAll.addEventListener('change', function() {
                        itemCheckboxes.forEach(checkbox => {
                            checkbox.checked = this.checked;
                        });
                        updateSummary();
                    });
                }

                // Individual checkbox change
                itemCheckboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        updateSelectAll();
                        updateSummary();
                    });
                });

                // Update Select All checkbox state
                function updateSelectAll() {
                    if (selectAll) {
                        const allChecked = Array.from(itemCheckboxes).every(cb => cb.checked);
                        const someChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
                        selectAll.checked = allChecked;
                        selectAll.indeterminate = someChecked && !allChecked;
                    }
                }

                // Update summary
                function updateSummary() {
                    let total = 0;
                    let count = 0;

                    itemCheckboxes.forEach(checkbox => {
                        if (checkbox.checked) {
                            const itemRow = checkbox.closest('.cart-item-row');
                            const price = parseFloat(itemRow.dataset.price);
                            const quantity = parseInt(itemRow.querySelector('.quantity-input').value);
                            total += price * quantity;
                            count++;
                        }
                    });

                    document.getElementById('selectedCount').textContent = count;
                    document.getElementById('checkoutCount').textContent = count;
                    document.getElementById('subtotalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');
                    document.getElementById('totalAmount').textContent = 'Rp ' + total.toLocaleString('id-ID');

                    // Enable/disable checkout button
                    checkoutBtn.disabled = count === 0;
                }

                // Quantity increase
                document.querySelectorAll('.qty-increase').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                        const max = parseInt(input.max);
                        let value = parseInt(input.value);

                        if (value < max) {
                            input.value = value + 1;
                            updateCartQuantity(id, value + 1);
                        }
                    });
                });

                // Quantity decrease
                document.querySelectorAll('.qty-decrease').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.dataset.id;
                        const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                        let value = parseInt(input.value);

                        if (value > 1) {
                            input.value = value - 1;
                            updateCartQuantity(id, value - 1);
                        }
                    });
                });

                // Delete item
                document.querySelectorAll('.delete-item').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const id = this.dataset.id;
                        if (confirm('Hapus item dari keranjang?')) {
                            deleteCartItem(id);
                        }
                    });
                });

                // Checkout button
                if (checkoutBtn) {
                    checkoutBtn.addEventListener('click', function() {
                        const selectedItems = Array.from(itemCheckboxes)
                            .filter(cb => cb.checked)
                            .map(cb => cb.value);

                        if (selectedItems.length > 0) {
                            window.location.href = '{{ route('checkout') }}';
                        }
                    });
                }

                // Update cart quantity via AJAX
                function updateCartQuantity(id, quantity) {
                    fetch('/cart/update', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                id: id,
                                quantity: quantity
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update subtotal
                                const itemRow = document.querySelector(`.cart-item-row[data-id="${id}"]`);
                                const price = parseFloat(itemRow.dataset.price);
                                const subtotal = itemRow.querySelector('.item-subtotal');
                                subtotal.textContent = 'Rp ' + (price * quantity).toLocaleString('id-ID');
                                updateSummary();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }

                // Delete cart item via AJAX
                function deleteCartItem(id) {
                    fetch(`/cart/remove/${id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                location.reload();
                            }
                        })
                        .catch(error => console.error('Error:', error));
                }
            });
        </script>
    @endpush
@endsection
