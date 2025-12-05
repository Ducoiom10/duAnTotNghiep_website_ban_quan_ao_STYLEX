<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'keyword' => 'nullable|string|max:255',
            'category_id' => 'nullable|integer|exists:categories,id',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'color_id' => 'nullable|integer|exists:colors,id',
            'size_id' => 'nullable|integer|exists:sizes,id',
            'texture_id' => 'nullable|integer|exists:textures,id',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0',
            'in_stock' => 'nullable|in:0,1',
            'sort' => 'nullable|in:relevance,price_asc,price_desc,newest',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}
