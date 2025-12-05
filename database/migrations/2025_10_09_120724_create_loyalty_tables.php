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
        // 1. Bảng loyalty_tiers: Định nghĩa các cấp bậc thành viên
        Schema::create('loyalty_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50)->unique();
            // Cần chi tiêu tối thiểu để đạt cấp bậc
            $table->decimal('min_spend_required', 10, 2)->default(0);
            // Tỷ lệ chiết khấu (ví dụ: 0.05 là 5%)
            $table->decimal('discount_rate', 4, 2)->default(0)->comment('Ưu đãi theo %');
            $table->timestamps();
        });

        // 2. Bảng user_loyalty: Theo dõi cấp bậc hiện tại và tổng chi tiêu của người dùng
        Schema::create('user_loyalty', function (Blueprint $table) {
            $table->id();

            // Liên kết với bảng users
            $table->foreignId('user_id')
                  ->constrained() // Khóa ngoại tới bảng 'users'
                  ->onDelete('cascade') // Nếu user bị xóa, record này cũng bị xóa
                  ->unique(); // Đảm bảo mỗi user chỉ có MỘT record này

            // Liên kết với bảng loyalty_tiers
            $table->foreignId('loyalty_tier_id')
                  ->constrained('loyalty_tiers') // Khóa ngoại tới bảng 'loyalty_tiers'
                  ->onDelete('restrict'); // Ngăn việc xóa một tier nếu có người dùng thuộc tier đó

            // Tổng chi tiêu thực tế của người dùng
            $table->decimal('total_spent', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Phải xóa bảng có khóa ngoại trước (user_loyalty)
        Schema::dropIfExists('user_loyalty');
        Schema::dropIfExists('loyalty_tiers');
    }
};
