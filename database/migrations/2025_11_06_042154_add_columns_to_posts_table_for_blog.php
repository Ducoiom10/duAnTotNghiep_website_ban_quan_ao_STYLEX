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
        Schema::table('posts', function (Blueprint $table) {
            // Đổi author_id thành user_id nếu chưa có user_id
            if (!Schema::hasColumn('posts', 'user_id') && Schema::hasColumn('posts', 'author_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            } elseif (!Schema::hasColumn('posts', 'user_id')) {
                $table->foreignId('user_id')->constrained()->cascadeOnDelete()->after('id');
            }
            
            // Thêm các cột còn thiếu
            if (!Schema::hasColumn('posts', 'category_id')) {
                $table->foreignId('category_id')->nullable()->constrained()->cascadeOnDelete()->after('user_id');
            }
            if (!Schema::hasColumn('posts', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
            if (!Schema::hasColumn('posts', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('content');
            }
            if (!Schema::hasColumn('posts', 'status')) {
                $table->enum('status', ['draft', 'pending', 'published', 'private', 'scheduled'])->default('draft')->after('thumbnail');
            }
            if (!Schema::hasColumn('posts', 'views')) {
                $table->integer('views')->default(0)->after('status');
            }
            if (!Schema::hasColumn('posts', 'is_hot')) {
                $table->boolean('is_hot')->default(false)->after('views');
            }
            if (!Schema::hasColumn('posts', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('is_hot');
            }
            if (!Schema::hasColumn('posts', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            if (Schema::hasColumn('posts', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('posts', 'category_id')) {
                $table->dropForeign(['category_id']);
                $table->dropColumn('category_id');
            }
            $table->dropColumn(['description', 'thumbnail', 'status', 'views', 'is_hot', 'published_at', 'deleted_at']);
        });
    }
};
