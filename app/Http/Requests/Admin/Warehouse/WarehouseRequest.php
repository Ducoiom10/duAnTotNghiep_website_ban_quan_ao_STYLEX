<?php

namespace App\Http\Requests\Admin\Warehouse;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WarehouseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $warehouseId = $this->route('warehouse'); // Lấy ID từ route (khi update)

        // Các loại Type và Status từ migration
        $types = ['PHYSICAL', 'VIRTUAL', 'CONSIGNMENT', 'SCRAP'];
        $statuses = ['ACTIVE', 'INACTIVE', 'MAINTENANCE'];

        return [
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('warehouses', 'name')->ignore($warehouseId)
            ],

            'code' => [
                'required', 'string', 'max:15', 'alpha_dash', // Chỉ cho phép A-Z, 0-9, -, _
                Rule::unique('warehouses', 'code')->ignore($warehouseId)
            ],

            'type' => [
                'required',
                Rule::in($types)
            ],

            'operational_status' => [
                'required',
                Rule::in($statuses)
            ],

            'address' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Tên Kho hàng',
            'code' => 'Mã Kho hàng',
            'type' => 'Loại kho',
            'operational_status' => 'Trạng thái hoạt động',
            'address' => 'Địa chỉ',
        ];
    }
}
