<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProductReviewSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        $users = User::where('role', 'customer')->get();

        foreach ($products as $product) {
            $randomUsers = $users->random(rand(0, 3)); // 0-3 reviews per product
            
            foreach ($randomUsers as $user) {
                ProductReview::create([
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'rating' => rand(3, 5), // Mostly positive reviews
                    'comment' => fake()->realText(100)
                ]);
            }
        }
    }
}
