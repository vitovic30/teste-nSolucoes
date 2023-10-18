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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_cliente_cus', 20);
            $table->string('codigo_payment', 20);
            $table->string('descricao', 200)->nullable();
            $table->enum('forma_pagamento', ['CREDIT_CARD', 'BOLETO', 'PIX']);
            $table->float('value', 8, 2);
            $table->date('data_vencimento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};
