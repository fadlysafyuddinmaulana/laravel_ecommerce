@extends('user_page.layouts.app')

@section('title', 'Blog')

@section('content')
    <!-- Start Hero Section -->
    <div class="hero">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-5">
                    <div class="intro-excerpt">
                        <h1>Blog</h1>
                        <p class="mb-4">Stay updated with the latest tips, trends, and ideas for furniture and interior
                            design. Explore our collection of helpful articles.</p>
                        <p>
                            <a href="{{ route('shop') }}" class="btn btn-secondary me-2">Shop Now</a>
                            <a href="{{ route('products') }}" class="btn btn-white-outline">Explore</a>
                        </p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="hero-img-wrap">
                        <img src="{{ asset('assets/furni-1.0.0/images/couch.png') }}" class="img-fluid" alt="Couch">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Hero Section -->

    <!-- Start Blog Section -->
    <div class="blog-section">
        <div class="container">
            <div class="row">
                <!-- Blog Post 1 -->
                <div class="col-12 col-sm-6 col-md-4 mb-5">
                    <div class="post-entry">
                        <a href="#" class="post-thumbnail">
                            <img src="{{ asset('assets/furni-1.0.0/images/post-1.jpg') }}" alt="First Time Home Owner"
                                class="img-fluid">
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="#">First Time Home Owner Ideas</a></h3>
                            <div class="meta">
                                <span>by <a href="#">Kristin Watson</a></span>
                                <span>on <a href="#">Dec 19, 2021</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 2 -->
                <div class="col-12 col-sm-6 col-md-4 mb-5">
                    <div class="post-entry">
                        <a href="#" class="post-thumbnail">
                            <img src="{{ asset('assets/furni-1.0.0/images/post-2.jpg') }}" alt="Furniture Clean"
                                class="img-fluid">
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="#">How To Keep Your Furniture Clean</a></h3>
                            <div class="meta">
                                <span>by <a href="#">Robert Fox</a></span>
                                <span>on <a href="#">Dec 15, 2021</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 3 -->
                <div class="col-12 col-sm-6 col-md-4 mb-5">
                    <div class="post-entry">
                        <a href="#" class="post-thumbnail">
                            <img src="{{ asset('assets/furni-1.0.0/images/post-3.jpg') }}" alt="Small Space Apartment"
                                class="img-fluid">
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="#">Small Space Furniture Apartment Ideas</a></h3>
                            <div class="meta">
                                <span>by <a href="#">Kristin Watson</a></span>
                                <span>on <a href="#">Dec 12, 2021</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 4 -->
                <div class="col-12 col-sm-6 col-md-4 mb-5">
                    <div class="post-entry">
                        <a href="#" class="post-thumbnail">
                            <img src="{{ asset('assets/furni-1.0.0/images/post-1.jpg') }}" alt="Home Interior Design"
                                class="img-fluid">
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="#">Modern Interior Design Trends 2024</a></h3>
                            <div class="meta">
                                <span>by <a href="#">John Doe</a></span>
                                <span>on <a href="#">Jan 5, 2024</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 5 -->
                <div class="col-12 col-sm-6 col-md-4 mb-5">
                    <div class="post-entry">
                        <a href="#" class="post-thumbnail">
                            <img src="{{ asset('assets/furni-1.0.0/images/post-2.jpg') }}" alt="Budget Friendly"
                                class="img-fluid">
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="#">Budget-Friendly Furniture Shopping Tips</a></h3>
                            <div class="meta">
                                <span>by <a href="#">Jane Smith</a></span>
                                <span>on <a href="#">Jan 3, 2024</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 6 -->
                <div class="col-12 col-sm-6 col-md-4 mb-5">
                    <div class="post-entry">
                        <a href="#" class="post-thumbnail">
                            <img src="{{ asset('assets/furni-1.0.0/images/post-3.jpg') }}" alt="Living Room Design"
                                class="img-fluid">
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="#">Creating the Perfect Living Room Layout</a></h3>
                            <div class="meta">
                                <span>by <a href="#">Michael Brown</a></span>
                                <span>on <a href="#">Dec 28, 2023</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 7 -->
                <div class="col-12 col-sm-6 col-md-4 mb-5">
                    <div class="post-entry">
                        <a href="#" class="post-thumbnail">
                            <img src="{{ asset('assets/furni-1.0.0/images/post-1.jpg') }}" alt="Sustainable Furniture"
                                class="img-fluid">
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="#">Sustainable Furniture: Eco-Friendly Choices</a></h3>
                            <div class="meta">
                                <span>by <a href="#">Sarah Wilson</a></span>
                                <span>on <a href="#">Dec 20, 2023</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 8 -->
                <div class="col-12 col-sm-6 col-md-4 mb-5">
                    <div class="post-entry">
                        <a href="#" class="post-thumbnail">
                            <img src="{{ asset('assets/furni-1.0.0/images/post-2.jpg') }}" alt="Office Setup"
                                class="img-fluid">
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="#">Home Office Setup Guide for Productivity</a></h3>
                            <div class="meta">
                                <span>by <a href="#">David Lee</a></span>
                                <span>on <a href="#">Dec 18, 2023</a></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Blog Post 9 -->
                <div class="col-12 col-sm-6 col-md-4 mb-5">
                    <div class="post-entry">
                        <a href="#" class="post-thumbnail">
                            <img src="{{ asset('assets/furni-1.0.0/images/post-3.jpg') }}" alt="Color Psychology"
                                class="img-fluid">
                        </a>
                        <div class="post-content-entry">
                            <h3><a href="#">The Psychology of Color in Home Decor</a></h3>
                            <div class="meta">
                                <span>by <a href="#">Emma Davis</a></span>
                                <span>on <a href="#">Dec 10, 2023</a></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Section -->

    <!-- Start Testimonial Section -->
    <div class="testimonial-section before-footer-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto text-center">
                    <h2 class="section-title">Join Our Newsletter</h2>
                    <p class="mb-4">Get the latest furniture tips, exclusive deals, and design inspiration delivered to
                        your
                        inbox.</p>
                    <form action="#" class="row g-3">
                        <div class="col-auto">
                            <input type="email" class="form-control" placeholder="Enter your email">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">
                                <span class="fa fa-paper-plane"></span> Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Testimonial Section -->
