<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        // $this là Product model
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'name' => $this->name,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'price' => (float) ($this->price ?? 0),
            'price_sale' => $this->price_sale !== null ? (float)$this->price_sale : null,
            'base_price' => (float) ($this->base_price ?? 0),
            'total_stock' => (int) ($this->total_stock ?? 0),
            'default_image' => $this->default_image,
            'default_image_url' => $this->default_image_url,
            'is_active' => (bool)$this->is_active,
            'visibility' => $this->visibility,
            'brand' => $this->whenLoaded('brand', function() {
                return [
                    'id' => $this->brand->id ?? null,
                    'name' => $this->brand->name ?? null,
                ];
            }),
            'category' => $this->whenLoaded('category', function() {
                return [
                    'id' => $this->category->id ?? null,
                    'name' => $this->category->name ?? null,
                ];
            }),
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),
            'images' => $this->whenLoaded('images', function() {
                return $this->images->map(fn($img)=>[
                    'id'=>$img->id,
                    'image_url'=>$img->image_url,
                    'is_main'=>$img->is_main,
                    'sort_order'=>$img->sort_order
                ]);
            }),
        ];
    }
}
