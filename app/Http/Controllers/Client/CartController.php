<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ApplyVoucherRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ShippingCarrier;
use App\Models\Voucher;
use App\Services\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
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

    private function resolveItemPrice(Product $product, ?ProductVariant $variant): int|float
    {
        // Ưu tiên: variant price > product price_sale > product price
        if ($variant && $variant->price && $variant->price > 0) {
            return (float) $variant->price;
        }
        // Chỉ dùng price_sale nếu có, nếu không có thì dùng price
        if ($product->price_sale && $product->price_sale > 0) {
            return (float) $product->price_sale;
        }
        return (float) $product->price;
    }

    /**
     * Calculate cart subtotal
     *
     * @return float
     */
    private function calculateSubtotal(): float
    {
        $cartItems = $this->baseCartQuery()
            ->with(['product', 'variant'])
            ->get();

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $variant = $item->variant;
            $product = $item->product;
            $price = $this->resolveItemPrice($product, $variant);
            $subtotal += $price * $item->quantity;
        }

        return (float) $subtotal;
    }

    /**
     * Group cart items by product_id + size + color
     * 
     * @param \Illuminate\Database\Eloquent\Collection $cartItems
     * @return array
     */
    private function groupCartItems($cartItems): array
    {
        $groupedItems = [];
        $total = 0;
        $itemCount = 0;

        foreach ($cartItems as $item) {
            $variant = $item->variant;
            $product = $item->product;
            $size = $variant && $variant->size ? $variant->size->name : null;
            $color = $variant && $variant->color ? $variant->color->name : null;
            $texture = $variant && $variant->texture ? $variant->texture->name : null;
            $price = $this->resolveItemPrice($product, $variant);
            
            // Create a key for grouping: product_id + size + color (mỗi màu là 1 item riêng)
            $groupKey = $product->id . '_' . ($size ?? 'no_size') . '_' . ($color ?? 'no_color');
            
            if (!isset($groupedItems[$groupKey])) {
                $groupedItems[$groupKey] = [
                    'product' => $product,
                    'size' => $size,
                    'color' => $color,
                    'textures' => [],
                    'items' => [],
                ];
            }
            
            // Add texture to the group if it exists
            if ($texture && !in_array($texture, $groupedItems[$groupKey]['textures'])) {
                $groupedItems[$groupKey]['textures'][] = $texture;
            }
            
            // Store individual item data
            $itemData = [
                'id' => $item->id,
                'variant_id' => $item->variant_id,
                'quantity' => $item->quantity,
                'price' => $price,
                'color' => $color,
                'line_total' => $price * $item->quantity,
            ];
            
            $groupedItems[$groupKey]['items'][] = $itemData;
            $total += $price * $item->quantity;
            $itemCount += $item->quantity;
        }

        return [
            'groupedItems' => $groupedItems,
            'total' => $total,
            'itemCount' => $itemCount,
        ];
    }

    private function resolveVariantByAttributes(int $productId, ?string $sizeName, ?string $colorName, ?string $textureName): ?ProductVariant
    {
        // If no attribute provided, do NOT guess a variant
        if (!$sizeName && !$colorName && !$textureName) {
            return null;
        }
        
        // Lấy tất cả variants của sản phẩm với relationships
        $variants = ProductVariant::where('product_id', $productId)
            ->with(['size', 'color', 'texture'])
            ->get();
        
        if ($variants->isEmpty()) {
            return null;
        }
        
        // Normalize input values
        $sizeName = $sizeName ? trim($sizeName) : null;
        $colorName = $colorName ? trim($colorName) : null;
        $textureName = $textureName ? trim($textureName) : null;
        
        // Tìm variant khớp: chỉ tìm dựa trên size + color (bỏ texture vì texture không cho chọn)
        // Phải khớp CHÍNH XÁC size và color nếu đã được cung cấp
        foreach ($variants as $variant) {
            $vSize = $variant->size ? trim($variant->size->name) : '';
            $vColor = $variant->color ? trim($variant->color->name) : '';
            
            // Nếu user đã chọn size, variant PHẢI có size và khớp CHÍNH XÁC
            if ($sizeName && $sizeName !== '') {
                if ($vSize === '' || $sizeName !== $vSize) {
                    continue; // Không khớp size, bỏ qua variant này
                }
            } else {
                // Nếu user không chọn size, variant có thể có hoặc không có size
                // Nhưng nếu variant có size mà user không chọn, thì không khớp
                if ($vSize !== '') {
                    continue; // Variant có size nhưng user không chọn, không khớp
                }
            }
            
            // Nếu user đã chọn color, variant PHẢI có color và khớp CHÍNH XÁC
            if ($colorName && $colorName !== '') {
                if ($vColor === '' || $colorName !== $vColor) {
                    continue; // Không khớp color, bỏ qua variant này
                }
            } else {
                // Nếu user không chọn color, variant có thể có hoặc không có color
                // Nhưng nếu variant có color mà user không chọn, thì không khớp
                if ($vColor !== '') {
                    continue; // Variant có color nhưng user không chọn, không khớp
                }
            }
            
            // Nếu đến đây thì đã khớp size và color
            return $variant;
        }
        
        return null;
    }

    /** Get cart data (AJAX) */
    public function getCart(Request $request)
    {
        $cartItems = $this->baseCartQuery()
            ->with([
                'product.productImages',
                'product.primaryImage',
                'variant.color',
                'variant.size',
                'variant.texture'
            ])
            ->get();

        $grouped = $this->groupCartItems($cartItems);
        $groupedItems = $grouped['groupedItems'];
        $total = $grouped['total'];
        $itemCount = $grouped['itemCount'];
        
        // Convert grouped items to display format
        $cartData = [];
        foreach ($groupedItems as $group) {
            $totalQty = 0;
            $totalLine = 0;
            $minPrice = PHP_INT_MAX;
            $maxPrice = 0;
            
            foreach ($group['items'] as $item) {
                $totalQty += $item['quantity'];
                $totalLine += $item['line_total'];
                if ($item['price'] < $minPrice) $minPrice = $item['price'];
                if ($item['price'] > $maxPrice) $maxPrice = $item['price'];
            }
            
            $firstItem = $group['items'][0];
            $avgPrice = $totalQty > 0 ? $totalLine / $totalQty : $firstItem['price'];
            
            // For mini cart, we'll use the first variant for display
            $firstVariant = ProductVariant::with(['size', 'color', 'texture'])->find($firstItem['variant_id']);
            
            $cartData[] = [
                'id' => $firstItem['id'],
                'ids' => array_column($group['items'], 'id'),
                'product' => [
                    'id' => $group['product']->id,
                    'name' => $group['product']->name,
                    'default_image_url' => $group['product']->default_image_url,
                ],
                'variant' => $firstVariant ? [
                    'id' => $firstVariant->id,
                    'size' => $firstVariant->size ? ['name' => $firstVariant->size->name] : null,
                    'color' => $firstVariant->color ? ['name' => $firstVariant->color->name] : null,
                    'texture' => $firstVariant->texture ? ['name' => $firstVariant->texture->name] : null,
                ] : null,
                'variant_id' => $firstItem['variant_id'],
                'quantity' => $totalQty,
                'price' => $avgPrice,
                'size' => $group['size'],
                'color' => $group['color'] ?? null,
                'textures' => $group['textures'] ?? [],
            ];
        }

        return response()->json([
            'cart_items' => $cartData,
            'total_amount' => (float) $total,
            'item_count' => (int) $itemCount,
        ]);
    }

    /** Display cart page */
    public function index(Request $request)
    {
        // If AJAX request for totals only
        if ($request->ajax() && $request->boolean('totals_only')) {
            $cartItems = $this->baseCartQuery()->get();
            $grouped = $this->groupCartItems($cartItems);
            $total = $grouped['total'];
            $discountData = $this->voucherService->recalculateDiscount($total);
            
            return response()->json([
                'subtotal' => $total,
                'discount' => $discountData['discount'],
                'total' => $discountData['total']
            ]);
        }
        
        $cartItems = $this->baseCartQuery()
            ->with([
                'product.productImages',
                'product.primaryImage',
                'product.productVariants.size',
                'product.productVariants.color',
                'product.productVariants.texture',
                'variant.color',
                'variant.size',
                'variant.texture'
            ])
            ->get();

        $grouped = $this->groupCartItems($cartItems);
        $groupedItems = $grouped['groupedItems'];
        $total = $grouped['total'];
        
        // Convert grouped items to display format
        $cartData = [];
        foreach ($groupedItems as $group) {
            $totalQty = 0;
            $totalLine = 0;
            $minPrice = PHP_INT_MAX;
            $maxPrice = 0;
            
            foreach ($group['items'] as $item) {
                $totalQty += $item['quantity'];
                $totalLine += $item['line_total'];
                if ($item['price'] < $minPrice) $minPrice = $item['price'];
                if ($item['price'] > $maxPrice) $maxPrice = $item['price'];
            }
            
            $firstItem = $group['items'][0];
            $avgPrice = $totalQty > 0 ? $totalLine / $totalQty : $firstItem['price'];
            
            // Get ALL textures from ALL variants of this product (not just from cart items)
            $allTextures = [];
            $productVariants = ProductVariant::where('product_id', $group['product']->id)
                ->whereHas('texture')
                ->with('texture')
                ->get();
            
            foreach ($productVariants as $pv) {
                if ($pv->texture && $pv->texture->name) {
                    $textureName = $pv->texture->name;
                    if (!in_array($textureName, $allTextures)) {
                        $allTextures[] = $textureName;
                    }
                }
            }
            
            // Merge with textures from cart items (in case there are textures not in variants)
            $allTextures = array_unique(array_merge($allTextures, $group['textures'] ?? []));
            
            $cartData[] = [
                'id' => $firstItem['id'],
                'ids' => array_column($group['items'], 'id'),
                'product' => $group['product'],
                'variant_ids' => array_column($group['items'], 'variant_id'),
                'quantity' => $totalQty,
                'price' => $avgPrice,
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
                'size' => $group['size'],
                'color' => $group['color'] ?? null,
                'textures' => array_values($allTextures), // Ensure all textures are included
                'image_url' => $group['product']->default_image_url,
                'line_total' => $totalLine,
                'items' => $group['items'],
            ];
        }

        // Calculate discount using VoucherService
        $discountData = $this->voucherService->recalculateDiscount($total);
        $voucherData = $this->voucherService->getAppliedVoucher();

        // Get available vouchers for user
        $availableVouchers = $this->getAvailableVouchers($total);
        
        // Get all active shipping carriers
        $shippingCarriers = ShippingCarrier::where('active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('client.carts.shopping', [
            'cartData' => $cartData,
            'total' => $total,
            'discount' => $discountData['discount'],
            'finalTotal' => $discountData['total'],
            'voucher' => $voucherData,
            'availableVouchers' => $availableVouchers,
            'shippingCarriers' => $shippingCarriers
        ]);
    }
    
    /** Get available vouchers for current user */
    private function getAvailableVouchers(float $subtotal): array
    {
        $now = now();
        
        // Get all active vouchers that are valid
        $vouchers = Voucher::where('is_active', true)
            ->where(function($query) use ($now) {
                $query->whereNull('starts_at')
                      ->orWhere('starts_at', '<=', $now);
            })
            ->where(function($query) use ($now) {
                $query->whereNull('ends_at')
                      ->orWhere('ends_at', '>=', $now);
            })
            ->where(function($query) {
                $query->whereNull('usage_limit')
                      ->orWhereRaw('used_count < usage_limit');
            })
            ->where(function($query) use ($subtotal) {
                $query->whereNull('min_order_amount')
                      ->orWhere('min_order_amount', '<=', $subtotal);
            })
            ->orderBy('value', 'desc')
            ->get();
        
        $availableVouchers = [];
        foreach ($vouchers as $voucher) {
            $discount = $this->voucherService->calculateDiscount($voucher, $subtotal);
            $availableVouchers[] = [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'description' => $voucher->description,
                'type' => $voucher->type,
                'value' => $voucher->value,
                'max_discount_amount' => $voucher->max_discount_amount,
                'min_order_amount' => $voucher->min_order_amount,
                'discount_amount' => $discount,
                'discount_display' => $voucher->type === 'percent' 
                    ? $voucher->value . '%' 
                    : number_format($voucher->value, 0, ',', '.') . ' ₫'
            ];
        }
        
        return $availableVouchers;
    }

    /** Add item to cart (redirect only) */
    public function addToCart(Request $request)
    {
        // Log request để debug
        Log::info('=== ADD TO CART REQUEST ===');
        Log::info('Product ID: ' . $request->product_id);
        Log::info('Variant ID: ' . ($request->variant_id ?? 'null'));
        Log::info('Size Name: ' . ($request->input('size_name', '') ?: 'empty'));
        Log::info('Color Name: ' . ($request->input('color_name', '') ?: 'empty'));
        Log::info('Texture Name: ' . ($request->input('texture_name', '') ?: 'empty'));
        Log::info('Quantity: ' . ($request->quantity ?? 1));
        Log::info('All Request Data: ' . json_encode($request->all()));
        
        $product = Product::findOrFail($request->product_id);
        $variant = null;
        
        // Get attribute values from request
        $sizeNameIn = trim((string) $request->input('size_name', ''));
        $colorNameIn = trim((string) $request->input('color_name', ''));
        $textureNameIn = trim((string) $request->input('texture_name', ''));
        
        // Nếu có size_name hoặc color_name, luôn tìm variant mới dựa trên attributes (không dùng variant_id cũ)
        // Điều này đảm bảo khi user chọn màu mới, nó sẽ tìm variant mới thay vì dùng variant_id cũ
        if (!empty($sizeNameIn) || !empty($colorNameIn) || !empty($textureNameIn)) {
            Log::info('Finding variant by attributes - Size: ' . $sizeNameIn . ', Color: ' . $colorNameIn . ', Texture: ' . $textureNameIn);
            
            // Tìm variant dựa trên attributes
            $variant = $this->resolveVariantByAttributes(
                (int) $request->product_id,
                !empty($sizeNameIn) ? $sizeNameIn : null,
                !empty($colorNameIn) ? $colorNameIn : null,
                !empty($textureNameIn) ? $textureNameIn : null
            );
            
            if ($variant) {
                Log::info('Variant found by attributes - ID: ' . $variant->id . ', Size: ' . ($variant->size ? $variant->size->name : 'null') . ', Color: ' . ($variant->color ? $variant->color->name : 'null'));
            } else {
                Log::warning('Variant NOT found by attributes');
            }
            
            if (!$variant) {
                // Nếu không tìm thấy variant, kiểm tra xem có variant nào không
                $allVariants = ProductVariant::where('product_id', (int) $request->product_id)
                    ->with(['size', 'color', 'texture'])
                    ->get();
                
                // Log tất cả variants có sẵn để debug
                Log::warning('Variant NOT found. Available variants for product ' . $request->product_id . ':');
                foreach ($allVariants as $v) {
                    Log::warning('  - Variant ID: ' . $v->id . ', Size: ' . ($v->size ? $v->size->name : 'null') . ', Color: ' . ($v->color ? $v->color->name : 'null') . ', Texture: ' . ($v->texture ? $v->texture->name : 'null'));
                }
                Log::warning('  - Requested: Size=' . $sizeNameIn . ', Color=' . $colorNameIn . ', Texture=' . $textureNameIn);
                
                if ($allVariants->isEmpty()) {
                    $variant = null;
                } else {
                    if ($request->ajax() || $request->wantsJson() || $request->boolean('ajax')) {
                        return response()->json(['success' => false], 422);
                    }
                    return back()->withInput();
                }
            }
        } elseif ($request->filled('variant_id')) {
            // Chỉ dùng variant_id nếu không có size_name, color_name, texture_name
            Log::info('Using variant_id directly: ' . $request->variant_id);
            $variant = ProductVariant::findOrFail($request->variant_id);
        }

        // Validate: if product has variants, a valid variant must be selected
        if ($product->productVariants()->exists() && !$variant) {
            if ($request->ajax() || $request->wantsJson() || $request->boolean('ajax')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng chọn đầy đủ biến thể (kích thước, màu sắc, chất liệu) trước khi thêm vào giỏ.'
                ], 422);
            }
            return back()->with('error', 'Vui lòng chọn đầy đủ biến thể (kích thước, màu sắc, chất liệu).')->withInput();
        }

        // Ensure variant_id is set
        if (!$variant) {
            if ($request->ajax() || $request->wantsJson() || $request->boolean('ajax')) {
                return response()->json(['success' => false], 422);
            }
            return back()->with('error', 'Không tìm thấy biến thể phù hợp.')->withInput();
        }
        
        $variantId = $variant->id;

        $owner = $this->getOwnerKeys();
        
        Log::info('Final Variant ID: ' . $variantId);
        Log::info('Owner: User ID=' . ($owner['user_id'] ?? 'null') . ', Session ID=' . ($owner['session_id'] ?? 'null'));
        
        // Kiểm tra xem đã có variant này chưa
        $existingItem = $this->baseCartQuery()
            ->where('product_id', $request->product_id)
            ->where('variant_id', $variantId)
            ->first();

        if ($existingItem) {
            Log::info('Existing item found - ID: ' . $existingItem->id . ', Current Qty: ' . $existingItem->quantity . ', Adding: ' . $request->quantity);
            // Nếu đã có variant này, tăng quantity
            $existingItem->quantity += (int) $request->quantity;
            $existingItem->save();
            Log::info('Updated Qty: ' . $existingItem->quantity);
        } else {
            Log::info('Creating new cart item - Product ID: ' . $request->product_id . ', Variant ID: ' . $variantId . ', Qty: ' . $request->quantity);
            // Nếu chưa có variant này, tạo mới
            $newCartItem = Cart::create([
                'user_id' => $owner['user_id'],
                'session_id' => $owner['session_id'],
                'product_id' => $request->product_id,
                'variant_id' => $variantId,
                'quantity' => (int) $request->quantity,
            ]);
            Log::info('New cart item created - ID: ' . $newCartItem->id);
        }

        if ($request->ajax() || $request->wantsJson() || $request->boolean('ajax')) {
            $count = (int) $this->baseCartQuery()->sum('quantity');
            $item = $this->baseCartQuery()
                ->where('product_id', $request->product_id)
                ->where('variant_id', $variantId)
                ->with(['product', 'variant.size', 'variant.color', 'variant.texture'])
                ->first();
            $price = $this->resolveItemPrice($product, $variant);
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm vào giỏ hàng',
                'cart_count' => (int) $count,
                'cart_item' => $item ? [
                    'id' => $item->id,
                    'product' => [
                        'id' => $item->product->id,
                        'name' => $item->product->name,
                        'default_image_url' => $item->product->default_image_url,
                    ],
                    'variant' => $item->variant,
                    'variant_id' => $item->variant_id,
                    'quantity' => (int) $item->quantity,
                    'price' => $price,
                ] : null,
            ]);
        }

        return redirect()->route('client.cart.index')->with('success', 'Đã thêm vào giỏ hàng');
    }

    /** Remove item from cart (AJAX-friendly) */
    public function remove(Request $request, $id)
    {
        $owner = $this->getOwnerKeys();
        $cart = $this->baseCartQuery()->where('id', $id)->first();
        
        if ($cart) {
            $cart->delete();
        }
        
        $count = (int) $this->baseCartQuery()->sum('quantity');
        return response()->json(['success' => true, 'cart_count' => $count]);
    }

    public function update(Request $request, $id)
    {
        $qty = max(1, (int)($request->input('quantity', 1)));
        $owner = $this->getOwnerKeys();
        $item = $this->baseCartQuery()->where('id', $id)->with('variant')->first();
        
        if ($item) {
            // Nếu có variant gắn với cart item thì giới hạn số lượng theo tồn kho của variant
            $maxQty = $item->variant && isset($item->variant->quantity)
                ? max(0, (int) $item->variant->quantity)
                : null;

            if ($maxQty !== null && $qty > $maxQty) {
                $qty = $maxQty;
            }

            $item->quantity = $qty;
            $item->save();
            
            // If AJAX request, return updated cart data
            if ($request->ajax() || $request->wantsJson() || $request->boolean('ajax')) {
                // Recalculate totals
                $cartItems = $this->baseCartQuery()
                    ->with([
                        'product.productImages',
                        'product.primaryImage',
                        'product.productVariants.size',
                        'product.productVariants.color',
                        'product.productVariants.texture',
                        'variant.color',
                        'variant.size',
                        'variant.texture'
                    ])
                    ->get();
                
                $grouped = $this->groupCartItems($cartItems);
                $total = $grouped['total'];
                
                // Calculate discount
                $discountData = $this->voucherService->recalculateDiscount($total);
                
                $response = [
                    'success' => true,
                    'subtotal' => $total,
                    'discount' => $discountData['discount'],
                    'total' => $discountData['total'],
                ];

                // Trả thêm thông tin giới hạn số lượng nếu có
                if ($maxQty !== null) {
                    $response['max_quantity'] = $maxQty;
                    $response['current_quantity'] = $qty;
                }

                return response()->json($response);
            }
            
            return response()->json([
                'success' => true,
                'current_quantity' => $qty,
                'max_quantity' => $maxQty,
            ]);
        }
        
        return response()->json(['success' => false], 404);
    }

    /**
     * Lưu lựa chọn đơn vị vận chuyển vào session để dùng ở bước checkout
     */
    public function selectShipping(Request $request)
    {
        $request->validate([
            'shipping_carrier_id' => ['required', 'integer', 'exists:shipping_carriers,id'],
        ]);

        $carrier = ShippingCarrier::where('active', true)
            ->find($request->input('shipping_carrier_id'));

        if (!$carrier) {
            return response()->json([
                'success' => false,
                'message' => 'Đơn vị vận chuyển không khả dụng.',
            ], 422);
        }

        session([
            'cart.shipping_carrier_id' => $carrier->id,
            'cart.shipping_fee' => (float) ($carrier->fee ?? 0),
        ]);

        return response()->json([
            'success' => true,
            'shipping_carrier_id' => $carrier->id,
            'shipping_fee' => (float) ($carrier->fee ?? 0),
        ]);
    }
    
    /** Get cart table HTML (for AJAX reload) */
    public function getCartTable(Request $request)
    {
        $cartItems = $this->baseCartQuery()
            ->with([
                'product.productImages',
                'product.primaryImage',
                'product.productVariants.size',
                'product.productVariants.color',
                'product.productVariants.texture',
                'variant.color',
                'variant.size',
                'variant.texture'
            ])
            ->get();

        $grouped = $this->groupCartItems($cartItems);
        $groupedItems = $grouped['groupedItems'];
        $total = $grouped['total'];
        
        // Convert grouped items to display format
        $cartData = [];
        foreach ($groupedItems as $group) {
            $totalQty = 0;
            $totalLine = 0;
            $minPrice = PHP_INT_MAX;
            $maxPrice = 0;
            
            foreach ($group['items'] as $item) {
                $totalQty += $item['quantity'];
                $totalLine += $item['line_total'];
                if ($item['price'] < $minPrice) $minPrice = $item['price'];
                if ($item['price'] > $maxPrice) $maxPrice = $item['price'];
            }
            
            $firstItem = $group['items'][0];
            $avgPrice = $totalQty > 0 ? $totalLine / $totalQty : $firstItem['price'];
            
            // Get ALL textures from ALL variants of this product (not just from cart items)
            $allTextures = [];
            $productVariants = ProductVariant::where('product_id', $group['product']->id)
                ->whereHas('texture')
                ->with('texture')
                ->get();
            
            foreach ($productVariants as $pv) {
                if ($pv->texture && $pv->texture->name) {
                    $textureName = $pv->texture->name;
                    if (!in_array($textureName, $allTextures)) {
                        $allTextures[] = $textureName;
                    }
                }
            }
            
            // Merge with textures from cart items (in case there are textures not in variants)
            $allTextures = array_unique(array_merge($allTextures, $group['textures'] ?? []));
            
            $cartData[] = [
                'id' => $firstItem['id'],
                'ids' => array_column($group['items'], 'id'),
                'product' => $group['product'],
                'variant_ids' => array_column($group['items'], 'variant_id'),
                'quantity' => $totalQty,
                'price' => $avgPrice,
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
                'size' => $group['size'],
                'color' => $group['color'] ?? null,
                'textures' => array_values($allTextures), // Ensure all textures are included
                'image_url' => $group['product']->default_image_url,
                'line_total' => $totalLine,
                'items' => $group['items'],
            ];
        }

        // Calculate discount
        $discountData = $this->voucherService->recalculateDiscount($total);
        $voucherData = $this->voucherService->getAppliedVoucher();

        // Get available vouchers for user
        $availableVouchers = $this->getAvailableVouchers($total);
        
        // Get all active shipping carriers
        $shippingCarriers = ShippingCarrier::where('active', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('client.carts.partials.table', [
            'cartData' => $cartData,
            'total' => $total,
            'discount' => $discountData['discount'],
            'finalTotal' => $discountData['total'],
            'voucher' => $voucherData,
            'availableVouchers' => $availableVouchers,
            'shippingCarriers' => $shippingCarriers
        ]);
    }

    /** Apply voucher code */
    public function applyVoucher(ApplyVoucherRequest $request)
    {
        $code = $request->validated()['code'];
        $subtotal = $this->calculateSubtotal();

        // Validate voucher
        $validation = $this->voucherService->validateVoucher($code, $subtotal);
        
        if (!$validation['valid']) {
            return response()->json([
                'success' => false,
                'message' => $validation['message']
            ], 422);
        }

        $voucher = $validation['voucher'];

        // Calculate discount
        $discount = $this->voucherService->calculateDiscount($voucher, $subtotal);
        $finalTotal = max(0, $subtotal - $discount);

        // Apply voucher to session
        $this->voucherService->applyToSession($voucher, $discount);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã voucher thành công',
            'voucher' => [
                'code' => $voucher->code,
                'type' => $voucher->type,
                'value' => $voucher->value,
                'description' => $voucher->description
            ],
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => $finalTotal
        ]);
    }

    /** Remove voucher */
    public function removeVoucher(Request $request)
    {
        $this->voucherService->removeFromSession();
        $subtotal = $this->calculateSubtotal();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa mã voucher',
            'subtotal' => $subtotal,
            'discount' => 0,
            'total' => $subtotal
        ]);
    }
}
