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
        Schema::create('delivery_address', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('address_id');
            $table->foreign('address_id')->references('id')->on('address')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('company')->nullable();
            $table->string('street_address_line1');
            $table->string('street_address_line2')->nullable();
            $table->string('town_city')->nullable();
            $table->string('county')->nullable();
            $table->string('postcode');
            $table->string('order_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_address');
    }
};
