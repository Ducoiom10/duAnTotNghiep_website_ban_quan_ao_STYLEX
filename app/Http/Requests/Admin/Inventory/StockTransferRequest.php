<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\WarehouseStock;

class StockTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from_warehouse_id' => ['required', 'exists:warehouses,id'],
            'to_warehouse_id' => ['required', 'exists:warehouses,id', 'different:from_warehouse_id'],
            'variant_id' => ['required', 'exists:product_variants,id'],
            'quantity' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) {
                    $variantId = $this->input('variant_id');
                    $fromWarehouseId = $this->input('from_warehouse_id');

                    if (!$variantId || !$fromWarehouseId) {
                        return;
                    }

                    $stock = WarehouseStock::where('variant_id', $variantId)
                        ->where('warehouse_id', $fromWarehouseId)
                        ->first();

                    $available = $stock ? $stock->available : 0;

                    if ($value > $available) {
                        $fail("Số lượng chuyển ({$value}) vượt quá tồn kho khả dụng ({$available}).");
                    }
                },
            ],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'from_warehouse_id' => 'Kho xuất',
            'to_warehouse_id' => 'Kho nhập',
            'variant_id' => 'Sản phẩm',
            'quantity' => 'Số lượng',
        ];
    }
}
