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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_public')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->string('name');
            $table->string('type');
            $table->string('condition');
            $table->text('description');
            $table->integer('price');
            $table->integer('stock')->default(1);
            $table->foreignId('seller_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
