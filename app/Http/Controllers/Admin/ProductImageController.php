<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Support\ImageOptimizer;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    /** Upload ảnh cho PRODUCT: thêm vào gallery + tuỳ chọn set thumbnail */
    public function storeProduct(Request $r, Product $product, ImageOptimizer $opt)
    {
        $r->validate([
            'image'      => ['required','image','mimes:jpg,jpeg,png,webp,avif','max:8192'],
            'alt'        => ['nullable','string','max:255'],
            'is_primary' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
            'set_thumb'  => ['nullable','boolean'],
        ]);

        $opt->saveForProduct($product, $r->file('image'), [
            'primary'               => $r->boolean('is_primary'),
            'alt'                   => $r->input('alt'),
            'sort'                  => (int)$r->input('sort_order', 0),
            'set_product_thumbnail' => $r->boolean('set_thumb'),
        ]);

        return back()->with('success', 'Upload & optimize ảnh PRODUCT thành công!');
    }

    /** Upload ảnh cho VARIANT: cập nhật biến thể + thêm vào gallery */
    public function storeVariant(Request $r, ProductVariant $variant, ImageOptimizer $opt)
    {
        $r->validate([
            'image'      => ['required','image','mimes:jpg,jpeg,png,webp,avif','max:8192'],
            'alt'        => ['nullable','string','max:255'],
            'is_primary' => ['nullable','boolean'],
            'sort_order' => ['nullable','integer','min:0'],
        ]);

        $opt->saveForVariant($variant, $r->file('image'), [
            'primary' => $r->boolean('is_primary'),
            'alt'     => $r->input('alt'),
            'sort'    => (int)$r->input('sort_order', 0),
        ]);

        return back()->with('success', 'Upload & optimize ảnh VARIANT thành công!');
    }
}
