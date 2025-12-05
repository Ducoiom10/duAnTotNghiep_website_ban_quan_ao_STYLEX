<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class DashboardRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có được phép thực hiện request này hay không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Lấy các quy tắc xác thực áp dụng cho request.
     */
    public function rules(): array
    {
        return [
            // Cho phép lọc Dashboard theo Kho hàng
            'warehouse_id' => ['nullable', 'integer', 'exists:warehouses,id'],

            // Lọc theo Ngày bắt đầu
            'date_from' => ['nullable', 'date'],

            // Lọc theo Ngày kết thúc (phải lớn hơn hoặc bằng ngày bắt đầu)
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'warehouse_id.exists' => 'ID kho hàng được chọn không hợp lệ.',
            'date_to.after_or_equal' => 'Ngày kết thúc phải lớn hơn hoặc bằng Ngày bắt đầu.',
        ];
    }
}
