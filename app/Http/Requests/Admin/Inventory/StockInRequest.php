<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class StockInRequest extends FormRequest
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
            'batch_number' => ['required', 'string', 'unique:stock_in_requests,batch_number'],
            'quantity' => ['required', 'integer', 'min:1'],
            'cost_price' => ['required', 'numeric', 'min:0'],
            'expiry_date' => ['nullable', 'date', 'after:today'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function attributes(): array
    {
        return [
            'warehouse_id' => 'Kho nhập',
            'variant_id' => 'Sản phẩm',
            'batch_number' => 'Mã lô',
            'quantity' => 'Số lượng',
            'cost_price' => 'Giá nhập',
            'expiry_date' => 'Ngày hết hạn',
        ];
    }
}
