<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'is_public' => fake()->randomElement([true, false]),
            'name' => fake()->word(),
            'type' => fake()->randomElement(['Vehicle', 'Food', 'Electronics', 'Other']),
            'condition' => fake()->randomElement(['New', 'Good', 'Bad', 'Not Working']),
            'description' => fake()->realText(),
            'price' => random_int(10000, 10000000),
            'stock' => random_int(1,100),
            'seller_id' => User::factory(),
        ];
    }
}
