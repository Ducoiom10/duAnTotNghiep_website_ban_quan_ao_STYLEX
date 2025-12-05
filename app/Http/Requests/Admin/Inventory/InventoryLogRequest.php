<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class InventoryLogRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện request này hay không.
     */
    public function authorize(): bool
    {
        // Giả sử chỉ user đã đăng nhập/có quyền mới được truy cập,
        // middleware CheckRole đã xử lý việc kiểm tra quyền truy cập.
        return true;
    }

    /**
     * Lấy các quy tắc xác thực áp dụng cho request.
     */
    public function rules(): array
    {
        // Định nghĩa các loại giao dịch hợp lệ dựa trên bảng `inventory_logs`
        $validTypes = ['IN', 'OUT', 'TRANSFER', 'ADJUSTMENT', 'SALE_RETURN', 'PURCHASE_RETURN'];

        return [
            // Bộ lọc: Loại giao dịch
            'type' => ['nullable', 'string', 'in:' . implode(',', $validTypes)],

            // Bộ lọc: Kho (phải là ID tồn tại trong bảng `warehouses`)
            'warehouse_id' => ['nullable', 'integer', 'exists:warehouses,id'],

            // Bộ lọc: Biến thể Sản phẩm (phải là ID tồn tại trong bảng `product_variants`)
            'variant_id' => ['nullable', 'integer', 'exists:product_variants,id'],

            // Bộ lọc: Loại chứng từ gốc
            'reference_type' => ['nullable', 'string', 'max:50'],

            // Bộ lọc: Ngày (đảm bảo là định dạng ngày hợp lệ)
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date', 'after_or_equal:from_date'], // 'to_date' phải sau hoặc bằng 'from_date'

            // Bộ lọc: Mã Lô/Serial
            'batch_serial' => ['nullable', 'string', 'max:100'],
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi (tùy chọn).
     */
    public function messages(): array
    {
        return [
            'to_date.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng ngày bắt đầu.',
            'type.in' => 'Loại giao dịch không hợp lệ.',
            'warehouse_id.exists' => 'ID kho hàng không tồn tại.',
            'variant_id.exists' => 'ID biến thể sản phẩm không tồn tại.',
        ];
    }
}
