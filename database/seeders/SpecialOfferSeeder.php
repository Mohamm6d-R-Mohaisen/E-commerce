<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\SpecialOffer;
use Illuminate\Database\Seeder;

class SpecialOfferSeeder extends Seeder
{
    public function run(): void
    {
        // Get some active products
        $products = Product::where('status', 'active')->take(3)->get();

        foreach ($products as $product) {
            SpecialOffer::create([
                'product_id' => $product->id,
                'start_date' => now(),
                'end_date' => now()->addDays(7),
                'status' => 'active'
            ]);
        }
    }
} 