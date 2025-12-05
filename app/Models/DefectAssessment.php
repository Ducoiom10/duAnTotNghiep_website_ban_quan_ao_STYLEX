<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DefectAssessment extends Model
{
    protected $fillable = [
        'warehouse_id',
        'variant_id',
        'quantity',
        'defect_level',
        'description',
        'status',
        'defect_type',
        'defect_description',
        'classification',
        'repair_cost',
        'material_cost',
        'other_cost',
        'created_by',
        'assessed_by',
        'approved_by',
        'completed_by',
        'rejected_by',
        'stock_in_request_id',
        'rejection_reason',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'repair_cost' => 'decimal:2',
        'material_cost' => 'decimal:2',
        'other_cost' => 'decimal:2',
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

    public function assessedBy()
    {
        return $this->belongsTo(User::class, 'assessed_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function completedBy()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}