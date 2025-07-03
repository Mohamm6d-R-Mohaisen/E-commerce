<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            
            // Product Colors (JSON array of color objects)
            $table->json('colors')->nullable(); // [{name: "Red", value: "#ff0000", available: true}]
            
            // Product Variants (JSON array for size, battery, memory, etc.)
            $table->json('variants')->nullable(); // [{"type": "battery", "options": ["5100 mAh", "6200 mAh"]}]
            
            // Product Features (JSON array of strings)
            $table->json('features')->nullable(); // ["Capture 4K30 Video", "Game-Style Controller"]
            
            // Product Specifications (JSON key-value pairs)
            $table->json('specifications')->nullable(); // {"weight": "35.5oz", "speed": "35 mph"}
            
            // Shipping Options (JSON array)
            $table->json('shipping_options')->nullable(); // [{"name": "Courier", "time": "2-4 days", "price": 22.50}]
            
            // Additional Images (JSON array of image paths)
            $table->json('gallery_images')->nullable(); // ["image1.jpg", "image2.jpg"]
            
            // Product Videos (JSON array)
            $table->json('videos')->nullable(); // [{"title": "Demo", "url": "video.mp4"}]
            
            // Product Meta Data
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            
            // Additional Product Info
            $table->text('long_description')->nullable(); // For detailed description
            $table->json('dimensions')->nullable(); // {"length": 10, "width": 5, "height": 3, "unit": "cm"}
            $table->decimal('weight', 8, 2)->nullable(); // Product weight
            $table->string('weight_unit', 10)->default('kg'); // kg, g, lb, oz
            $table->string('sku')->nullable(); // Stock Keeping Unit
            $table->string('barcode')->nullable(); // Product barcode
            
            // Warranty and Support
            $table->string('warranty_period')->nullable(); // "1 year", "6 months"
            $table->text('warranty_details')->nullable();
            $table->json('support_documents')->nullable(); // [{"name": "Manual", "url": "manual.pdf"}]
            
            $table->timestamps();
            
            // Indexes
            $table->index(['product_id']);
            $table->unique(['product_id']); // One detail record per product
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_details');
    }
};
