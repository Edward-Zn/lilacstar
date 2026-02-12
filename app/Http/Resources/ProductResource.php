<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'name' => $this->name,
            'slug' => $this->slug,

            'description' => $this->description,

            'price' => $this->price,
            'currency' => $this->currency,

            'inStock' => $this->in_stock,
            'isNew' => $this->is_new,
            'isFeatured' => $this->is_featured,

            'category' => $this->whenLoaded('category', fn() => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'slug' => $this->category->slug,
            ]),

            'images' => ProductImageResource::collection($this->whenLoaded('images')),
        ];
    }
}
