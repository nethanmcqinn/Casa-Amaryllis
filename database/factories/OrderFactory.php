<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_amount' => fake()->randomFloat(2, 50, 1000),
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'shipping_address' => fake()->streetAddress(),
            'shipping_city' => fake()->city(),
            'shipping_state' => fake()->state(),
            'shipping_zipcode' => fake()->postcode(),
            'payment_method' => fake()->randomElement(['credit_card', 'paypal', 'bank_transfer'])
        ];
    }
}