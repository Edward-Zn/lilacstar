<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductListResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->where('is_visible', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function products(Request $request, string $slug)
    {
        $category = Category::query()
            ->where('is_visible', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $sort = $request->query('sort', 'newest');

        $query = $category->products()
            ->where('is_visible', true)
            ->with('mainImage');

        $query = match ($sort) {
            'price_asc' => $query->orderByRaw('price IS NULL, price ASC'),
            'price_desc' => $query->orderByRaw('price IS NULL, price DESC'),
            default => $query->orderByDesc('created_at'),
        };

        return ProductListResource::collection($query->paginate(24));
    }
}
