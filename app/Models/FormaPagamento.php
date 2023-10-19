<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormaPagamento extends Model
{
    use HasFactory;

    protected $table = 'forma_pagamento';
    protected $fillable = [
        'id',
        'holder_name',
        'number',
        'expiry_month',
        'expiry_year',
        'ccv',
        'credit_card_token',
        'credit_card_brand',
        'client_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
