<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            Product::factory()
                ->count(3)
                ->create([
                    'category_id' => $category->id,
                    'stock' => rand(5, 20)
                ]);
        }
    }
}
