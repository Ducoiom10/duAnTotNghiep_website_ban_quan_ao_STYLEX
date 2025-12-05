<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryLog;

class InventoryLogController extends Controller
{
    public function index()
    {
        $logs = InventoryLog::with(['warehouse', 'variant.product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.inventory.log-history', compact('logs'));
    }
}
