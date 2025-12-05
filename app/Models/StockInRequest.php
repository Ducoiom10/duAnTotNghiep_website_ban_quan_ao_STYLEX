<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInRequest extends Model
{
    protected $fillable = [
        'warehouse_id',
        'variant_id',
        'quantity',
        'batch_number',
        'cost_price',
        'received_date',
        'status',
        'qc_passed_qty',
        'created_by',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'qc_passed_qty' => 'integer',
        'cost_price' => 'decimal:2',
        'received_date' => 'date',
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
}