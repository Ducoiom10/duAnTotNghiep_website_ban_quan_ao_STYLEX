<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoyaltyTier extends Model
{
    protected $fillable = ['name', 'min_spend_required', 'discount_rate'];

    /**
     * Lấy tất cả các bản ghi UserLoyalty (trạng thái người dùng) đang thuộc cấp bậc này.
     */
    public function userLoyalties(): HasMany
    {
        // Quan hệ One-to-Many: loyalty_tiers có nhiều record trong user_loyalty
        return $this->hasMany(UserLoyalty::class);
    }
}
