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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('total')->nullable();
            $table->string('status');
            $table->string('tracking_number')->nullable();
            $table->string('external_id')->nullable();
            $table->string('payment_url')->nullable();
            $table->string('shipment_address');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('seller_id')->constrained('users');
            $table->string('region_code', 13);
            $table->foreign('region_code')->references('code')->on('regions');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