@endsection
</div>
</div>
</div>
</div>

<div class="col-12 col-sm-6 col-md-4 mb-5">
    <div class="post-entry">
        <a href="#" class="post-thumbnail"><img src="{{ asset('assets/furni-1.0.0/images/post-1.jpg') }}"
                alt="Image" class="img-fluid"></a>
        <div class="post-content-entry">
            <h3><a href="#">First Time Home Owner Ideas</a></h3>
            <div class="meta">
                <span>by <a href="#">Kristin Watson</a></span> <span>on <a href="#">Dec 19,
                        2021</a></span>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-sm-6 col-md-4 mb-5">
    <div class="post-entry">
        <a href="#" class="post-thumbnail"><img src="{{ asset('assets/furni-1.0.0/images/post-2.jpg') }}"
                alt="Image" class="img-fluid"></a>
        <div class="post-content-entry">
            <h3><a href="#">How To Keep Your Furniture Clean</a></h3>
            <div class="meta">
                <span>by <a href="#">Robert Fox</a></span> <span>on <a href="#">Dec 15,
                        2021</a></span>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-sm-6 col-md-4 mb-5">
    <div class="post-entry">
        <a href="#" class="post-thumbnail"><img src="{{ asset('assets/furni-1.0.0/images/post-3.jpg') }}"
                alt="Image" class="img-fluid"></a>
        <div class="post-content-entry">
            <h3><a href="#">Small Space Furniture Apartment Ideas</a></h3>
            <div class="meta">
                <span>by <a href="#">Kristin Watson</a></span> <span>on <a href="#">Dec 12,
                        2021</a></span>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-sm-6 col-md-4 mb-5">
    <div class="post-entry">
        <a href="#" class="post-thumbnail"><img src="{{ asset('assets/furni-1.0.0/images/post-1.jpg') }}"
                alt="Image" class="img-fluid"></a>
        <div class="post-content-entry">
            <h3><a href="#">First Time Home Owner Ideas</a></h3>
            <div class="meta">
                <span>by <a href="#">Kristin Watson</a></span> <span>on <a href="#">Dec 19,
                        2021</a></span>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-sm-6 col-md-4 mb-5">
    <div class="post-entry">
        <a href="#" class="post-thumbnail"><img src="{{ asset('assets/furni-1.0.0/images/post-2.jpg') }}"
                alt="Image" class="img-fluid"></a>
        <div class="post-content-entry">
            <h3><a href="#">How To Keep Your Furniture Clean</a></h3>
            <div class="meta">
                <span>by <a href="#">Robert Fox</a></span> <span>on <a href="#">Dec 15,
                        2021</a></span>
            </div>
        </div>
    </div>
