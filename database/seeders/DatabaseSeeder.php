<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'sonwukong233@gmail.com',
            'phone' => '081081081081',
            'is_admin' => true,
        ]);

        User::factory(20)->create();

        $users = User::all();

        

        // table->id();
        //     $table->string('name');
        //     $table->string('username');
        //     $table->string('email')->unique();
        //     $table->string('phone');
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('photo_url')->nullable();
        //     $table->string('password');
        //     $table->string('bank_actnumber')->nullable();
        //     $table->boolean('is_admin')->default(false);
        //     $table->rememberToken();
        //     $table->timestamps();
    }
}
