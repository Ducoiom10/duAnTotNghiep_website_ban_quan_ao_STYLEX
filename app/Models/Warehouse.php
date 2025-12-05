<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $fillable = [
        'name',
        'code',
        'address',
        'phone',
        'email',
        'operational_status',
        'description',
    ];

    /**
     * Mối quan hệ với WarehouseStock
     */
    public function stocks()
    {
        return $this->hasMany(WarehouseStock::class);
    }

    /**
     * Mối quan hệ với InventoryLog
     */
    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class, 'warehouse_id');
    }
}