</div>

<div class="col-12 col-sm-6 col-md-4 mb-5">
    <div class="post-entry">
        <a href="#" class="post-thumbnail"><img src="{{ asset('assets/furni-1.0.0/images/post-3.jpg') }}"
                alt="Image" class="img-fluid"></a>
        <div class="post-content-entry">
            <h3><a href="#">Small Space Furniture Apartment Ideas</a></h3>
            <div class="meta">
                <span>by <a href="#">Kristin Watson</a></span> <span>on <a href="#">Dec 12,
                        2021</a></span>
            </div>
        </div>
    </div>
</div>

</div>
</div>
</div>
<!-- End Blog Section -->



<!-- Start Testimonial Slider -->
<div class="testimonial-section before-footer-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto text-center">
                <h2 class="section-title">Testimonials</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="testimonial-slider-wrap text-center">

                    <div id="testimonial-nav">
                        <span class="prev" data-controls="prev"><span class="fa fa-chevron-left"></span></span>
                        <span class="next" data-controls="next"><span class="fa fa-chevron-right"></span></span>
                    </div>

                    <div class="testimonial-slider">

                        <div class="item">
                            <div class="row justify-content-center">
                                <div class="col-lg-8 mx-auto">

                                    <div class="testimonial-block text-center">
                                        <blockquote class="mb-5">
                                            <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
                                                quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                                                velit imperdiet dolor tempor tristique. Pellentesque habitant morbi
                                                tristique senectus et netus et malesuada fames ac turpis egestas.
                                                Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
                                        </blockquote>

                                        <div class="author-info">
                                            <div class="author-pic">
                                                <img src="{{ asset('assets/furni-1.0.0/images/person-1.png') }}"
                                                    alt="Maria Jones" class="img-fluid">
                                            </div>
                                            <h3 class="font-weight-bold">Maria Jones</h3>
                                            <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endsection
                    <!-- END item -->

                    <div class="item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 mx-auto">

                                <div class="testimonial-block text-center">
                                    <blockquote class="mb-5">
                                        <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
                                            quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                                            velit imperdiet dolor tempor tristique. Pellentesque habitant morbi
                                            tristique senectus et netus et malesuada fames ac turpis egestas.
                                            Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
                                    </blockquote>

                                    <div class="author-info">
                                        <div class="author-pic">
                                            <img src="{{ asset('assets/furni-1.0.0/images/person-1.png') }}"
                                                alt="Maria Jones" class="img-fluid">
                                        </div>
                                        <h3 class="font-weight-bold">Maria Jones</h3>
                                        <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- END item -->

                    <div class="item">
                        <div class="row justify-content-center">
                            <div class="col-lg-8 mx-auto">

                                <div class="testimonial-block text-center">
                                    <blockquote class="mb-5">
                                        <p>&ldquo;Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio
                                            quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                                            velit imperdiet dolor tempor tristique. Pellentesque habitant morbi
                                            tristique senectus et netus et malesuada fames ac turpis egestas.
                                            Integer convallis volutpat dui quis scelerisque.&rdquo;</p>
                                    </blockquote>

                                    <div class="author-info">
                                        <div class="author-pic">
                                            <img src="{{ asset('assets/furni-1.0.0/images/person-1.png') }}"
                                                alt="Maria Jones" class="img-fluid">
                                        </div>
                                        <h3 class="font-weight-bold">Maria Jones</h3>
                                        <span class="position d-block mb-3">CEO, Co-Founder, XYZ Inc.</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- END item -->

                </div>

            </div>
        </div>
    </div>
</div>
</div>
<!-- End Testimonial Slider -->
