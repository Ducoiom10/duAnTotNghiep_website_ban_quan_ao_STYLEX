<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShippingCarrierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = optional($this->route('shipping_carrier'))->id ?? $this->route('shipping_carrier');
        return [
            'name' => [
                'required','max:50',
                Rule::unique('shipping_carriers','name')->ignore($id)
            ],
            'code' => [
                'required','max:20',
                Rule::unique('shipping_carriers','code')->ignore($id)
            ],
            'fee' => ['required','numeric','min:0'],
            'active' => ['nullable','boolean'],
        ];
    }
}
