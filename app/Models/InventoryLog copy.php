<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = [
        'warehouse_id', 'variant_id', 'action', 'quantity_before', 'quantity_change',
        'quantity_after', 'reference_type', 'reference_id', 'user_id', 'notes'
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
