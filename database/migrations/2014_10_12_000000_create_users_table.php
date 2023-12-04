<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone');
            $table->string('region_code', 13);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('photo_url')->nullable();
            $table->string('password');
            $table->string('bank_actnumber')->nullable();
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_banned')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->foreign('region_code')->references('code')->on('regions');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
