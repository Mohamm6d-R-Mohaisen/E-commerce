<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->boolean('featured')->default(false)->after('status');
            $table->json('sub_categories_list')->nullable()->after('featured');
            $table->integer('sort_order')->default(0)->after('sub_categories_list');
            
            // Add index for featured categories
            $table->index(['featured', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex(['featured', 'status']);
            $table->dropColumn(['featured', 'sub_categories_list', 'sort_order']);
        });
    }
};
