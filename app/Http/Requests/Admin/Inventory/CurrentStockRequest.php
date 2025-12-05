<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class CurrentStockRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện request này hay không.
     */
    public function authorize(): bool
    {
        // Giả định middleware đã xử lý quyền truy cập
        return true;
    }

    /**
     * Lấy các quy tắc xác thực áp dụng cho request.
     */
    public function rules(): array
    {
        return [
            // Bộ lọc: ID Kho hàng (phải tồn tại trong bảng `warehouses`)
            'warehouse_id' => ['nullable', 'integer', 'exists:warehouses,id'],

            // Bộ lọc: Tìm kiếm theo SKU hoặc Tên sản phẩm
            'search' => ['nullable', 'string', 'max:255'],

            // Tùy chọn: Hiển thị sản phẩm có tồn kho bằng 0 (chỉ chấp nhận '1' hoặc '0'/'true'/'false')
            'show_zero_stock' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'warehouse_id.exists' => 'ID kho hàng được chọn không hợp lệ.',
            'search.max' => 'Nội dung tìm kiếm không được vượt quá 255 ký tự.',
        ];
    }
}
