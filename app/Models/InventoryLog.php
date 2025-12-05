<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'variant_id',
        'action',
        'quantity_before',
        'quantity_change',
        'quantity_after',
        'reference_type',
        'reference_id',
        'user_id',
        'notes',
    ];

    /**
     * Mối quan hệ với ProductVariant
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Mối quan hệ với Warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    /**
     * Mối quan hệ với User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
