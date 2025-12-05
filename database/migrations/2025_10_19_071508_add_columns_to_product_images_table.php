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
        // Schema::table('product_images', function (Blueprint $table) {
        //     if (!Schema::hasColumn('product_images', 'product_id')) {
        //         $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        //     }
        //     if (!Schema::hasColumn('product_images', 'image_path')) {
        //         $table->string('image_path');
        //     }
        //     if (!Schema::hasColumn('product_images', 'alt_text')) {
        //         $table->string('alt_text')->nullable();
        //     }
        //     if (!Schema::hasColumn('product_images', 'sort_order')) {
        //         $table->integer('sort_order')->default(0);
        //     }
        //     if (!Schema::hasColumn('product_images', 'is_primary')) {
        //         $table->boolean('is_primary')->default(false);
        //     }
        // });
    }

    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn(['product_id', 'image_path', 'alt_text', 'sort_order', 'is_primary']);
        });
    }
};
