<?php

namespace App\Services;

use App\Models\Voucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class VoucherService
{
    /**
     * Minimum order amount required to apply voucher (in VNĐ)
     */
    private const MIN_ORDER_AMOUNT = 100000;

    /**
     * Validate voucher code
     *
     * @param string $code
     * @param float $subtotal
     * @return array ['valid' => bool, 'voucher' => Voucher|null, 'message' => string]
     */
    public function validateVoucher(string $code, float $subtotal): array
    {
        // Check minimum order amount (system-wide requirement)
        if ($subtotal < self::MIN_ORDER_AMOUNT) {
            return [
                'valid' => false,
                'voucher' => null,
                'message' => 'Đơn hàng tối thiểu ' . number_format(self::MIN_ORDER_AMOUNT, 0, ',', '.') . ' VNĐ mới được áp dụng mã voucher'
            ];
        }

        // Find voucher
        $voucher = Voucher::where('code', $code)
            ->where('is_active', true)
            ->first();

        if (!$voucher) {
            return [
                'valid' => false,
                'voucher' => null,
                'message' => 'Mã voucher không tồn tại hoặc đã bị vô hiệu hóa'
            ];
        }

        $now = now();

        // Check if voucher has started
        if ($voucher->starts_at) {
            $startsAt = Carbon::parse($voucher->starts_at);
            if ($startsAt->isFuture()) {
                return [
                    'valid' => false,
                    'voucher' => $voucher,
                    'message' => 'Mã voucher chưa có hiệu lực. Voucher sẽ có hiệu lực từ ' . $startsAt->format('d/m/Y H:i')
                ];
            }
        }

        // Check if voucher has expired
        if ($voucher->ends_at) {
            $endsAt = Carbon::parse($voucher->ends_at);
            if ($endsAt->isPast()) {
                return [
                    'valid' => false,
                    'voucher' => $voucher,
                    'message' => 'Mã voucher đã hết hạn. Voucher đã hết hạn từ ' . $endsAt->format('d/m/Y H:i')
                ];
            }
        }

        // Check minimum order amount
        if ($voucher->min_order_amount && $subtotal < $voucher->min_order_amount) {
            return [
                'valid' => false,
                'voucher' => $voucher,
                'message' => 'Đơn hàng tối thiểu ' . number_format($voucher->min_order_amount, 0, ',', '.') . ' VNĐ để sử dụng mã này'
            ];
        }

        // Check usage limit
        if ($voucher->usage_limit && $voucher->used_count >= $voucher->usage_limit) {
            return [
                'valid' => false,
                'voucher' => $voucher,
                'message' => 'Mã voucher đã hết lượt sử dụng'
            ];
        }

        return [
            'valid' => true,
            'voucher' => $voucher,
            'message' => 'Voucher hợp lệ'
        ];
    }

    /**
     * Calculate discount amount
     *
     * @param Voucher $voucher
     * @param float $subtotal
     * @return float
     */
    public function calculateDiscount(Voucher $voucher, float $subtotal): float
    {
        $discount = 0;

        if ($voucher->type === 'percent') {
            $discount = ($subtotal * $voucher->value) / 100;
            
            // Apply max discount if set
            if ($voucher->max_discount_amount && $discount > $voucher->max_discount_amount) {
                $discount = $voucher->max_discount_amount;
            }
        } elseif ($voucher->type === 'fixed') {
            $discount = $voucher->value;
            
            // Don't exceed subtotal
            if ($discount > $subtotal) {
                $discount = $subtotal;
            }
        }

        return max(0, $discount);
    }

    /**
     * Apply voucher to session
     *
     * @param Voucher $voucher
     * @param float $discount
     * @return void
     */
    public function applyToSession(Voucher $voucher, float $discount): void
    {
        Session::put('cart.voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'type' => $voucher->type,
            'value' => $voucher->value,
            'discount' => $discount
        ]);
    }

    /**
     * Remove voucher from session
     *
     * @return void
     */
    public function removeFromSession(): void
    {
        Session::forget('cart.voucher');
    }

    /**
     * Get applied voucher from session
     *
     * @return array|null
     */
    public function getAppliedVoucher(): ?array
    {
        return Session::get('cart.voucher');
    }

    /**
     * Recalculate discount for applied voucher
     *
     * @param float $subtotal
     * @return array ['discount' => float, 'total' => float]
     */
    public function recalculateDiscount(float $subtotal): array
    {
        $voucherData = $this->getAppliedVoucher();
        
        if (!$voucherData) {
            return [
                'discount' => 0,
                'total' => $subtotal
            ];
        }

        // Check minimum order amount - remove voucher if order is too small
        if ($subtotal < self::MIN_ORDER_AMOUNT) {
            $this->removeFromSession();
            return [
                'discount' => 0,
                'total' => $subtotal
            ];
        }

        $voucher = Voucher::find($voucherData['id']);
        
        if (!$voucher) {
            $this->removeFromSession();
            return [
                'discount' => 0,
                'total' => $subtotal
            ];
        }

        // Re-validate voucher với subtotal hiện tại (bao gồm min_order_amount, thời gian, lượt dùng...)
        $validation = $this->validateVoucher($voucher->code, $subtotal);
        if (!$validation['valid'] || !$validation['voucher']) {
            $this->removeFromSession();
            return [
                'discount' => 0,
                'total' => $subtotal
            ];
        }

        $voucher = $validation['voucher'];
        $discount = $this->calculateDiscount($voucher, $subtotal);
        
        // Update discount in session
        $voucherData['discount'] = $discount;
        Session::put('cart.voucher', $voucherData);

        $finalTotal = max(0, $subtotal - $discount);

        return [
            'discount' => $discount,
            'total' => $finalTotal
        ];
    }
}

