<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxRate extends Model
{
    use HasFactory;
    protected $table = 'tax_rates';
    protected $fillable = ['name', 'rate']; // rate: decimal(5,4) (VD: 0.1000 = 10%)
    protected $casts = [
        'rate' => 'decimal:4',
    ];
}
