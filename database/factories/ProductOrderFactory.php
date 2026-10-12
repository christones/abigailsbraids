<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductOrder>
 */
class ProductOrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $price = fake()->randomFloat(2, 5, 60);

        return [
            'product_id' => Product::factory(),
            'product_name' => fake()->words(3, true),
            'unit_price' => $price,
            'quantity' => 1,
            'total_price' => $price,
            'client_name' => fake()->name('female'),
            'client_email' => fake()->safeEmail(),
            'client_phone' => fake()->phoneNumber(),
            'notes' => null,
            'status' => ProductOrder::STATUS_PENDING,
        ];
    }
}
