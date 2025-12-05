<?php

namespace App\Http\Requests\Admin\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Giả định admin đã đăng nhập
    }

    public function rules(): array
    {
        return [
            // Cài đặt WMS
            'wms_low_stock_threshold' => ['required', 'integer', 'min:0', 'max:1000'],
            'wms_auto_reserve_hours' => ['nullable', 'integer', 'min:1', 'max:168'],
            'wms_cost_method' => ['nullable', 'string', 'in:WAC,FIFO,LIFO'],
            'wms_auto_create_stock' => ['nullable', 'boolean'],
            'wms_require_batch' => ['nullable', 'boolean'],
            'wms_enable_negative_stock' => ['nullable', 'boolean'],

            // Cài đặt Báo cáo
            'report_default_period' => ['nullable', 'integer', 'in:7,30,90,365'],

            // Cài đặt Loyalty
            'loyalty_enabled' => ['nullable', 'boolean'],
            'loyalty_point_ratio' => ['nullable', 'numeric', 'min:0'],

            // Cài đặt chung
            'store_name' => ['nullable', 'string', 'max:100'],
            'store_phone' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function attributes(): array
    {
        return [
            'wms_low_stock_threshold' => 'Ngưỡng cảnh báo tồn kho thấp',
            'wms_auto_reserve_hours' => 'Tự động giữ hàng',
            'wms_cost_method' => 'Phương pháp tính giá vốn',
            'wms_auto_create_stock' => 'Tự động tạo bản ghi tồn kho',
            'wms_require_batch' => 'Bắt buộc nhập Batch/Serial',
            'wms_enable_negative_stock' => 'Cho phép tồn kho âm',
            'report_default_period' => 'Khoảng thời gian báo cáo mặc định',
            'loyalty_enabled' => 'Kích hoạt Loyalty',
            'loyalty_point_ratio' => 'Tỷ lệ quy đổi điểm',
            'store_name' => 'Tên cửa hàng',
            'store_phone' => 'Số điện thoại cửa hàng',
        ];
    }
}
