@extends('user_page.layouts.app')

@section('title', 'Checkout')

@push('styles')
    <style>
        body {
            background: #f8f9fa;
        }

        .checkout-wrapper {
            padding: 40px 0;
            min-height: 100vh;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 300;
            margin-bottom: 30px;
        }

        .card {
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            margin-bottom: 20px;
        }

        .card-header {
            background-color: #f7f7f9;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            padding: 0.75rem 1.25rem;
        }

        .card-header h4 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 400;
        }

        .card-body {
            padding: 1.25rem;
        }

        .list-group-item {
            border-left: 0;
            border-right: 0;
            border-radius: 0;
        }

        .list-group-item:first-child {
            border-top: 0;
        }

        .badge-secondary {
            background-color: #6c757d;
        }

        .text-muted {
            font-size: 0.875rem;
        }

        .form-control:focus,
        .custom-select:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .btn-lg {
            padding: 0.5rem 1rem;
            font-size: 1.25rem;
        }

        hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
        }

        /* Improved spacing for form fields */
        .row {
            gap: 0;
        }

        .row>[class*='col-'] {
            padding-left: 10px;
            padding-right: 10px;
        }

        .mb-3 {
            margin-bottom: 1.5rem !important;
        }

        label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
            color: #495057;
        }

        label .text-danger {
            color: #dc3545;
            font-size: 0.875rem;
        }

        /* Disabled select styling */
        select:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content')
    <div class="checkout-wrapper">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="page-title">Checkout</h2>
            </div>

            <div class="row">
                <!-- Order Summary (Right Side on Desktop) -->
                <div class="col-md-4 order-md-2 mb-4">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <span class="text-muted">Your cart</span>
                                <span class="badge badge-secondary badge-pill ml-2">{{ count($cart) }}</span>
                            </h4>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach ($cart as $id => $item)
                                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                                        <div class="d-flex align-items-center">
                                            @if (isset($item['image']))
                                                <img src="{{ asset('storage/' . $item['image']) }}"
                                                    alt="{{ $item['name'] }}" class="mr-3"
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <img src="{{ asset('assets/furni-1.0.0/images/product-1.png') }}"
                                                    alt="{{ $item['name'] }}" class="mr-3"
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                            @endif
                                            <div>
                                                <h6 class="my-0">{{ $item['name'] }}</h6>
                                                <small class="text-muted">Qty: {{ $item['quantity'] }}</small>
                                            </div>
                                        </div>
                                        <span class="text-muted">${{ number_format($item['price'], 2) }}</span>
                                    </li>
                                @endforeach

                                <!-- Price Details -->
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Subtotal</span>
                                    <strong>${{ number_format($subtotal, 2) }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Delivery Fee</span>
                                    <strong>${{ number_format($delivery, 2) }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-success">Discount</span>
                                    <strong class="text-success">-${{ number_format($discount, 2) }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Tax (10%)</span>
                                    <strong>${{ number_format($tax, 2) }}</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Total (USD)</span>
                                    <strong>${{ number_format($total, 2) }}</strong>
                                </li>
                            </ul>

                            <!-- Promo Code -->
                            <div class="card-body">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Promo code">
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary">Redeem</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checkout Form (Left Side) -->
                <div class="col-md-8 order-md-1">
                    <form action="{{ route('checkout.process') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <!-- Delivery Address Card -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Delivery Address</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="firstName">First name</label>
                                        <input type="text" class="form-control" id="firstName" name="first_name"
                                            placeholder="John" required>
                                        <div class="invalid-feedback">
                                            Valid first name is required.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastName">Last name</label>
                                        <input type="text" class="form-control" id="lastName" name="last_name"
                                            placeholder="Doe" required>
                                        <div class="invalid-feedback">
                                            Valid last name is required.
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="email">Email <span class="text-muted">(Optional)</span></label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="you@example.com">
                                </div>

                                <div class="mb-3">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="1234 Main St" required>
                                    <div class="invalid-feedback">
                                        Please enter your shipping address.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
                                    <input type="text" class="form-control" id="address2" name="address2"
                                        placeholder="Apartment or suite">
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="country">Country <span class="text-danger">*</span></label>
                                        <select class="custom-select d-block w-100" id="country" name="country" required>
                                            <option value="">Choose country...</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a country.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="province">Province <span class="text-danger">*</span></label>
                                        <select class="custom-select d-block w-100" id="province" name="province"
                                            required disabled>
                                            <option value="">Choose province...</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a province.
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="city">City <span class="text-danger">*</span></label>
                                        <select class="custom-select d-block w-100" id="city" name="city"
                                            required disabled>
                                            <option value="">Choose city...</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a city.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="postal_code">Postal Code</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code"
                                            placeholder="Automatically filled" readonly>
                                    </div>
                                </div>

                                <hr class="mb-4">

                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="same-address" checked>
                                    <label class="custom-control-label" for="same-address">Shipping address is the same as
                                        my billing address</label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="save-info">
                                    <label class="custom-control-label" for="save-info">Save this information for next
                                        time</label>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Card -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="mb-0">Payment</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-block my-3">
                                    <div class="custom-control custom-radio">
                                        <input id="credit" name="paymentMethod" type="radio"
                                            class="custom-control-input" checked required>
                                        <label class="custom-control-label" for="credit">Credit card</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="debit" name="paymentMethod" type="radio"
                                            class="custom-control-input" required>
                                        <label class="custom-control-label" for="debit">Debit card</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input id="paypal" name="paymentMethod" type="radio"
                                            class="custom-control-input" required>
                                        <label class="custom-control-label" for="paypal">PayPal</label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="cc-name">Name on card</label>
                                        <input type="text" class="form-control" id="cc-name" name="card_name"
                                            placeholder="Full name as displayed on card" required>
                                        <small class="text-muted">Full name as displayed on card</small>
                                        <div class="invalid-feedback">
                                            Name on card is required
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="cc-number">Credit card number</label>
                                        <input type="text" class="form-control" id="cc-number" name="card_number"
                                            placeholder="1234 5678 9012 3456" required>
                                        <div class="invalid-feedback">
                                            Credit card number is required
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="cc-expiration">Expiration</label>
                                        <input type="text" class="form-control" id="cc-expiration" name="card_expiry"
                                            placeholder="MM/YY" required>
                                        <div class="invalid-feedback">
                                            Expiration date required
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="cc-cvv">CVV</label>
                                        <input type="text" class="form-control" id="cc-cvv" name="card_cvv"
                                            placeholder="123" required>
                                        <div class="invalid-feedback">
                                            Security code required
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="mb-5">
                        <button class="btn btn-primary btn-lg btn-block mb-5" type="submit">Continue to checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Bootstrap form validation
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        // Format card number input
        const cardNumberInput = document.getElementById('cc-number');
        if (cardNumberInput) {
            cardNumberInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\s/g, '');
                let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
                e.target.value = formattedValue;
            });
        }

        // Format expiry input
        const expiryInput = document.getElementById('cc-expiration');
        if (expiryInput) {
            expiryInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 2) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4);
                }
                e.target.value = value;
            });
        }

        // Dynamic Address Dropdowns
        const countrySelect = document.getElementById('country');
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const postalCodeInput = document.getElementById('postal_code');

        // Load countries on page load
        fetch('/api/addresses/countries')
            .then(response => response.json())
            .then(countries => {
                countries.forEach(country => {
                    const option = document.createElement('option');
                    option.value = country;
                    option.textContent = country;
                    countrySelect.appendChild(option);
                });
            })
            .catch(error => console.error('Error loading countries:', error));

        // Load provinces when country changes
        countrySelect.addEventListener('change', function() {
            const country = this.value;

            // Reset dependent dropdowns
            provinceSelect.innerHTML = '<option value="">Choose province...</option>';
            citySelect.innerHTML = '<option value="">Choose city...</option>';
            postalCodeInput.value = '';

            if (!country) {
                provinceSelect.disabled = true;
                citySelect.disabled = true;
                return;
            }

            provinceSelect.disabled = true;
            citySelect.disabled = true;

            fetch(`/api/addresses/provinces/${encodeURIComponent(country)}`)
                .then(response => response.json())
                .then(provinces => {
                    provinces.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province;
                        option.textContent = province;
                        provinceSelect.appendChild(option);
                    });
                    provinceSelect.disabled = false;
                })
                .catch(error => console.error('Error loading provinces:', error));
        });

        // Load cities when province changes
        provinceSelect.addEventListener('change', function() {
            const country = countrySelect.value;
            const province = this.value;

            // Reset dependent dropdowns
            citySelect.innerHTML = '<option value="">Choose city...</option>';
            postalCodeInput.value = '';

            if (!province) {
                citySelect.disabled = true;
                return;
            }

            citySelect.disabled = true;

            fetch(`/api/addresses/cities/${encodeURIComponent(country)}/${encodeURIComponent(province)}`)
                .then(response => response.json())
                .then(cities => {
                    cities.forEach(cityData => {
                        const option = document.createElement('option');
                        option.value = cityData.city;
                        option.textContent = cityData.city;
                        option.dataset.postalCode = cityData.postal_code;
                        citySelect.appendChild(option);
                    });
                    citySelect.disabled = false;
                })
                .catch(error => console.error('Error loading cities:', error));
        });

        // Auto-fill postal code when city changes
        citySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.dataset.postalCode) {
                postalCodeInput.value = selectedOption.dataset.postalCode;
            } else {
                postalCodeInput.value = '';
            }
        });
    </script>
@endpush
