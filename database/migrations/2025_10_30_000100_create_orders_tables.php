<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('session_id')->nullable()->index();
            $table->string('code', 32)->unique();

            // Customer info snapshot
            $table->string('full_name');
            $table->string('phone', 30);
            $table->string('email')->nullable();
            $table->string('city');
            $table->string('address', 500);
            $table->text('note')->nullable();

            // Money
            $table->unsignedBigInteger('subtotal')->default(0); // in VND
            $table->unsignedBigInteger('shipping_fee')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->unsignedBigInteger('total')->default(0);

            // Payment
            $table->enum('payment_method', ['cod','online'])->default('cod');
            $table->enum('payment_status', ['unpaid','paid','refunded'])->default('unpaid');
            $table->enum('status', ['pending','processing','completed','cancelled'])->default('pending');

            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variant_id')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->unsignedBigInteger('price'); // unit price at time of order (VND)
            $table->unsignedBigInteger('line_total');
            $table->timestamps();

            $table->index(['order_id']);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};


