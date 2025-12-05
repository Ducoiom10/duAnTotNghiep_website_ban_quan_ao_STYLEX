<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutInvoiceItem extends Model
{
    protected $fillable = [
        'stock_out_invoice_id',
        'variant_id',
        'quantity',
        'unit_price',
        'line_total',
        'defect_assessment_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'line_total' => 'decimal:2',
    ];

    public function invoice()
    {
        return $this->belongsTo(StockOutInvoice::class, 'stock_out_invoice_id');
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function defectAssessment()
    {
        return $this->belongsTo(DefectAssessment::class, 'defect_assessment_id');
    }
}