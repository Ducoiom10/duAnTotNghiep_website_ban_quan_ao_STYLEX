<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (!Schema::hasColumn('carts', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            }

            if (!Schema::hasColumn('carts', 'session_id')) {
                $table->string('session_id', 255)->nullable()->index()->after('user_id');
            }

            if (!Schema::hasColumn('carts', 'product_id')) {
                $table->unsignedBigInteger('product_id')->nullable()->after('session_id');
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            }

            if (!Schema::hasColumn('carts', 'variant_id')) {
                $table->unsignedBigInteger('variant_id')->nullable()->after('product_id');
                $table->foreign('variant_id')->references('id')->on('product_variants')->onDelete('set null');
            }

            if (!Schema::hasColumn('carts', 'quantity')) {
                $table->integer('quantity')->default(1)->after('variant_id');
            }

            if (!Schema::hasColumn('carts', 'size')) {
                $table->string('size', 50)->nullable()->after('quantity');
            }

            if (!Schema::hasColumn('carts', 'color')) {
                $table->string('color', 50)->nullable()->after('size');
            }

            // Helpful composite index for lookups
            $table->index(['user_id', 'session_id', 'product_id', 'variant_id'], 'carts_owner_product_variant_index');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (Schema::hasColumn('carts', 'color')) {
                $table->dropColumn('color');
            }
            if (Schema::hasColumn('carts', 'size')) {
                $table->dropColumn('size');
            }
            if (Schema::hasColumn('carts', 'quantity')) {
                $table->dropColumn('quantity');
            }
            if (Schema::hasColumn('carts', 'variant_id')) {
                $table->dropForeign(['variant_id']);
                $table->dropColumn('variant_id');
            }
            if (Schema::hasColumn('carts', 'product_id')) {
                $table->dropForeign(['product_id']);
                $table->dropColumn('product_id');
            }
            if (Schema::hasColumn('carts', 'session_id')) {
                $table->dropIndex('carts_owner_product_variant_index');
                $table->dropColumn('session_id');
            }
            if (Schema::hasColumn('carts', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
        });
    }
};


