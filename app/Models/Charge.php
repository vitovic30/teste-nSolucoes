<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'codigo_cliente_cus',
        'codigo_payment',
        'descricao',
        'forma_pagamento',
        'value',
        'data_vencimento'
    ];
}
