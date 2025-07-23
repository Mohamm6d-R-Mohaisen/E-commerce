<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Free Shipping',
                'description' => 'On order over $99',
                'icon' => 'lni lni-delivery',
                'status' => 'active',
                'sort_order' => 1,
            ],
            [
                'name' => '24/7 Support',
                'description' => 'Live Chat Or Call',
                'icon' => 'lni lni-support',
                'status' => 'active',
                'sort_order' => 2,
            ],
            [
                'name' => 'Online Payment',
                'description' => 'Secure Payment Services',
                'icon' => 'lni lni-credit-cards',
                'status' => 'active',
                'sort_order' => 3,
            ],
            [
                'name' => 'Easy Return',
                'description' => 'Hassle Free Shopping',
                'icon' => 'lni lni-reload',
                'status' => 'active',
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
} 