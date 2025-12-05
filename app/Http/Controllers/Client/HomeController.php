<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        // 1. Lấy danh mục từ database
        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->limit(6)
            ->get();
        
        // 2. Lấy banner đang hoạt động (quản lý trong admin)
        $banners = Banner::query()
            ->where('status', 1)
            ->orderBy('order', 'asc')
            ->get();

        // 3. Lấy sản phẩm từ database với đầy đủ thông tin cho modal
        $products = Product::with([
                'category', 
                'primaryImage',
                'productImages',
                'productVariants.size',
                'productVariants.color',
                'productVariants.texture'
            ])
            ->where('is_active', 1)
            ->orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        // 4. Trả về view của trang chủ và "gán" (pass) biến vào view
        $quickProduct = null;
        if ($request->filled('quick_view')) {
            $quickProduct = Product::with(['category', 'productImages', 'productVariants.color', 'productVariants.size', 'productVariants.texture'])
                ->where('is_active', 1)
                ->find($request->quick_view);
        }

        return view('client.index', [
            'categories' => $categories,
            'products' => $products,
            'quickProduct' => $quickProduct,
            'banners' => $banners,
        ]);
    }
}
