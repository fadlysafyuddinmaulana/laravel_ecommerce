@extends('user_page.layouts.app')

@section('title', 'About')

@section('content')
    <!-- Why Choose Us Section (Responsive Tailwind) -->
    <section class="py-10 md:py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-8">
                <div class="w-full md:w-1/2">
                    <h2 class="text-2xl md:text-4xl font-bold mb-4 text-gray-800">Why Choose Us</h2>
                    <p class="text-base md:text-lg text-gray-600 mb-6">Donec vitae odio quis nisl dapibus malesuada. Nullam
                        ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique.</p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center">
                            <img src="images/truck.svg" alt="Fast & Free Shipping" class="w-12 h-12 mb-2">
                            <h3 class="font-semibold text-lg mb-1">Fast &amp; Free Shipping</h3>
                            <p class="text-sm text-gray-500">Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet
                                velit. Aliquam vulputate.</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center">
                            <img src="images/bag.svg" alt="Easy to Shop" class="w-12 h-12 mb-2">
                            <h3 class="font-semibold text-lg mb-1">Easy to Shop</h3>
                            <p class="text-sm text-gray-500">Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet
                                velit. Aliquam vulputate.</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center">
                            <img src="images/support.svg" alt="24/7 Support" class="w-12 h-12 mb-2">
                            <h3 class="font-semibold text-lg mb-1">24/7 Support</h3>
                            <p class="text-sm text-gray-500">Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet
                                velit. Aliquam vulputate.</p>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4 flex flex-col items-center text-center">
                            <img src="images/return.svg" alt="Hassle Free Returns" class="w-12 h-12 mb-2">
                            <h3 class="font-semibold text-lg mb-1">Hassle Free Returns</h3>
                            <p class="text-sm text-gray-500">Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet
                                velit. Aliquam vulputate.</p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-2/5 flex justify-center md:justify-end">
                    <img src="images/why-choose-us-img.jpg" alt="Why Choose Us"
                        class="rounded-lg shadow-lg w-full max-w-xs md:max-w-md object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section (Responsive Tailwind) -->
    <section class="py-10 md:py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="mb-8 text-center">
                <h2 class="text-2xl md:text-4xl font-bold text-gray-800">Our Team</h2>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <div class="flex flex-col items-center bg-white rounded-lg shadow p-6">
                    <img src="images/person_1.jpg" class="w-24 h-24 rounded-full mb-4 object-cover">
                    <h3 class="font-semibold text-lg mb-1"><a href="#"><span>Lawson</span> Arnold</a></h3>
                    <span class="text-sm text-gray-500 mb-2">CEO, Founder, Atty.</span>
                    <p class="text-sm text-gray-600 mb-2 text-center">Separated they live in Bookmarksgrove right at the
                        coast of the Semantics, a large language ocean.</p>
                    <a href="#" class="text-blue-600 hover:underline text-sm">Learn More</a>
                </div>
                <div class="flex flex-col items-center bg-white rounded-lg shadow p-6">
                    <img src="images/person_2.jpg" class="w-24 h-24 rounded-full mb-4 object-cover">
                    <h3 class="font-semibold text-lg mb-1"><a href="#"><span>Jeremy</span> Walker</a></h3>
                    <span class="text-sm text-gray-500 mb-2">CEO, Founder, Atty.</span>
                    <p class="text-sm text-gray-600 mb-2 text-center">Separated they live in Bookmarksgrove right at the
                        coast of the Semantics, a large language ocean.</p>
                    <a href="#" class="text-blue-600 hover:underline text-sm">Learn More</a>
                </div>
                <div class="flex flex-col items-center bg-white rounded-lg shadow p-6">
                    <img src="images/person_3.jpg" class="w-24 h-24 rounded-full mb-4 object-cover">
                    <h3 class="font-semibold text-lg mb-1"><a href="#"><span>Patrik</span> White</a></h3>
                    <span class="text-sm text-gray-500 mb-2">CEO, Founder, Atty.</span>
                    <p class="text-sm text-gray-600 mb-2 text-center">Separated they live in Bookmarksgrove right at the
                        coast of the Semantics, a large language ocean.</p>
                    <a href="#" class="text-blue-600 hover:underline text-sm">Learn More</a>
                </div>
                <div class="flex flex-col items-center bg-white rounded-lg shadow p-6">
                    <img src="images/person_4.jpg" class="w-24 h-24 rounded-full mb-4 object-cover">
                    <h3 class="font-semibold text-lg mb-1"><a href="#"><span>Kathryn</span> Ryan</a></h3>
                    <span class="text-sm text-gray-500 mb-2">CEO, Founder, Atty.</span>
                    <p class="text-sm text-gray-600 mb-2 text-center">Separated they live in Bookmarksgrove right at the
                        coast of the Semantics, a large language ocean.</p>
                    <a href="#" class="text-blue-600 hover:underline text-sm">Learn More</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section (Responsive Tailwind) -->
    <section class="py-10 md:py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="mb-8 text-center">
                <h2 class="text-2xl md:text-4xl font-bold text-gray-800">Testimonials</h2>
            </div>
            <div class="flex flex-col gap-8 items-center">
                <div class="w-full md:w-2/3 bg-gray-50 rounded-lg shadow p-6">
                    <blockquote class="mb-4 text-gray-700 text-base md:text-lg">&ldquo;Donec facilisis quam ut purus rutrum
                        lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                        velit imperdiet dolor tempor tristique. Pellentesque habitant morbi tristique senectus et netus et
                        malesuada fames ac turpis egestas. Integer convallis volutpat dui quis scelerisque.&rdquo;
                    </blockquote>
                    <div class="flex flex-col items-center">
                        <img src="images/person-1.png" alt="Maria Jones" class="w-16 h-16 rounded-full mb-2 object-cover">
                        <h3 class="font-bold text-lg">Maria Jones</h3>
                        <span class="text-sm text-gray-500 mb-2">CEO, Co-Founder, XYZ Inc.</span>
                    </div>
                </div>
                <div class="w-full md:w-2/3 bg-gray-50 rounded-lg shadow p-6">
                    <blockquote class="mb-4 text-gray-700 text-base md:text-lg">&ldquo;Donec facilisis quam ut purus rutrum
                        lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                        velit imperdiet dolor tempor tristique. Pellentesque habitant morbi tristique senectus et netus et
                        malesuada fames ac turpis egestas. Integer convallis volutpat dui quis scelerisque.&rdquo;
                    </blockquote>
                    <div class="flex flex-col items-center">
                        <img src="images/person-1.png" alt="Maria Jones" class="w-16 h-16 rounded-full mb-2 object-cover">
                        <h3 class="font-bold text-lg">Maria Jones</h3>
                        <span class="text-sm text-gray-500 mb-2">CEO, Co-Founder, XYZ Inc.</span>
                    </div>
                </div>
                <div class="w-full md:w-2/3 bg-gray-50 rounded-lg shadow p-6">
                    <blockquote class="mb-4 text-gray-700 text-base md:text-lg">&ldquo;Donec facilisis quam ut purus rutrum
                        lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate
                        velit imperdiet dolor tempor tristique. Pellentesque habitant morbi tristique senectus et netus et
                        malesuada fames ac turpis egestas. Integer convallis volutpat dui quis scelerisque.&rdquo;
                    </blockquote>
                    <div class="flex flex-col items-center">
                        <img src="images/person-1.png" alt="Maria Jones"
                            class="w-16 h-16 rounded-full mb-2 object-cover">
                        <h3 class="font-bold text-lg">Maria Jones</h3>
                        <span class="text-sm text-gray-500 mb-2">CEO, Co-Founder, XYZ Inc.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- Start Why Choose Us Section -->
