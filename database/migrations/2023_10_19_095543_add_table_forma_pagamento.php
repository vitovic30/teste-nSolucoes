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
        Schema::create('forma_pagamento', function (Blueprint $table) {
            $table->id();
            $table->string('holder_name', 20);
            $table->string('number', 40);
            $table->string('expiry_month', 3);
            $table->string('expiry_year', 5);
            $table->string('ccv', 4);
            $table->string('credit_card_brand', 10);
            $table->string('credit_card_token', 100);
            $table->unsignedBigInteger('client_id')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forma_pagamento');
    }
};
