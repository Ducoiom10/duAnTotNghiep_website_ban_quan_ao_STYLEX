<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\WarehouseStock;

class StockOutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'variant_id' => ['required', 'exists:product_variants,id'],
            'batch_number' => ['required', 'string'],
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $variantId = $this->input('variant_id');
                    $warehouseId = $this->input('warehouse_id');

                    if (!$variantId || !$warehouseId) {
                        return;
                    }

                    $stock = WarehouseStock::where('variant_id', $variantId)
                        ->where('warehouse_id', $warehouseId)
                        ->first();

                    $available = $stock ? $stock->available : 0;

                    if ($value > $available) {
                        $fail("Số lượng xuất ({$value}) vượt quá tồn kho khả dụng ({$available}).");
                    }
                },
            ],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'warehouse_id' => 'Kho xuất',
            'variant_id' => 'Sản phẩm',
            'batch_number' => 'Mã lô',
            'quantity' => 'Số lượng',
        ];
    }
}
