<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function index(ProductFilterRequest $request)
    {
        $q = Product::query()
            ->with([
                'brand',
                'category',
                'images',
                'variants.color',
                'variants.size',
            ]);

        // only active/visible products (optional)
        $q->where('is_active', true);

        // keyword search
        $keyword = $request->input('keyword');
        if ($keyword) {
            // simple approach: name + short_description + description
            $q->where(function($qq) use ($keyword) {
                $qq->where('name', 'like', "%{$keyword}%")
                   ->orWhere('short_description', 'like', "%{$keyword}%")
                   ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // filters
        if ($category = $request->input('category_id')) {
            $categoryIds = Category::query()
                ->where('id', $category)
                ->orWhere('parent_id', $category)
                ->pluck('id')
                ->toArray();

            if (!empty($categoryIds)) {
                $q->whereIn('category_id', $categoryIds);
            } else {
            $q->where('category_id', $category);
            }
        }
        if ($brand = $request->input('brand_id')) {
            $q->where('brand_id', $brand);
        }

        // price range filter — consider base_price or variant price
        $min = $request->input('min_price');
        $max = $request->input('max_price');
        if ($min !== null || $max !== null) {
            $q->where(function($qq) use ($min, $max) {
                if ($min !== null) {
                    $qq->whereRaw('COALESCE(price_sale, price) >= ?', [$min]);
                }
                if ($max !== null) {
                    $qq->whereRaw('COALESCE(price_sale, price) <= ?', [$max]);
                }
            });
        }

        // filters that require variants (color/size/texture/in_stock)
        if ($color = $request->input('color_id')) {
            $q->whereHas('variants', fn($qq)=> $qq->where('color_id', $color));
        }
        if ($size = $request->input('size_id')) {
            $q->whereHas('variants', fn($qq)=> $qq->where('size_id', $size));
        }
        if ($texture = $request->input('texture_id')) {
            $q->whereHas('variants', fn($qq)=> $qq->where('texture_id', $texture));
        }
        // Removed stock filtering since quantity management is disabled

        // sort
        $sort = $request->input('sort','relevance');
        if ($sort === 'price_asc') {
            $q->orderByRaw('COALESCE(price_sale, price) ASC');
        } elseif ($sort === 'price_desc') {
            $q->orderByRaw('COALESCE(price_sale, price) DESC');
        } elseif ($sort === 'newest') {
            $q->orderBy('created_at','desc');
        } else {
            // relevance: if keyword present, try to order by match (simple approach)
            if ($keyword) {
                // naive scoring: name matches first
                $q->orderByRaw("CASE WHEN name LIKE ? THEN 1 WHEN short_description LIKE ? THEN 2 ELSE 3 END", ["%{$keyword}%","%{$keyword}%"]);
            } else {
                $q->orderBy('id','desc');
            }
        }

        // pagination
        $perPage = (int) $request->input('per_page', 15);
        $page = (int) $request->input('page', 1);

        // caching (simple example): cache by query string for 30s
        $cacheKey = 'products:' . md5(http_build_query($request->all()) . "|page={$page}|per={$perPage}");

        $result = Cache::remember($cacheKey, 30, function() use ($q, $perPage) {
            return $q->paginate($perPage);
        });

        return ProductResource::collection($result)
            ->additional([
                'meta' => [
                    'current_page' => $result->currentPage(),
                    'last_page' => $result->lastPage(),
                    'per_page' => $result->perPage(),
                    'total' => $result->total(),
                ]
            ]);
    }

    public function show(Product $product)
    {
        $product->load(['brand','category','images','variants.color','variants.size','variants.texture']);
        return new ProductResource($product);
    }
}
