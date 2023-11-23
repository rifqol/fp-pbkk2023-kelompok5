<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add regions data
        $this->call(RegionsTableSeeder::class);

        User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'sonwukong233@gmail.com',
            'phone' => '081081081081',
            'is_admin' => true,
        ]);

        // User::factory(1)->create();

        User::factory(10)->create()->each(function ($user) {
            Product::factory(rand(1,3))->create(['seller_id' => $user->id])->each(function ($product) {
                ProductImage::factory(rand(1,3))->create(['product_id' => $product->id]);
                ProductReview::factory(rand(1,3))->create(['user_id' => 1, 'product_id' => $product->id]);
            });
        });
    }
}
