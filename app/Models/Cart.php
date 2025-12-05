<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
	protected $fillable = [
		'user_id',
		'product_id',
		'variant_id',
		'quantity',
		'session_id'
	];

	protected $casts = [
		'quantity' => 'integer',
	];

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function product(): BelongsTo
	{
		return $this->belongsTo(Product::class);
	}

	public function variant(): BelongsTo
	{
		return $this->belongsTo(ProductVariant::class);
	}

	/* ---------------------- Convenience helpers ---------------------- */
	public function scopeOwner($query, ?int $userId, ?string $sessionId)
	{
		return $query->when($userId, fn($q) => $q->where('user_id', $userId))
			->when(!$userId && $sessionId, fn($q) => $q->where('session_id', $sessionId));
	}

	public static function addItem(?int $userId, ?string $sessionId, int $productId, ?int $variantId, int $qty = 1): Cart
	{
		$cart = static::query()
			->owner($userId, $sessionId)
			->where('product_id', $productId)
			->where('variant_id', $variantId)
			->first();

		if ($cart) {
			$cart->quantity = (int) $cart->quantity + max(1, (int) $qty);
			$cart->save();
			return $cart;
		}

		return static::create([
			'user_id' => $userId,
			'session_id' => $sessionId,
			'product_id' => $productId,
			'variant_id' => $variantId,
			'quantity' => max(1, (int) $qty),
		]);
	}

	public static function updateQuantity(?int $userId, ?string $sessionId, int $cartId, int $qty): bool
	{
		$cart = static::query()->owner($userId, $sessionId)->where('id', $cartId)->first();
		if (!$cart) return false;
		$cart->quantity = max(1, (int) $qty);
		return (bool) $cart->save();
	}

	public static function removeItem(?int $userId, ?string $sessionId, int $cartId): bool
	{
		$cart = static::query()->owner($userId, $sessionId)->where('id', $cartId)->first();
		return $cart ? (bool) $cart->delete() : false;
	}

	public static function clearOwner(?int $userId, ?string $sessionId): int
	{
		return (int) static::query()->owner($userId, $sessionId)->delete();
	}

	public static function itemsForOwner(?int $userId, ?string $sessionId)
	{
		return static::query()
			->owner($userId, $sessionId)
			->with(['product', 'variant.size', 'variant.color', 'variant.texture'])
			->get();
	}
}
