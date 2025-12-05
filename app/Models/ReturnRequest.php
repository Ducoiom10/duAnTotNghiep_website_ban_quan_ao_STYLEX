<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ReturnRequest extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'rma_number', 'type', 'reason', 'reason_description',
        'status', 'approved_by', 'received_by', 'qc_by', 'approved_at', 'received_at',
        'qc_at', 'qc_notes', 'notes'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'received_at' => 'datetime',
        'qc_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ReturnItem::class);
    }

    public function refund(): BelongsTo
    {
        return $this->hasOne(Refund::class);
    }

    public function approvedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function receivedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function qcByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'qc_by');
    }

    public function getTotalRefundAmount(): int
    {
        return $this->items()->sum('unit_price');
    }
}
