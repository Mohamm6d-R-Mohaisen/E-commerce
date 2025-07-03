<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $banners = [
            [
                'title' => 'iPhone 12 Pro Max',
                'subtitle' => 'New line required',
                'price' => '$259.99',
                'background_image' => null,
                'link' => '/products',
                'type' => 'small_banner_1',
                'position' => 'left',
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'title' => 'Weekly Sale!',
                'subtitle' => null,
                'price' => null,
                'background_image' => null,
                'link' => '/products',
                'type' => 'small_banner_2',
                'position' => 'right',
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'title' => 'Smart Watch 2.0',
                'subtitle' => null,
                'price' => null,
                'background_image' => null,
                'link' => '/products',
                'type' => 'main_banner',
                'position' => 'left',
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'title' => 'Smart Headphone',
                'subtitle' => null,
                'price' => null,
                'background_image' => null,
                'link' => '/products',
                'type' => 'main_banner',
                'position' => 'right',
                'status' => 'active',
                'sort_order' => 4,
            ],
        ];

        foreach ($banners as $bannerData) {
            Banner::create($bannerData);
        }
    }
}
