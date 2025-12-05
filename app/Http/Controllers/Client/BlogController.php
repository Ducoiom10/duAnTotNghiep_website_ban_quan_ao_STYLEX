<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('search');
        $categorySlug = $request->input('category');
        $tagSlug = $request->input('tag');

        $blogs = Post::with(['category', 'tags'])
            ->when($keyword, function ($query, $keyword) {
                $query->where('title', 'like', "%{$keyword}%")
                    ->orWhere('content', 'like', "%{$keyword}%");
            })
            ->when($categorySlug, function ($query, $categorySlug) {
                $query->whereHas('category', function ($q) use ($categorySlug) {
                    $q->where('slug', $categorySlug);
                });
            })
            ->when($tagSlug, function ($query, $tagSlug) {
                $query->whereHas('tags', function ($q) use ($tagSlug) {
                    $q->where('slug', $tagSlug);
                });
            })
            ->where('status', 'published')
            ->latest('id')
            ->paginate(3)
            ->withQueryString();

        $categories = Category::with('children')->whereNull('parent_id')->paginate(5);

        // Lấy tất cả thẻ phổ biến (tag chứa bài viết nổi bật)
        $tags = Tag::whereHas('posts', function ($query) {
            $query->where('is_hot', true);
        })->orderBy('name')->get();

        // Lấy sản phẩm nổi bật (ví dụ có cột 'is_featured' = true)
        $product_feature = Product::where('is_featured', true)
            ->latest('id')
            ->take(3)
            ->get();

        return view('client.blogs.index', compact(
            'blogs',
            'categories',
            'tags',
            'product_feature'
        ));
    }
    public function show($slug)
    {
        // Lấy bài viết theo slug, kèm theo quan hệ category, tags, user
        $blog = Post::with(['category', 'tags', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Các dữ liệu phụ cho sidebar
        $categories = Category::with('children')->whereNull('parent_id')->paginate(5);
        $tags = Tag::whereHas('posts', function ($query) {
            $query->where('is_hot', true);
        })->orderBy('name')->get();
        $product_feature = Product::where('is_featured', true)->take(3)->get();

        // Có thể gợi ý bài viết liên quan
        $related_blogs = Post::where('category_id', $blog->category_id)
            ->where('id', '!=', $blog->id)
            ->latest('id')
            ->take(3)
            ->get();

        return view('client.blogs.detail', compact(
            'blog',
            'categories',
            'tags',
            'product_feature',
            'related_blogs'
        ));
    }
}
