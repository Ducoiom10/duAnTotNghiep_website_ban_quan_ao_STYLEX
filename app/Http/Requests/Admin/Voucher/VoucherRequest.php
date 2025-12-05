<?php

namespace App\Http\Requests\Admin\Voucher;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Lấy voucher ID từ route parameter (có thể là model binding hoặc ID)
        $voucher = $this->route('voucher');
        $voucherId = $voucher ? (is_object($voucher) ? $voucher->id : $voucher) : null;

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('vouchers', 'code')->ignore($voucherId),
            ],
            'description' => ['nullable', 'string', 'max:500'],
            'type' => ['required', 'in:percent,fixed'],
            'value' => ['required', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'usage_limit' => ['nullable', 'integer', 'min:1'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'code' => 'mã voucher',
            'description' => 'mô tả',
            'type' => 'loại',
            'value' => 'giá trị',
            'max_discount_amount' => 'giảm tối đa',
            'min_order_amount' => 'đơn tối thiểu',
            'usage_limit' => 'giới hạn lượt dùng',
            'starts_at' => 'ngày bắt đầu',
            'ends_at' => 'ngày kết thúc',
            'is_active' => 'trạng thái kích hoạt',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Vui lòng nhập mã voucher.',
            'code.string' => 'Mã voucher phải là chuỗi ký tự.',
            'code.max' => 'Mã voucher không được vượt quá 50 ký tự.',
            'code.unique' => 'Mã voucher này đã tồn tại trong hệ thống.',
            
            'description.string' => 'Mô tả phải là chuỗi ký tự.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
            
            'type.required' => 'Vui lòng chọn loại voucher.',
            'type.in' => 'Loại voucher không hợp lệ.',
            
            'value.required' => 'Vui lòng nhập giá trị voucher.',
            'value.numeric' => 'Giá trị voucher phải là số.',
            'value.min' => 'Giá trị voucher phải lớn hơn hoặc bằng 0.',
            
            'max_discount_amount.numeric' => 'Giảm tối đa phải là số.',
            'max_discount_amount.min' => 'Giảm tối đa phải lớn hơn hoặc bằng 0.',
            
            'min_order_amount.numeric' => 'Đơn tối thiểu phải là số.',
            'min_order_amount.min' => 'Đơn tối thiểu phải lớn hơn hoặc bằng 0.',
            
            'usage_limit.integer' => 'Giới hạn lượt dùng phải là số nguyên.',
            'usage_limit.min' => 'Giới hạn lượt dùng phải lớn hơn hoặc bằng 1.',
            
            'starts_at.date' => 'Ngày bắt đầu không hợp lệ.',
            
            'ends_at.date' => 'Ngày kết thúc không hợp lệ.',
            'ends_at.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            
            'is_active.boolean' => 'Trạng thái kích hoạt không hợp lệ.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Chuyển đổi is_active thành boolean
        // Checkbox không checked sẽ không gửi giá trị, nên cần kiểm tra has()
        $this->merge([
            'is_active' => $this->has('is_active') && $this->is_active == '1',
        ]);
    }
}

