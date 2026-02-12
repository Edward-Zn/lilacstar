<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,

            'price' => $this->price,
            'currency' => $this->currency,

            'inStock' => $this->in_stock,
            'isNew' => $this->is_new,
            'isFeatured' => $this->is_featured,

            'mainImage' => $this->whenLoaded('mainImage', fn() => $this->mainImage?->url),
        ];
    }
}
