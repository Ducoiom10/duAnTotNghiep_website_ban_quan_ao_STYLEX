<?php

use App\Models\Category;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class)->constrained();
            $table->string('name', 255)->unique();
            $table->string('slug', 255)->unique();
            $table->string('thumbnail', 255)->nullable();
            $table->tinyInteger('is_active')->default(1)->comment('0 : Ngừng , 1 : Hoạt động');
            $table->text('description')->nullable();
            $table->tinyInteger('is_featured')->default(0);
            $table->string('meta_title')->nullable();
            $table->decimal('price', 20, 0)->default(0);
            $table->decimal('price_sale', 20, 0)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
