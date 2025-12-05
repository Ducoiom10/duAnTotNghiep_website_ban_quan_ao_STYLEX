<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmCountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'available_qty' => 'nullable|integer|min:0',
            'reserved_qty' => 'nullable|integer|min:0',
            'quarantine_qty' => 'nullable|integer|min:0',
            'damaged_qty' => 'nullable|integer|min:0',
            'defect_level' => 'required_if:damaged_qty,>0|in:LIGHT,MEDIUM,HEAVY',
            'defect_type' => 'nullable|in:SEWING,CUTTING,DYEING,FABRIC,SIZE,OTHER',
            'defect_description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'defect_level.required_if' => 'Vui lòng chọn mức độ hỏng',
        ];
    }
}
