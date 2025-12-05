<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    protected $fillable = [
        'from_warehouse_id', 'to_warehouse_id', 'variant_id', 'quantity', 'status',
        'created_by', 'out_confirmed_by', 'in_confirmed_by', 'notes'
    ];

    public function fromWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse()
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function outConfirmedBy()
    {
        return $this->belongsTo(User::class, 'out_confirmed_by');
    }

    public function inConfirmedBy()
    {
        return $this->belongsTo(User::class, 'in_confirmed_by');
    }
}
