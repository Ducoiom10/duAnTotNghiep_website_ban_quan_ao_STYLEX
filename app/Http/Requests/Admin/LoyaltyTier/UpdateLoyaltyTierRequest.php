<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateLoyaltyTierRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Kiểm tra xem người dùng có quyền Admin để cập nhật không
        return true;
    }

    public function rules(): array
    {
        // Lấy ID của đối tượng LoyaltyTier đang được chỉnh sửa từ route (tên tham số resource mặc định là loyalty_tier)
        $routeModel = $this->route('loyalty_tier');
        $loyaltyTierId = $routeModel ? $routeModel->id : null;

        return [
            // Không kiểm tra trùng tên theo yêu cầu
            'name' => ['required', 'string', 'max:50'],
            'min_spend_required' => 'required|numeric|min:0',
            'discount_rate' => 'required|numeric|between:0,100',
        ];
    }
}
