@extends('user_page.layouts.app')

@section('title', 'Services')

@push('styles')
    <style>
        /* Hero Section */
        .services-hero {
            background: linear-gradient(135deg, #3b5d50 0%, #2d4940 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .services-hero h1 {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .services-hero p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Services Grid */
        .services-section {
            padding: 80px 0;
        }

        .service-card {
            background: white;
            border-radius: 12px;
            padding: 40px 30px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            height: 100%;
            border: 2px solid transparent;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(59, 93, 80, 0.15);
            border-color: #3b5d50;
        }

        .service-card .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 25px;
            background: #f9f9f9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .service-card .icon img {
            width: 40px;
            height: 40px;
        }

        .service-card h3 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 15px;
            color: #2f2f2f;
        }

        .service-card p {
            font-size: 1rem;
            color: #6c757d;
            line-height: 1.7;
            margin-bottom: 0;
        }

        /* Why Choose Us Section */
        .why-choose-section {
            background: #f8f9fa;
            padding: 80px 0;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #2f2f2f;
            margin-bottom: 15px;
        }

        .section-title p {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 700px;
            margin: 0 auto;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 30px;
        }

        .benefit-item .icon {
            width: 60px;
            height: 60px;
            background: #3b5d50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 20px;
        }

        .benefit-item .icon i {
            font-size: 24px;
            color: white;
        }

        .benefit-item .content h4 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2f2f2f;
            margin-bottom: 8px;
        }

        .benefit-item .content p {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 0;
            line-height: 1.7;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #3b5d50 0%, #2d4940 100%);
            padding: 80px 0;
            color: white;
            text-align: center;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .cta-section p {
            font-size: 1.2rem;
            opacity: 0.9;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-cta {
            padding: 15px 40px;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .btn-cta-primary {
            background: white;
            color: #3b5d50;
            border: 2px solid white;
        }

        .btn-cta-primary:hover {
            background: transparent;
            color: white;
        }

        .btn-cta-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .btn-cta-secondary:hover {
            background: white;
            color: #3b5d50;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .services-hero h1 {
                font-size: 2rem;
            }

            .services-hero p,
            .section-title p,
            .cta-section p {
                font-size: 1rem;
            }

            .section-title h2,
            .cta-section h2 {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="services-hero">
        <div class="container">
            <h1>Our Services</h1>
            <p>We provide comprehensive furniture solutions tailored to your needs. From fast shipping to professional
                support, we're here to make your shopping experience exceptional.</p>
        </div>
    </div>

    <!-- Services Grid -->
    <div class="services-section">
        <div class="container">
            <div class="section-title">
                <h2>What We Offer</h2>
                <p>Explore our range of services designed to provide you with the best furniture shopping experience</p>
            </div>

            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="icon">
                            <img src="{{ asset('assets/furni-1.0.0/images/truck.svg') }}" alt="Shipping">
                        </div>
                        <h3>Fast & Free Shipping</h3>
                        <p>Get your orders delivered quickly with our free shipping service on all purchases above $50.</p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="icon">
                            <img src="{{ asset('assets/furni-1.0.0/images/bag.svg') }}" alt="Shopping">
                        </div>
                        <h3>Easy to Shop</h3>
                        <p>Browse through our user-friendly website and find the perfect furniture for your space with ease.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="icon">
                            <img src="{{ asset('assets/furni-1.0.0/images/support.svg') }}" alt="Support">
                        </div>
                        <h3>24/7 Support</h3>
                        <p>Our dedicated customer service team is available round the clock to assist you with any
                            inquiries.
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="service-card">
                        <div class="icon">
                            <img src="{{ asset('assets/furni-1.0.0/images/return.svg') }}" alt="Returns">
                        </div>
                        <h3>Hassle Free Returns</h3>
                        <p>Not satisfied? Return your purchase within 30 days for a full refund, no questions asked.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="why-choose-section">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Us</h2>
                <p>We stand out from the competition with our commitment to quality, service, and customer satisfaction</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-6 mb-4">
                    <div class="benefit-item">
                        <div class="icon">
                            <i class="fas fa-certificate"></i>
                        </div>
                        <div class="content">
                            <h4>Premium Quality</h4>
                            <p>All our furniture pieces are crafted from high-quality materials ensuring durability and
                                longevity.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="icon">
                            <i class="fas fa-paint-brush"></i>
                        </div>
                        <div class="content">
                            <h4>Custom Designs</h4>
                            <p>We offer customization options to match your unique style and space requirements perfectly.
                            </p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="content">
                            <h4>Competitive Pricing</h4>
                            <p>Get the best value for your money with our competitive prices and special seasonal discounts.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 col-md-6 mb-4">
                    <div class="benefit-item">
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="content">
                            <h4>Expert Team</h4>
                            <p>Our experienced team provides professional advice to help you make the right furniture
                                choices.
                            </p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="content">
                            <h4>Warranty Protection</h4>
                            <p>Every purchase comes with comprehensive warranty coverage for your peace of mind.</p>
                        </div>
                    </div>

                    <div class="benefit-item">
                        <div class="icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <div class="content">
                            <h4>Eco-Friendly</h4>
                            <p>We're committed to sustainability, using environmentally responsible materials and practices.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
        <div class="container">
            <h2>Ready to Get Started?</h2>
            <p>Contact our team today to discuss your furniture needs and get a personalized quote tailored to your
                requirements.</p>
            <div class="cta-buttons">
                <a href="{{ route('contact') }}" class="btn-cta btn-cta-primary">
                    <i class="fas fa-phone-alt mr-2"></i>Hubungi Kami
                </a>
                <a href="{{ route('contact') }}" class="btn-cta btn-cta-secondary">
                    <i class="fas fa-file-invoice mr-2"></i>Request Penawaran
                </a>
            </div>
        </div>
    </div>
@endsection
