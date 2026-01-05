<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'name' => 'Maria Jones',
                'position' => 'CEO, Co-Founder',
                'company' => 'XYZ Inc.',
                'content' => 'Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
                'image' => null,
                'is_active' => true,
                'display_order' => 1,
            ],
            [
                'name' => 'John Smith',
                'position' => 'Marketing Director',
                'company' => 'ABC Company',
                'content' => 'Amazing products and excellent customer service! The quality exceeded my expectations. I highly recommend this store to anyone looking for premium furniture.',
                'image' => null,
                'is_active' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Sarah Williams',
                'position' => 'Interior Designer',
                'company' => 'Design Studio',
                'content' => 'I\'ve purchased multiple items for my clients and every piece has been perfect. The craftsmanship is outstanding and delivery was prompt.',
                'image' => null,
                'is_active' => true,
                'display_order' => 3,
            ],
            [
                'name' => 'David Brown',
                'position' => 'Home Owner',
                'company' => null,
                'content' => 'Great selection and competitive prices. The furniture transformed my living space completely. Will definitely shop here again!',
                'image' => null,
                'is_active' => false, // Not active, won't be displayed
                'display_order' => 4,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
