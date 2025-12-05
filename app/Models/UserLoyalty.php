<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLoyalty extends Model
{
    // Định nghĩa tên bảng vì nó không theo quy tắc số nhiều mặc định (users_loyalties)
    protected $table = 'user_loyalty';

    protected $fillable = [
        'user_id',
        'loyalty_tier_id',
        'total_spent'
    ];

    //---------------------------------------------------------
    // QUAN HỆ
    //---------------------------------------------------------

    /**
     * Lấy người dùng sở hữu bản ghi trạng thái này.
     */
    public function user(): BelongsTo
    {
        // Khóa ngoại user_id trỏ về bảng users
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy cấp bậc thành viên (LoyaltyTier) mà bản ghi trạng thái này đang thuộc về.
     */
    public function loyaltyTier(): BelongsTo
    {
        // Khóa ngoại loyalty_tier_id trỏ về bảng loyalty_tiers
        return $this->belongsTo(LoyaltyTier::class);
    }
}
