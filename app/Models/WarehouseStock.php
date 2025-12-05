<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseStock extends Model
{
    protected $fillable = [
        'warehouse_id',
        'variant_id',
        'on_hand',
        'available',
        'reserved',
        'quarantine',
        'damaged',
    ];

    protected $casts = [
        'on_hand' => 'integer',
        'available' => 'integer',
        'reserved' => 'integer',
        'quarantine' => 'integer',
        'damaged' => 'integer',
    ];

    /**
     * Mối quan hệ với Warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    /**
     * Mối quan hệ với ProductVariant
     */
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }
}