<?php

use App\Models\Color;
use App\Models\Product;
use App\Models\Size;
use App\Models\Texture;
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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Color::class)->constrained();
            $table->foreignIdFor(Size::class)->constrained();
            $table->foreignIdFor(Texture::class)->constrained();
            $table->string('sku', 255)->unique();
            $table->string('image', 255)->nullable();
            $table->decimal('price', 20, 0)->default(0);
            $table->bigInteger('quantity')->default(0);

            $table->tinyInteger('status')->default(1);  // 1: active, 0: inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
