<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCarrier extends Model
{
    use HasFactory;
    protected $table = 'shipping_carriers';
    protected $fillable = ['name','code','active','is_active','fee','description','sort_order'];
    
    protected $casts = [
        'fee' => 'float',
        'sort_order' => 'integer',
        'is_active' => 'boolean',
        'active' => 'boolean',
    ];
}
