<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
            'is_banned' => false,
        ])->each(function($user) {
            Product::factory(rand(1,10))->create(['seller_id' => $user->id])->each(function ($product) {
                ProductImage::factory(rand(1,3))->create(['product_id' => $product->id]);
                // ProductReview::factory(rand(1,5))->create(['user_id' => 1, 'product_id' => $product->id]);
            });
        });

        // User::factory(1)->create();

        User::factory(10)->create(['is_banned' => false])->each(function ($user) {
            Product::factory(rand(1,10))->create(['seller_id' => $user->id])->each(function ($product) {
                ProductImage::factory(rand(1,3))->create(['product_id' => $product->id]);
            });
        });

        $products = Product::all();
        $sellers = User::whereHas('products')->get(['id']);

        User::factory(10)->create(['is_banned' => false])->each(function($user) use($products, $sellers) {
            $seller_id = $sellers->random()->id;
            $seller_product = $products->where('seller_id', $seller_id);
            Order::factory(rand(1,3))->create(['user_id' => $user->id, 'seller_id' => $seller_id])->each(function($order) use($user, $products, $seller_product) {
                $seller_product_count = $seller_product->count();
                $random_products = $seller_product->random(rand(1, $seller_product_count));
                $order->products()->attach($random_products, ['quantity' => random_int(1, 3)]);
                if($order->status == 'Complete') {
                    $order->products()->each(function($product) use($user) {
                        if($product->reviews()->where('user_id', $user->id)->count() == 0) {
                            ProductReview::factory()->create(['user_id' => $user->id, 'product_id' => $product->id]);
                        }
                    });
                }
                $order->total = $order->products()->sum(DB::raw('price * quantity'));
                $order->save();
            });
        });
    }
}
