<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ShippingCarrier;
use App\Models\TaxRate;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    protected VoucherService $voucherService;

    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }
    private function getOwnerKeys(): array
    {
        $userId = Auth::id();
        if ($userId) {
            return ['user_id' => $userId, 'session_id' => null];
        }
        return ['user_id' => null, 'session_id' => session()->getId()];
    }

    private function baseCartQuery()
    {
        $owner = $this->getOwnerKeys();
        return Cart::query()
            ->when($owner['user_id'], function ($q) use ($owner) {
                $q->where('user_id', $owner['user_id']);
            }, function ($q) use ($owner) {
                $q->where('session_id', $owner['session_id']);
            });
    }

    private function resolveItemPrice(Product $product, ?ProductVariant $variant): float
    {
        if ($variant && $variant->price) {
            return (float) $variant->price;
        }
        $base = $product->price_sale ?? $product->price;
        return (float) $base;
    }

    public function index(Request $request)
    {
        $items = $this->baseCartQuery()
            ->with([
                'product.productImages',
                'product.primaryImage',
                'product.productVariants.texture',
                'variant.size',
                'variant.color',
                'variant.texture'
            ])
            ->get();

        // Nếu giỏ hàng trống thì không cho vào trang thanh toán
        if ($items->isEmpty()) {
            return redirect()
                ->route('client.cart.index')
                ->with('error', 'Giỏ hàng trống, không thể thanh toán. Vui lòng thêm sản phẩm trước.');
        }

        $cartData = [];
        $subtotal = 0.0;
        foreach ($items as $it) {
            $product = $it->product;
            if (!$product) { continue; }
            $variant = $it->variant;
            $price = $this->resolveItemPrice($product, $variant);
            $line = $price * (int) $it->quantity;
            $subtotal += $line;

            $textureNames = [];
            if ($product && $product->relationLoaded('productVariants')) {
                $textureNames = $product->productVariants
                    ->map(function ($variant) {
                        return optional($variant->texture)->name;
                    })
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();
            }

            $cartData[] = [
                'id' => $it->id,
                'product' => $product,
                'variant' => $variant,
                'variant_id' => $it->variant_id,
                'quantity' => (int) $it->quantity,
                'price' => $price,
                'line_total' => $line,
                'textures' => $textureNames,
            ];
        }

        // Calculate discount using VoucherService (trước thuế & phí ship)
        $voucherResult = $this->voucherService->recalculateDiscount($subtotal);
        $discount = $voucherResult['discount'];
        $totalAfterDiscount = $voucherResult['total'];
        $appliedVoucher = $this->voucherService->getAppliedVoucher();

        // Ưu tiên ID đơn vị vận chuyển từ query (chọn từ giỏ hàng) nếu có
        $shippingCarrierId = $request->query('shipping_carrier_id');
        if ($shippingCarrierId) {
            session([
                'cart.shipping_carrier_id' => (int) $shippingCarrierId,
            ]);
        } else {
            $shippingCarrierId = session('cart.shipping_carrier_id');
        }

        // Lấy đơn vị vận chuyển đã chọn từ session (nếu có)
        $shippingCarrier = $shippingCarrierId
            ? ShippingCarrier::where('active', true)->find($shippingCarrierId)
            : null;

        $shippingFee = $shippingCarrier ? (float) ($shippingCarrier->fee ?? 0) : 0.0;

        // Lấy thuế mặc định (VD: chọn mức VAT có rate lớn nhất)
        $taxRate = TaxRate::orderByDesc('rate')->first();
        $taxAmount = 0.0;
        if ($taxRate && $subtotal > 0) {
            $taxAmount = (float) round($subtotal * (float) $taxRate->rate);
        }

        // Tổng cuối cùng = tiền hàng - giảm giá + thuế + phí ship
        $grandTotal = max(0, $subtotal - $discount + $taxAmount + $shippingFee);

        return view('client.checkout.index', [
            'cartData' => $cartData,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $grandTotal,
            'taxAmount' => $taxAmount,
            'taxRate' => $taxRate,
            'shippingFee' => $shippingFee,
            'shippingCarrier' => $shippingCarrier,
            'voucher' => $appliedVoucher,
        ]);
    }

    public function place(Request $request)
    {
        $request->validate([
            'buyer_full_name' => 'required|string|max:255',
            'buyer_phone' => 'required|string|max:30',
            'buyer_email' => 'nullable|email',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:120',
            'payment_method' => 'required|in:cod,online',
        ]);

        $owner = $this->getOwnerKeys();
        $items = $this->baseCartQuery()->with(['product','variant'])->get();
        if ($items->isEmpty()) {
            return redirect()->route('client.cart.index')->with('error', 'Giỏ hàng trống.');
        }

        // Tính subtotal
        $subtotal = 0.0;
        foreach ($items as $it) {
            $subtotal += $this->resolveItemPrice($it->product, $it->variant) * (int) $it->quantity;
        }

        // Calculate discount using VoucherService (trước thuế & phí ship)
        $voucherResult = $this->voucherService->recalculateDiscount($subtotal);
        $discount = $voucherResult['discount'];
        $appliedVoucher = $this->voucherService->getAppliedVoucher();

        // Lấy lại lựa chọn đơn vị vận chuyển từ session
        $shippingCarrierId = session('cart.shipping_carrier_id');
        $shippingCarrier = $shippingCarrierId
            ? ShippingCarrier::where('active', true)->find($shippingCarrierId)
            : null;

        $shippingFee = $shippingCarrier ? (float) ($shippingCarrier->fee ?? 0) : 0.0;

        // Lấy thuế mặc định
        $taxRate = TaxRate::orderByDesc('rate')->first();
        $taxAmount = 0.0;
        if ($taxRate && $subtotal > 0) {
            $taxAmount = (float) round($subtotal * (float) $taxRate->rate);
        }

        // Tổng cuối cùng
        $grandTotal = max(0, $subtotal - $discount + $taxAmount + $shippingFee);

        // Tạo Order + OrderItems (transaction)
        $order = DB::transaction(function() use ($request, $owner, $items, $subtotal, $discount, $taxRate, $taxAmount, $shippingCarrier, $shippingFee, $grandTotal, $appliedVoucher) {
            $order = Order::create([
                'user_id' => $owner['user_id'],
                'session_id' => $owner['session_id'],
                'code' => 'OD'.strtoupper(substr(sha1(uniqid('', true)), 0, 10)),
                'buyer_name' => $request->buyer_full_name,
                'buyer_phone' => $request->buyer_phone,
                'buyer_email' => $request->buyer_email,
                'full_name' => $request->full_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'city' => $request->city,
                'address' => $request->address,
                'note' => $request->note,
                'subtotal' => (int) $subtotal,
                'shipping_fee' => (int) $shippingFee,
                'discount' => (int) $discount,
                'tax_rate_id' => $taxRate?->id,
                'tax_amount' => (int) $taxAmount,
                'shipping_carrier_id' => $shippingCarrier?->id,
                'total' => (int) $grandTotal,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_method === 'online' ? 'paid' : 'unpaid',
                'status' => 'pending',
            ]);

            foreach ($items as $it) {
                $price = (int) $this->resolveItemPrice($it->product, $it->variant);
                $qty = (int) $it->quantity;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $it->product->id,
                    'variant_id' => $it->variant_id,
                    'quantity' => $qty,
                    'price' => $price,
                    'line_total' => $price * $qty,
                ]);
            }

            // Clear cart and voucher after order created
            Cart::clearOwner($owner['user_id'], $owner['session_id']);
            $this->voucherService->removeFromSession();
            return $order;
        });

        $msg = $request->payment_method === 'online'
            ? 'Thanh toán online thành công! Mã đơn: '.$order->code
            : 'Đặt hàng thành công (COD). Mã đơn: '.$order->code;
        return redirect()->route('client.checkout.thankyou', ['id' => $order->id]);
    }

    public function thankyou($id) {
        $order = Order::with('items.product','items.variant.size','items.variant.color','items.variant.texture')->findOrFail($id);
        return view('client.checkout.thankyou', compact('order'));
    }
    public function track(Request $request) {
        $order = null;
        if($request->has('code') && $request->code){
            $order = Order::with([
                'items.product',
                'items.product.productVariants.size',
                'items.product.productVariants.color',
                'items.product.productVariants.texture',
                'items.variant.size',
                'items.variant.color',
                'items.variant.texture',
                'reviews' // Load reviews để kiểm tra đã đánh giá chưa
            ])
                ->where('code', $request->code)->orWhere('id', $request->code)
                ->orWhere('phone', $request->code)->latest()->first();
            
            // Nếu có order, kiểm tra xem sản phẩm nào đã được đánh giá
            if ($order) {
                $reviewedProductIds = $order->reviews->pluck('product_id')->toArray();
                foreach ($order->items as $item) {
                    $item->is_reviewed = in_array($item->product_id, $reviewedProductIds);
                }
            }
        }
        return view('client.orders.track', compact('order'));
    }

    public function orderList(Request $request) {
        $userId = Auth::id();
        $sessionId = session()->getId();
        $statusTabs = [
            'pending' => 'Chờ xác nhận',
            'processing' => 'Vận chuyển',
            'shipping' => 'Chờ giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
            'returned' => 'Trả hàng/Hoàn tiền',
        ];
        $statusFilter = $request->query('status');
        if ($statusFilter && !array_key_exists($statusFilter, $statusTabs)) {
            $statusFilter = null;
        }

        $orders = \App\Models\Order::query()
            ->when($userId, function($q) use ($userId){ $q->where('user_id', $userId); })
            ->when(!$userId, function($q) use ($sessionId){ $q->where('session_id', $sessionId); })
            ->when($statusFilter, function($q) use ($statusFilter){
                $q->where('status', $statusFilter);
            })
            ->orderByDesc('created_at')
            ->with([
                'items.product.productVariants.texture',
                'items.product.productImages',
                'items.product.primaryImage',
                'items.variant',
                'items.variant.size',
                'items.variant.color',
                'items.variant.texture',
                'reviews' // Load reviews để kiểm tra đã đánh giá chưa
            ])
            ->get();
        
        // Đánh dấu sản phẩm đã được đánh giá
        foreach ($orders as $order) {
            if (in_array($order->status, ['completed', 'delivered'])) {
                $reviewedProductIds = $order->reviews->pluck('product_id')->toArray();
                foreach ($order->items as $item) {
                    $item->is_reviewed = in_array($item->product_id, $reviewedProductIds);
                }
            }
        }

        return view('client.orders.index', [
            'orders' => $orders,
            'activeStatus' => $statusFilter,
            'statusTabs' => $statusTabs,
        ]);
    }

    public function cancel(Request $request, Order $order)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        if (($order->user_id && $order->user_id !== $userId) ||
            (!$order->user_id && $order->session_id !== $sessionId)) {
            abort(403, 'Bạn không có quyền hủy đơn này.');
        }

        if ($order->status !== 'pending') {
            return back()->with('error', 'Chỉ có thể hủy các đơn đang ở trạng thái chờ xác nhận.');
        }

        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'nullable|string|max:1000',
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
            return back()->with('error', 'Chỉ có thể đánh giá sản phẩm từ đơn hàng đã hoàn thành.');
        }

        // Lấy order item
        $orderItem = $order->items()->findOrFail($request->order_item_id);
        $productId = $orderItem->product_id;
        $variantId = $orderItem->variant_id;

        // Kiểm tra variant_id có tồn tại trong product_variants không
        $validVariantId = null;
        if ($variantId) {
            $variantExists = \App\Models\ProductVariant::where('id', $variantId)->exists();
            if ($variantExists) {
                $validVariantId = $variantId;
            }
        }

        // Kiểm tra đã đánh giá chưa
        $existingReview = \App\Models\Review::where('order_id', $order->id)
            ->where(function($q) use ($productId, $validVariantId) {
                $q->where('product_id', $productId);
                if ($validVariantId) {
                    $q->where('product_variant_id', $validVariantId);
                } else {
                    $q->whereNull('product_variant_id');
                }
            })
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Bạn đã đánh giá sản phẩm này rồi.');
        }

        // Tạo review
        \App\Models\Review::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'product_variant_id' => $validVariantId,
            'order_id' => $order->id,
            'rating' => $request->rating,
            'content' => $request->input('content', ''),
            'tags' => [],
            'status' => 'public',
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đánh giá sản phẩm!');
    }
}


