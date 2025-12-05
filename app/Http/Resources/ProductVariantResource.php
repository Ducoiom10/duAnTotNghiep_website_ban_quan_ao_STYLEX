<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'price' => (float)$this->price,
            'image' => $this->image,
            'color' => $this->whenLoaded('color', fn() => ['id'=>$this->color->id,'name'=>$this->color->name]),
            'size' => $this->whenLoaded('size', fn() => ['id'=>$this->size->id,'name'=>$this->size->name]),
            'attributes' => $this->attributes,
        ];
    }
}
