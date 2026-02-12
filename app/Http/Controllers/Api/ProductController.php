<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::query()
            ->where('is_visible', true)
            ->where('slug', $slug)
            ->with(['category', 'images'])
            ->firstOrFail();

        return new ProductResource($product);
    }

    public function featured()
    {
        $products = Product::query()
            ->where('is_visible', true)
            ->where('is_featured', true)
            ->with('mainImage')
            ->orderByDesc('created_at')
            ->limit(24)
            ->get();

        return ProductListResource::collection($products);
    }

    public function newest()
    {
        $products = Product::query()
            ->where('is_visible', true)
            ->with('mainImage')
            ->orderByDesc('created_at')
            ->limit(24)
            ->get();

        return ProductListResource::collection($products);
    }
}