<div class="why-choose-section">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title">Why Choose Us</h2>
                <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit
                    imperdiet dolor tempor tristique.</p>

                <div class="row my-5">
                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/truck.svg" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Fast &amp; Free Shipping</h3>
                            <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.
                            </p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/bag.svg" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Easy to Shop</h3>
                            <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.
                            </p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/support.svg" alt="Image" class="imf-fluid">
                            </div>
                            <h3>24/7 Support</h3>
                            <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.
                            </p>
                        </div>
                    </div>

                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <img src="images/return.svg" alt="Image" class="imf-fluid">
                            </div>
                            <h3>Hassle Free Returns</h3>
                            <p>Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-5">
                <div class="img-wrap">
                    <img src="images/why-choose-us-img.jpg" alt="Image" class="img-fluid">
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Why Choose Us Section -->

<!-- Start Team Section -->
<div class="untree_co-section">
    <div class="container">

        <div class="row mb-5">
            <div class="col-lg-5 mx-auto text-center">
                <h2 class="section-title">Our Team</h2>
            </div>
        </div>

        <div class="row">

            <!-- Start Column 1 -->
            <div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
                <img src="images/person_1.jpg" class="img-fluid mb-5">
                <h3 clas><a href="#"><span class="">Lawson</span> Arnold</a></h3>
                <span class="d-block position mb-4">CEO, Founder, Atty.</span>
                <p>Separated they live in.
                    Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.
                </p>
                <p class="mb-0"><a href="#" class="more dark">Learn More <span
                            class="icon-arrow_forward"></span></a></p>
            </div>
            <!-- End Column 1 -->

            <!-- Start Column 2 -->
            <div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
                <img src="images/person_2.jpg" class="img-fluid mb-5">

                <h3 clas><a href="#"><span class="">Jeremy</span> Walker</a></h3>
                <span class="d-block position mb-4">CEO, Founder, Atty.</span>
                <p>Separated they live in.
                    Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.
                </p>
                <p class="mb-0"><a href="#" class="more dark">Learn More <span
                            class="icon-arrow_forward"></span></a></p>

            </div>
            <!-- End Column 2 -->

            <!-- Start Column 3 -->
            <div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
                <img src="images/person_3.jpg" class="img-fluid mb-5">
                <h3 clas><a href="#"><span class="">Patrik</span> White</a></h3>
                <span class="d-block position mb-4">CEO, Founder, Atty.</span>
                <p>Separated they live in.
                    Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.
                </p>
                <p class="mb-0"><a href="#" class="more dark">Learn More <span
                            class="icon-arrow_forward"></span></a></p>
            </div>
            <!-- End Column 3 -->

            <!-- Start Column 4 -->
            <div class="col-12 col-md-6 col-lg-3 mb-5 mb-md-0">
                <img src="images/person_4.jpg" class="img-fluid mb-5">

                <h3 clas><a href="#"><span class="">Kathryn</span> Ryan</a></h3>
                <span class="d-block position mb-4">CEO, Founder, Atty.</span>
                <p>Separated they live in.
                    Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.
                </p>
                <p class="mb-0"><a href="#" class="more dark">Learn More <span
                            class="icon-arrow_forward"></span></a></p>


            </div>
            <!-- End Column 4 -->



        </div>
    </div>
</div>
<!-- End Team Section -->



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
                                                <img src="images/person-1.png" alt="Maria Jones" class="img-fluid">
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
                                                <img src="images/person-1.png" alt="Maria Jones" class="img-fluid">
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
                                                <img src="images/person-1.png" alt="Maria Jones" class="img-fluid">
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
