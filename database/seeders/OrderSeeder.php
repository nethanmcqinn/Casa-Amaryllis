<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // Create some regular users if they don't exist
        $users = User::factory()->count(3)->create(['role' => 'user']);

        // Get or create some products
        $products = Product::factory()->count(5)->create();

        // Create orders for each user
        foreach ($users as $user) {
            // Create 2-4 orders per user
            $orderCount = rand(2, 4);
            
            for ($i = 0; $i < $orderCount; $i++) {
                // Create order with detailed shipping information
                $order = Order::factory()->create([
                    'user_id' => $user->id,
                    'status' => fake()->randomElement(['pending', 'processing', 'shipped', 'completed', 'cancelled']),
                    'payment_method' => fake()->randomElement(['credit_card', 'cash_on_delivery']),
                    'shipping_address' => fake()->streetAddress(),
                    'shipping_city' => fake()->city(),
                    'shipping_state' => fake()->state(),
                    'shipping_zipcode' => fake()->postcode(),
                ]);

                // Add 1-3 items to each order
                $itemCount = rand(1, 3);
                $totalAmount = 0;

                // Create order items with proper price calculation
                for ($j = 0; $j < $itemCount; $j++) {
                    $product = $products->random();
                    $quantity = rand(1, 3);
                    $price = $product->price;

                    OrderItem::factory()->create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price
                    ]);

                    // Calculate subtotal for each item
                    $totalAmount += $price * $quantity;
                }

                // Update order total (shipping is free as per requirement)
                $order->update(['total_amount' => $totalAmount]);
            }
        }
    }
}