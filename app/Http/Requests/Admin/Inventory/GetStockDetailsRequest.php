<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class GetStockDetailsRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện request này hay không.
     * Thường là kiểm tra user có quyền truy cập API tồn kho hay không.
     */
    public function authorize(): bool
    {
        // Ví dụ: Chỉ cho phép Admin hoặc User có quyền 'view-inventory'
        // return auth()->user()?->is_admin ?? false;
        return true;
    }

    /**
     * Lấy các quy tắc xác thực áp dụng cho request.
     */
    public function rules(): array
    {
        return [
            // Bắt buộc và phải tồn tại trong bảng product_variants
            'variant_id' => ['required', 'integer', 'exists:product_variants,id'],

            // Bắt buộc và phải tồn tại trong bảng warehouses
            'warehouse_id' => ['required', 'integer', 'exists:warehouses,id'],
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'variant_id.required' => 'Mã biến thể sản phẩm là bắt buộc.',
            'variant_id.exists' => 'Mã biến thể sản phẩm không hợp lệ.',
            'warehouse_id.required' => 'Mã kho hàng là bắt buộc.',
            'warehouse_id.exists' => 'Mã kho hàng không hợp lệ.',
        ];
    }
}
