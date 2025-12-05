<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'description',
        'type', // percent | fixed
        'value',
        'max_discount_amount',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'starts_at',
        'ends_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'float',
        'max_discount_amount' => 'float',
        'min_order_amount' => 'float',
        'usage_limit' => 'int',
        'used_count' => 'int',
        'is_active' => 'bool',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];
}


