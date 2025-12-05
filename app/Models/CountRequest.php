<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountRequest extends Model
{
    protected $fillable = [
        'warehouse_id',
        'variant_id',
        'system_qty',
        'physical_qty',
        'available_qty',
        'reserved_qty',
        'quarantine_qty',
        'damaged_qty',
        'difference',
        'status',
        'notes',
        'created_by',
        'counted_by',
        'confirmed_by',
    ];

    protected $casts = [
        'system_qty' => 'integer',
        'physical_qty' => 'integer',
        'available_qty' => 'integer',
        'reserved_qty' => 'integer',
        'quarantine_qty' => 'integer',
        'damaged_qty' => 'integer',
        'difference' => 'integer',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function countedBy()
    {
        return $this->belongsTo(User::class, 'counted_by');
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }
}