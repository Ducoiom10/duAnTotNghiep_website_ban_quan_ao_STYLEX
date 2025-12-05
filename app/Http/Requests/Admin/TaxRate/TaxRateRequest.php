<?php

namespace App\Http\Requests\Admin\TaxRate;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaxRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // tùy chính sách của bạn (auth/is_admin middleware)
    }

    public function rules(): array
    {
        $id = $this->route('tax_rate'); // nếu route dùng {tax_rate}
        return [
            'name' => [
                'required','max:50',
                Rule::unique('tax_rates','name')->ignore($id)
            ],
            // 0 -> 1: tương đương 0% -> 100%
            'rate' => ['required','numeric','between:0,1']
        ];
    }
}
