<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\About;

class AboutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        About::create([
            'title' => 'About ShopGrids',
            'description' => 'We are a modern e-commerce platform dedicated to providing the best shopping experience for our customers.',
            'content' => 'ShopGrids is your ultimate destination for online shopping, offering a diverse range of high-quality products at competitive prices. Founded with the vision to revolutionize the e-commerce experience, we strive to provide exceptional service, innovative solutions, and unmatched customer satisfaction.

Our mission is to make online shopping simple, secure, and enjoyable for everyone. We believe in the power of technology to connect people with the products they love, and we are committed to delivering excellence in every aspect of our business.

From fashion and electronics to home essentials and lifestyle products, our carefully curated collection ensures that you find exactly what you are looking for. Our team of dedicated professionals works tirelessly to maintain the highest standards of quality, reliability, and customer service.

At ShopGrids, we are not just an e-commerce platform; we are your trusted shopping partner, committed to making your online shopping journey memorable and satisfying.',
            'image' => '/frontend/assets/images/about/about-img.jpg',
            'video_url' => 'https://www.youtube.com/embed/r44RKWyfcFw',
            'is_active' => true
        ]);
    }
}
