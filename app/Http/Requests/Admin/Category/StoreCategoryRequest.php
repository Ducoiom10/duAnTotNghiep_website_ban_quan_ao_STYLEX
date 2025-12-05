<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'category_name' => 'tên danh mục',
            'parent_id' => 'danh mục cha',
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
        ];
    }
}

