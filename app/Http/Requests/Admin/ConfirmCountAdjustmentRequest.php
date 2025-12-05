<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfirmCountAdjustmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'available_qty' => 'required|integer|min:0',
            'reserved_qty' => 'required|integer|min:0',
            'quarantine_qty' => 'required|integer|min:0',
            'damaged_qty' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ];
    }
}
