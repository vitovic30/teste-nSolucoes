<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Client extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'nome',
        'cpf',
        'data_nascimento',
        'user_id',
        'endereco_id',
        'codigo_cus',
        'forma_pagamento_id',
        'charge_id',
        'product_id'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function endereco(): HasMany
    {
        return $this->hasMany(Endereco::class);
    }

    public function formaPagamento(): HasMany
    {
        return $this->hasMany(FormaPagamento::class);
    }

    public function charge(): HasMany
    {
        return $this->hasMany(Charge::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
