<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Roses',
            'Lilies',
            'Tulips',
            'Orchids',
            'Sunflowers',
            'Mixed Bouquets'
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
