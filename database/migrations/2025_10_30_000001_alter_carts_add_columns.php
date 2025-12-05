<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (!Schema::hasColumn('carts', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('carts', 'session_id')) {
                $table->string('session_id', 255)->nullable()->after('user_id')->index();
            }
            if (!Schema::hasColumn('carts', 'product_id')) {
                $table->unsignedBigInteger('product_id')->after('session_id');
            }
            if (!Schema::hasColumn('carts', 'variant_id')) {
                $table->unsignedBigInteger('variant_id')->nullable()->after('product_id');
            }
            if (!Schema::hasColumn('carts', 'quantity')) {
                $table->integer('quantity')->default(1)->after('variant_id');
            }

            // Indexes are assumed to exist from prior migrations; skip creating to avoid duplicates
        });

        // Skip adding foreign keys here to avoid duplicate constraint names if an earlier migration added them
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Drop indexes
            try { $table->dropIndex(['user_id']); } catch (\Throwable $e) {}
            try { $table->dropIndex(['product_id']); } catch (\Throwable $e) {}
            try { $table->dropIndex(['variant_id']); } catch (\Throwable $e) {}

            // Drop columns
            if (Schema::hasColumn('carts', 'quantity')) { $table->dropColumn('quantity'); }
            if (Schema::hasColumn('carts', 'variant_id')) { $table->dropColumn('variant_id'); }
            if (Schema::hasColumn('carts', 'product_id')) { $table->dropColumn('product_id'); }
            if (Schema::hasColumn('carts', 'session_id')) { $table->dropColumn('session_id'); }
            if (Schema::hasColumn('carts', 'user_id')) { $table->dropColumn('user_id'); }
        });
    }
};


