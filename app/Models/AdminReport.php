<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminReport extends Model
{
    use HasFactory;

    protected $table = 'admin_reports';

    // Các trường được phép gán dữ liệu hàng loạt (Mass Assignment)
    protected $fillable = [
        'user_id',
        'report_date',
        'total_salary_paid',
        'total_commission',
        'orders_processed_count',
        'inventory_transactions_count',
    ];

    // Ép kiểu dữ liệu (Casting)
    protected $casts = [
        'report_date' => 'date',
        // total_salary_paid và total_commission có kiểu decimal(10, 2)
        'total_salary_paid' => 'decimal:2',
        'total_commission' => 'decimal:2',
        'orders_processed_count' => 'integer',
        'inventory_transactions_count' => 'integer',
    ];

    // --- Quan hệ ---

    /**
     * Lấy người dùng (Admin/Nhân viên) đã tạo/lập báo cáo này.
     */
    public function user(): BelongsTo
    {
        // Liên kết với bảng users thông qua user_id
        return $this->belongsTo(User::class, 'user_id');
    }
}
