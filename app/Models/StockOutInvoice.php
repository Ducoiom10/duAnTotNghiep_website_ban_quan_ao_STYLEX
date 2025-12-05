<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutInvoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'warehouse_id',
        'type',
        'total_amount',
        'status',
        'created_by',
        'completed_by',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'completed_at' => 'datetime',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(StockOutInvoiceItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }
}