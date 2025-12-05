<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'category_id' => 'required|exists:categories,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'product_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_texts.*' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'price_sale' => 'nullable|numeric|min:0',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'variants.*.color_id' => 'nullable|exists:colors,id',
            'variants.*.size_id' => 'nullable|exists:sizes,id',
            'variants.*.texture_id' => 'nullable|exists:textures,id',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.quantity' => 'nullable|integer|min:0',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'variants.*.status' => 'boolean',
        ];
    }
}
