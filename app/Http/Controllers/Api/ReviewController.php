<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Tạo đánh giá sản phẩm từ đơn hàng
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
            'tags' => 'nullable|array',
        ]);

        $userId = Auth::id();
        $sessionId = session()->getId();

        // Kiểm tra quyền sở hữu đơn hàng
        $order = Order::where('id', $request->order_id)
            ->where(function($q) use ($userId, $sessionId) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->where('session_id', $sessionId);
                }
            })
            ->firstOrFail();

        // Kiểm tra đơn hàng đã hoàn thành chưa
        if (!in_array($order->status, ['completed', 'delivered'])) {
            return response()->json([
                'success' => false,
                'message' => 'Chỉ có thể đánh giá sản phẩm từ đơn hàng đã hoàn thành.'
            ], 400);
        }

        // Lấy order item
        $orderItem = $order->items()->findOrFail($request->order_item_id);
        $productId = $orderItem->getAttribute('product_id');
        $variantId = $orderItem->getAttribute('variant_id');

        // Kiểm tra đã đánh giá chưa (kiểm tra theo order_item_id hoặc product_id + variant_id)
        $existingReview = Review::where('order_id', $order->id)
            ->where(function($q) use ($productId, $variantId) {
                $q->where('product_id', $productId)
                  ->where('product_variant_id', $variantId);
            })
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã đánh giá sản phẩm này rồi.'
            ], 400);
        }

        // Tạo review
        $review = Review::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'product_variant_id' => $variantId ?? null,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'content' => $request->content,
            'tags' => $request->tags ?? [],
            'status' => 'public', // Tự động hiển thị (theo database enum: public/hidden)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đánh giá của bạn đã được gửi. Cảm ơn bạn!',
            'review' => $review->load('user', 'product')
        ]);
    }

    /**
     * Lấy danh sách review của một sản phẩm
     */
    public function getProductReviews($productId)
    {
        $reviews = Review::where('product_id', $productId)
            ->where('status', 'approved') // Chỉ hiển thị review đã duyệt
            ->with(['user:id,name', 'productVariant', 'media'])
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }
}
