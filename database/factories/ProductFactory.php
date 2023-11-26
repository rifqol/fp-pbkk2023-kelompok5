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
        // <option value="Books" {{old('type') == 'Books' ? 'selected' : ''}}>Books</option>
        //                     <option value="E-Books" {{old('type') == 'E-Books' ? 'selected' : ''}}>E-Books</option>
        //                     <option value="Gadgets" {{old('type') == 'Gadgets' ? 'selected' : ''}}>Gadgets</option>
        //                     <option value="Furniture" {{old('type') == 'Furniture' ? 'selected' : ''}}>Furniture</option>
        //                     <option value="Appliances" {{old('type') == 'Appliances' ? 'selected' : ''}}>Appliances</option>
        //                     <option value="Software" {{old('type') == 'Software' ? 'selected' : ''}}>Software</option>
        //                     <option value="Music" {{old('type') == 'Music' ? 'selected' : ''}}>Music</option>
        //                     <option value="Other" {{old('type') == 'Other' ? 'selected' : ''}}>Other</option>

        return [
            'is_public' => fake()->randomElement([true, false]),
            'name' => fake()->word(),
            'type' => fake()->randomElement(['Books', 'E-Books', 'Gadgets', 'Furniture', 'Appliances', 'Software', 'Music', 'Food', 'Other']),
            'condition' => fake()->randomElement(['New', 'Used', 'Refurbished']),
            'description' => fake()->realText(),
            'price' => random_int(10000, 10000000),
            'stock' => random_int(1,100),
            'seller_id' => User::factory(),
        ];
    }
}
