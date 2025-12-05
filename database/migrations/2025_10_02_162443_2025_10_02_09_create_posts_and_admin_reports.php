<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up()
    {
        // 1. Blog / Nội dung
        // Schema::create('posts', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('title', 255);
        //     $table->string('slug', 255)->unique();
        //     $table->text('content');
        //     $table->unsignedBigInteger('author_id'); // Tạm thời không có FK
        //     $table->timestamps();
        // });
        // 2. Báo cáo Quản trị
        Schema::create('admin_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Tạm thời không có FK
            $table->date('report_date')->comment('Ngày báo cáo, thường là ngày cuối tháng');
            $table->decimal('total_salary_paid', 10, 2);
            $table->decimal('total_commission', 10, 2)->default(0);
            $table->integer('orders_processed_count')->default(0);
            $table->integer('inventory_transactions_count')->default(0);
            $table->unique(['user_id', 'report_date']);
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('admin_reports');
        // Schema::dropIfExists('posts');
    }
};