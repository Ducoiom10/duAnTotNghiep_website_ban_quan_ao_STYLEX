<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Lấy category ID từ route parameter
        $categoryId = $this->route('id');
        
        return [
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($categoryId),
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                Rule::notIn([$categoryId]), // Không được chọn chính nó làm danh mục cha
            ],
            'status' => [
                'required',
                'in:0,1',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_name' => 'tên danh mục',
            'parent_id' => 'danh mục cha',
            'status' => 'trạng thái',
        ];
    }

    public function messages(): array
    {
        return [
            'category_name.required' => 'Vui lòng nhập tên danh mục.',
            'category_name.string' => 'Tên danh mục phải là chuỗi ký tự.',
            'category_name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'category_name.unique' => 'Tên danh mục này đã tồn tại trong hệ thống.',
            
            'parent_id.exists' => 'Danh mục cha không tồn tại trong hệ thống.',
            'parent_id.not_in' => 'Danh mục không thể chọn chính nó làm danh mục cha.',
            
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}

