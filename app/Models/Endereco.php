<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cep',
        'logradouro',
        'complemento',
        'bairro',
        'localidade',
        'uf'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
