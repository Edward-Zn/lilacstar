<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductAdminController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with('category:id,name')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'data' => $products,
        ]);
    }

    public function show(Product $product)
    {
        $product->load([
            'category:id,name',
            'images',
        ]);

        return response()->json([
            'data' => $product,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'is_featured' => ['required', 'boolean'],
            'is_new' => ['required', 'boolean'],
            'is_visible' => ['required', 'boolean'],
            'in_stock' => ['required', 'boolean'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product = Product::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'] ?? null,
            'currency' => strtoupper($data['currency']),
            'is_featured' => $data['is_featured'],
            'is_new' => $data['is_new'],
            'is_visible' => $data['is_visible'],
            'in_stock' => $data['in_stock'],
        ]);

        return response()->json([
            'data' => $product->load('category:id,name'),
        ], 201);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product->id),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'is_featured' => ['required', 'boolean'],
            'is_new' => ['required', 'boolean'],
            'is_visible' => ['required', 'boolean'],
            'in_stock' => ['required', 'boolean'],
        ]);

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'price' => $data['price'] ?? null,
            'currency' => strtoupper($data['currency']),
            'is_featured' => $data['is_featured'],
            'is_new' => $data['is_new'],
            'is_visible' => $data['is_visible'],
            'in_stock' => $data['in_stock'],
        ]);

        return response()->json([
            'data' => $product->fresh()->load('category:id,name'),
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
