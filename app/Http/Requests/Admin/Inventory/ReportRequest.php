<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
{
    /**
     * Xác định xem người dùng có quyền thực hiện request này hay không.
     */
    public function authorize(): bool
    {
        // Giả định quyền truy cập Admin đã được xử lý bằng Middleware
        return true;
    }

    /**
     * Định nghĩa các quy tắc kiểm tra dữ liệu đầu vào (validation rules).
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // time_range: Phải là số nguyên và nằm trong các giá trị cho phép (7, 30, 90, 365)
            'time_range' => [
                'nullable',
                'integer',
                'in:7,30,90,365'
            ],

            // warehouse_id: Phải là số nguyên, có thể rỗng, và phải tồn tại trong bảng 'warehouses'
            'warehouse_id' => [
                'nullable',
                'integer',
                'exists:warehouses,id'
            ],
        ];
    }

    /**
     * Định nghĩa tên thuộc tính tùy chỉnh (dùng cho thông báo lỗi).
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'time_range' => 'khoảng thời gian',
            'warehouse_id' => 'kho hàng',
        ];
    }
}
