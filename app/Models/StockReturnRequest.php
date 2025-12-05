<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockReturnRequest extends Model
{
    protected $fillable = [
        'stock_in_request_id', 'quantity', 'reason', 'status', 'notes', 'created_by', 'approved_by', 'approved_at'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function stockInRequest()
    {
        return $this->belongsTo(StockInRequest::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
