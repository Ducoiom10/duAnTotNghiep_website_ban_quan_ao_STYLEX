<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutRequest extends Model
{
    protected $fillable = [
        'warehouse_id', 'variant_id', 'batch_number', 'quantity',
        'expiry_date', 'status', 'qc_passed_qty', 'qc_failed_qty',
        'created_by', 'qc_by', 'confirmed_by', 'notes'
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function qcBy()
    {
        return $this->belongsTo(User::class, 'qc_by');
    }

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function approvals()
    {
        return $this->morphMany(InventoryApproval::class, 'approvable');
    }
}
