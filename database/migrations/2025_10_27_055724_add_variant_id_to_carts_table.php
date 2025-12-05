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
        Schema::table('carts', function (Blueprint $table) {
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('cascade');
            
            // Drop unique constraint cũ
            $table->dropUnique('unique_cart_item');
            
            // Tạo unique constraint mới với variant_id
            $table->unique(['user_id', 'variant_id'], 'unique_cart_variant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['variant_id']);
            $table->dropColumn('variant_id');
            
            // Khôi phục unique constraint cũ
            $table->dropUnique('unique_cart_variant');
            $table->unique(['user_id', 'product_id', 'size', 'color'], 'unique_cart_item');
        });
    }
};
