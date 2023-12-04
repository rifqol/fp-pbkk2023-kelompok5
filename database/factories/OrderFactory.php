<?php

namespace Database\Factories;

use App\Models\Region;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $table->id();
        //     $table->integer('total');
        //     $table->string('status');
        //     $table->string('payment_url');
        //     $table->string('shipment_address');
        //     $table->foreignId('user_id')->constrained();
        //     $table->string('region_code', 13);
        //     $table->foreign('region_code')->references('code')->on('regions');
        //     $table->timestamps();

        return [
            'region_code' => Region::whereRaw('CHAR_LENGTH(code) = 5')->get(['code'])->random(1)->toArray()[0]['code'],
            'status' => fake()->randomElement(['Pending', 'Paid', 'Shipping', 'Complete', 'Cancelled']),
            'user_id' => User::factory(),
            'shipment_address' => fake()->address(),
        ];
    }
}
