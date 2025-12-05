<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'variant_id' => ['required', 'exists:product_variants,id'],
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'physical_stock' => ['required', 'integer', 'min:0'], // Số lượng THỰC TẾ
            'reason' => ['required', 'string', 'max:255', Rule::in([
                'Kiểm kê điều chỉnh',
                'Hàng hư hỏng',
                'Khác'
            ])],
        ];
    }

    public function attributes(): array
    {
        return [
            'variant_id' => 'Biến thể sản phẩm',
            'warehouse_id' => 'Kho điều chỉnh',
            'physical_stock' => 'Số lượng tồn kho thực tế mới',
            'reason' => 'Lý do điều chỉnh',
        ];
    }
}
