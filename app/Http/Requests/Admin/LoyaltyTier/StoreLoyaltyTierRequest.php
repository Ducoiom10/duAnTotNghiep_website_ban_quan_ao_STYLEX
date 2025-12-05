<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLoyaltyTierRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Kiểm tra xem người dùng có quyền Admin để tạo không
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50', Rule::unique('loyalty_tiers', 'name')],
            'min_spend_required' => 'required|numeric|min:0',
            'discount_rate' => 'required|numeric|between:0,100',
        ];
    }
}
