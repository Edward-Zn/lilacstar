<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DemoCatalogSeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            'Cosmetics',
            'Jewelry',
            'Gift Sets',
        ];

        foreach ($cats as $i => $name) {
            $category = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'sort_order' => $i,
                'is_visible' => true,
            ]);

            for ($p = 1; $p <= 5; $p++) {
                $productName = "$name Item $p";

                Product::create([
                    'category_id' => $category->id,
                    'name' => $productName,
                    'slug' => Str::slug($productName) . '-' . Str::random(5),

                    'description' => 'Demo product description. Editable in admin panel',

                    'price' => ($p % 2 === 0) ? null : (12.50 + $p),
                    'currency' => 'PLN',

                    'is_new' => true,
                    'is_featured' => ($p === 1),
                    'is_visible' => true,
                    'in_stock' => true,
                ]);
            }
        }
    }
}
